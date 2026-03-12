<?php

declare(strict_types=1);

namespace Golampi\Visitors;

use Golampi\interpreter\Symbol;
use Golampi\interpreter\SymbolTable;
use Golampi\interpreter\Type;
use Golampi\interpreter\BuiltIns;
use Golampi\interpreter\TypeSystem;
use Golampi\Utils\ErrorHandler;
use Context\AdditionContext;
use Context\AssignmentContext;
use Context\BlockContext;
use Context\CaseClauseContext;
use Context\ComparisonContext;
use Context\EqualityContext;
use Context\ForStmtContext;
use Context\FunctionCallContext;
use Context\FunctionDeclContext;
use Context\IfStmtContext;
use Context\LogicalAndContext;
use Context\LogicalOrContext;
use Context\MultiplicationContext;
use Context\ProgramContext;
use Context\ReturnStmtContext;
use Context\SwitchStmtContext;
use Context\UnaryContext;

/**
 * Análisis semántico completo según el PDF oficial de Golampi.
 * Todas las validaciones de operadores usan TypeSystem (matrices del PDF).
 * No se asumen reglas de Go ni promociones implícitas.
 */
class SemanticVisitor extends \GolampiBaseVisitor
{
    private int $mainCount = 0;
    /** @var array<string> */
    private array $functions = [];

    private SymbolTable $symbolTable;
    private ErrorHandler $errorHandler;

    private int $loopDepth = 0;
    private int $switchDepth = 0;
    private ?Type $currentFunctionReturnType = null;
    /** @var list<Type>|null Tipos de retorno de la función actual (múltiples). */
    private ?array $currentFunctionReturnTypes = null;
    private bool $currentFunctionIsMain = false;
    /** Si la función actual tiene tipo de retorno distinto de nil, debe tener al menos un return. */
    private bool $currentFunctionHasReturn = false;

    public function __construct(?ErrorHandler $errorHandler = null)
    {
        $this->symbolTable = new SymbolTable();
        $this->errorHandler = $errorHandler ?? new ErrorHandler();
    }

    public function getSymbolTable(): SymbolTable
    {
        return $this->symbolTable;
    }

    public function getErrorHandler(): ErrorHandler
    {
        return $this->errorHandler;
    }

    /** @return array<string> */
    public function getFunctions(): array
    {
        return $this->functions;
    }

    public function hasErrors(): bool
    {
        return $this->errorHandler->hasErrors();
    }

    // -------------------------------------------------------------------------
    // FASE 1 — Hoisting real: dos pasadas (registro de funciones, luego análisis de cuerpos)
    // -------------------------------------------------------------------------

    public function visitProgram(ProgramContext $context): mixed
    {
        $this->mainCount = 0;
        $this->functions = [];

        $decls = $context->topLevelDecl(null);
        $decls = is_array($decls) ? $decls : [$decls];
        $decls = array_values(array_filter($decls));

        // Primera pasada: registrar TODAS las funciones en scope global (nombre, params, returns, línea/col).
        foreach ($decls as $top) {
            $func = $top->functionDecl();
            if ($func !== null) {
                $this->registerFunctionSignature($func);
            }
        }

        if ($this->mainCount === 0) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                'El programa debe definir exactamente una función main.'
            );
        } elseif ($this->mainCount > 1) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "Solo puede existir una función main. Encontradas: {$this->mainCount}."
            );
        }

        // Segunda pasada: analizar cuerpos (vars/consts globales y cuerpos de funciones).
        foreach ($decls as $top) {
            if ($top->varDecl() !== null) {
                $this->visitVarDecl($top->varDecl());
            } elseif ($top->constDecl() !== null) {
                $this->visitConstDecl($top->constDecl());
            } elseif ($top->functionDecl() !== null) {
                $this->visitFunctionDeclBody($top->functionDecl());
            }
        }

        return null;
    }

    /**
     * Primera pasada: registra la firma de la función en scope global.
     * No visita el cuerpo. Soporta múltiples tipos de retorno.
     */
    private function registerFunctionSignature(FunctionDeclContext $context): void
    {
        $name = $context->IDENTIFIER() !== null ? $context->IDENTIFIER()->getText() : '';
        $this->functions[] = $name;

        $hasParams = $context->parameters() !== null && $context->parameters()->parameter(0) !== null;
        $hasReturn = $context->returnType() !== null;

        if ($name === 'main') {
            $this->mainCount++;
            if ($hasParams) {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($context),
                    'La función main no puede tener parámetros.'
                );
            }
            if ($hasReturn) {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($context),
                    'La función main no puede tener tipo de retorno.'
                );
            }
        }

        $returnTypes = [];
        if ($context->returnType() !== null) {
            $rtCtx = $context->returnType();
            $types = $rtCtx->type(null);
            $types = is_array($types) ? $types : [$types];
            foreach ($types as $t) {
                if ($t !== null) {
                    $returnTypes[] = $this->resolveType($t);
                }
            }
        }
        $returnType = $returnTypes[0] ?? Type::nil();

        $paramTypes = [];
        if ($context->parameters() !== null) {
            $params = $context->parameters()->parameter(null);
            $params = is_array($params) ? $params : [$params];
            foreach ($params as $p) {
                if ($p === null) continue;
                $pt = $p->type();
                $paramTypes[] = $pt !== null ? $this->resolveType($pt) : Type::int32();
            }
        }

        [$line, $col] = $this->lineCol($context);
        $funcSymbol = new Symbol($name, $returnType, 'function', $line, $col, $paramTypes, $returnTypes);
        try {
            $this->symbolTable->define($name, $funcSymbol);
        } catch (\Throwable $e) {
            $this->errorHandler->add('Semántico', $this->lineCol($context), $e->getMessage());
        }
    }

    /**
     * Segunda pasada: analiza el cuerpo de la función (scope, parámetros, bloque, validación de return).
     */
    private function visitFunctionDeclBody(FunctionDeclContext $context): void
    {
        $name = $context->IDENTIFIER() !== null ? $context->IDENTIFIER()->getText() : '';
        $sym = $this->symbolTable->resolve($name);
        $returnType = $sym !== null ? $sym->type : Type::nil();
        $returnTypes = $sym->returnTypes ?? [$returnType];

        $prevReturn = $this->currentFunctionReturnType;
        $prevReturnTypes = $this->currentFunctionReturnTypes;
        $prevMain = $this->currentFunctionIsMain;
        $prevHasReturn = $this->currentFunctionHasReturn;
        $this->currentFunctionReturnType = $name === 'main' ? null : $returnType;
        $this->currentFunctionReturnTypes = $name === 'main' ? null : $returnTypes;
        $this->currentFunctionIsMain = $name === 'main';
        $this->currentFunctionHasReturn = false;

        $this->symbolTable->pushScope();
        if ($context->parameters() !== null) {
            $params = $context->parameters()->parameter(null);
            $params = is_array($params) ? $params : [$params];
            foreach ($params as $p) {
                if ($p === null) continue;
                $pid = $p->IDENTIFIER();
                if ($pid !== null) {
                    $pname = $pid->getText();
                    $ptype = $p->type() !== null ? $this->resolveType($p->type()) : Type::int32();
                    [$pl, $pc] = $this->lineCol($p);
                    try {
                        $this->symbolTable->define(
                            $pname,
                            new Symbol($pname, $ptype, 'parameter', $pl, $pc)
                        );
                    } catch (\Throwable $e) {
                        $this->errorHandler->add('Semántico', $this->lineCol($p), $e->getMessage());
                    }
                }
            }
        }
        $block = $context->block();
        if ($block !== null) {
            $this->visitBlock($block);
        }
        $this->symbolTable->popScope();

        if (
            $this->currentFunctionReturnType !== null
            && !$this->currentFunctionReturnType->equals(Type::nil())
            && !$this->currentFunctionHasReturn
        ) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "La función con tipo de retorno debe tener al menos un 'return' con expresión."
            );
        }

        if (
            $this->currentFunctionReturnType !== null
            && !$this->currentFunctionReturnType->equals(Type::nil())
            && $name !== 'main'
        ) {
            if ($block !== null && !$this->blockGuaranteesReturn($block)) {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($context),
                    'No todas las rutas retornan un valor.'
                );
            }
        }

        $this->currentFunctionReturnType = $prevReturn;
        $this->currentFunctionReturnTypes = $prevReturnTypes;
        $this->currentFunctionIsMain = $prevMain;
        $this->currentFunctionHasReturn = $prevHasReturn;
    }

    public function visitFunctionDecl(FunctionDeclContext $context): mixed
    {
        return null;
    }

    public function visitBlock(BlockContext $context): mixed
    {
        $this->symbolTable->pushScope();
        $result = $this->visitChildren($context);
        $this->symbolTable->popScope();
        return $result;
    }

    // -------------------------------------------------------------------------
    // Declaraciones: var, :=, const
    // -------------------------------------------------------------------------

    public function visitVarDecl(\Context\VarDeclContext $context): mixed
    {
        $typeCtx = $context->type();
        $type = $typeCtx !== null ? $this->resolveType($typeCtx) : Type::int32();
        $exprList = $context->expressionList();
        if ($type->isArray() && $type->arrayInfo !== null && $exprList !== null) {
            $exprs = $exprList->expression(null);
            $exprs = is_array($exprs) ? $exprs : [$exprs];
            $exprs = array_values(array_filter($exprs));
            if (count($exprs) === 1) {
                $arrLit = $this->getArrayLiteralFromExpression($exprs[0]);
                if ($arrLit !== null) {
                    $expectedLen = $type->arrayInfo['length'] ?? null;
                    if ($expectedLen !== null) {
                        $actualCount = $this->countArrayLiteralElements($arrLit);
                        if ($actualCount !== $expectedLen) {
                            $this->errorHandler->add(
                                'Semántico',
                                $this->lineCol($context),
                                "El literal de array tiene $actualCount elementos; se esperaban $expectedLen."
                            );
                        }
                    }
                }
            }
        }
        $idList = $context->identifierList();
        if ($idList === null) {
            return $this->visitChildren($context);
        }
        $ids = $idList->IDENTIFIER(null);
        $ids = is_array($ids) ? $ids : [$ids];
        foreach ($ids as $tok) {
            if ($tok === null) {
                continue;
            }
            $name = $tok->getText();
            $line = $tok->getSymbol() !== null ? $tok->getSymbol()->getLine() : 0;
            $col = $tok->getSymbol() !== null ? $tok->getSymbol()->getCharPositionInLine() : 0;
            try {
                $this->symbolTable->define($name, new Symbol($name, $type, 'variable', $line, $col));
            } catch (\Throwable $e) {
                $this->errorHandler->add('Semántico', [$line, $col], $e->getMessage());
            }
        }
        return $this->visitChildren($context);
    }

    private function getArrayLiteralFromExpression(?\Context\ExpressionContext $expr): ?\Context\ArrayLiteralContext
    {
        if ($expr === null) return null;
        $prim = $this->getPrimaryFromExpression($expr);
        return $prim !== null ? $prim->arrayLiteral() : null;
    }

    private function countArrayLiteralElements(\Context\ArrayLiteralContext $ctx): int
    {
        $body = $ctx->arrayLiteralBody();
        if ($body === null) return 0;
        $list = $body->arrayElementList();
        if ($list === null) return 0;
        $el = $list->arrayElement(null);
        $el = is_array($el) ? $el : [$el];
        return count(array_filter($el));
    }

    public function visitShortVarDecl(\Context\ShortVarDeclContext $context): mixed
    {
        $idList = $context->identifierList();
        $exprList = $context->expressionList();
        if ($idList === null) {
            return $this->visitChildren($context);
        }
        $ids = $idList->IDENTIFIER(null);
        $ids = is_array($ids) ? $ids : [$ids];
        $ids = array_values(array_filter($ids));
        $exprs = $exprList !== null ? $exprList->expression(null) : [];
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        $exprs = array_values(array_filter($exprs));
        $n = count($ids);
        $m = $this->getRhsValueCount($exprs);
        if ($n !== $m) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                'La cantidad de variables en la asignación no coincide con la cantidad de valores retornados.'
            );
        }
        $typesForIds = $this->inferTypesForShortVarDecl($ids, $exprs);
        $allAlreadyDefined = true;
        foreach ($ids as $tok) {
            if ($tok === null) continue;
            if (!$this->symbolTable->isDefinedInCurrentScope($tok->getText())) {
                $allAlreadyDefined = false;
                break;
            }
        }
        if ($allAlreadyDefined && count($ids) > 0) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                'En declaración corta (:=) debe haber al menos una variable nueva.'
            );
        }
        foreach ($ids as $idx => $tok) {
            if ($tok === null) continue;
            $name = $tok->getText();
            $line = $tok->getSymbol() !== null ? $tok->getSymbol()->getLine() : 0;
            $col = $tok->getSymbol() !== null ? $tok->getSymbol()->getCharPositionInLine() : 0;
            if ($this->symbolTable->isDefinedInCurrentScope($name)) {
                continue;
            }
            $inferred = $typesForIds[$idx] ?? Type::int32();
            try {
                $this->symbolTable->define(
                    $name,
                    new Symbol($name, $inferred, 'variable', $line, $col)
                );
            } catch (\Throwable $e) {
                $this->errorHandler->add('Semántico', [$line, $col], $e->getMessage());
            }
        }
        return $this->visitChildren($context);
    }

    /**
     * Número de valores que produce el RHS (solo semántica, sin ejecutar).
     * Si RHS es una sola llamada a función → count(returnTypes); si no, count(expressions).
     * @param list<\Context\ExpressionContext> $exprs
     */
    private function getRhsValueCount(array $exprs): int
    {
        if (count($exprs) === 0) {
            return 0;
        }
        if (count($exprs) === 1 && $exprs[0] !== null) {
            $fc = $this->getFunctionCallFromExpression($exprs[0]);
            if ($fc !== null) {
                $qual = $fc->qualifiedIdentifier();
                $tokens = $qual !== null ? $qual->IDENTIFIER(null) : [];
                $tokens = is_array($tokens) ? $tokens : [$tokens];
                $tokens = array_values(array_filter($tokens));
                if (count($tokens) === 1 && $tokens[0] !== null) {
                    $sym = $this->symbolTable->resolve($tokens[0]->getText());
                    if ($sym !== null && $sym->isFunction() && $sym->returnTypes !== null) {
                        return count($sym->returnTypes);
                    }
                }
            }
        }
        return count($exprs);
    }

    /**
     * Infiere tipo por cada LHS de una declaración corta (una o varias variables).
     * Si el RHS es una sola llamada a función con múltiples retornos, usa esos tipos.
     * @param array $ids lista de tokens IDENTIFIER
     * @param array $exprs lista de expresiones del RHS
     * @return array<int, Type> índice => tipo
     */
    private function inferTypesForShortVarDecl(array $ids, array $exprs): array
    {
        $n = count($ids);
        $types = [];
        if (count($exprs) === 1 && $exprs[0] !== null) {
            $fc = $this->getFunctionCallFromExpression($exprs[0]);
            if ($fc !== null) {
                $qual = $fc->qualifiedIdentifier();
                $tokens = $qual !== null ? $qual->IDENTIFIER(null) : [];
                $tokens = is_array($tokens) ? $tokens : [$tokens];
                $tokens = array_values(array_filter($tokens));
                $name = $tokens[0] !== null ? $tokens[0]->getText() : '';
                $sym = count($tokens) === 1 ? $this->symbolTable->resolve($name) : null;
                if ($sym !== null && $sym->isFunction() && $sym->returnTypes !== null && count($sym->returnTypes) === $n) {
                    foreach ($sym->returnTypes as $i => $t) {
                        $types[$i] = $t;
                    }
                    return $types;
                }
            }
        }
        for ($i = 0; $i < $n; $i++) {
            $e = $exprs[$i] ?? null;
            $types[$i] = $e !== null ? ($this->getExpressionType($e) ?? Type::int32()) : Type::int32();
        }
        return $types;
    }

    private function getFunctionCallFromExpression(?\Context\ExpressionContext $expr): ?\Context\FunctionCallContext
    {
        if ($expr === null) return null;
        $lo = $expr->logicalOr(0);
        if ($lo === null) return null;
        $la = $lo->logicalAnd(0);
        if ($la === null) return null;
        $eq = $la->equality(0);
        if ($eq === null) return null;
        $cmp = $eq->comparison(0);
        if ($cmp === null) return null;
        $add = $cmp->addition(0);
        if ($add === null) return null;
        $mul = $add->multiplication(0);
        if ($mul === null) return null;
        $un = $mul->unary(0);
        if ($un === null) return null;
        $prim = $un->primary();
        return $prim !== null ? $prim->functionCall() : null;
    }

    public function visitConstDecl(\Context\ConstDeclContext $context): mixed
    {
        $id = $context->IDENTIFIER();
        if ($id === null) {
            return $this->visitChildren($context);
        }
        $name = $id->getText();
        $typeCtx = $context->type();
        $type = $typeCtx !== null ? $this->resolveType($typeCtx) : Type::int32();
        $expr = $context->expression();
        if ($expr === null) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "La constante '$name' debe tener inicialización obligatoria."
            );
        }
        $line = $id->getSymbol() !== null ? $id->getSymbol()->getLine() : 0;
        $col = $id->getSymbol() !== null ? $id->getSymbol()->getCharPositionInLine() : 0;
        try {
            $this->symbolTable->define($name, new Symbol($name, $type, 'constant', $line, $col));
        } catch (\Throwable $e) {
            $this->errorHandler->add('Semántico', [$line, $col], $e->getMessage());
        }
        return $this->visitChildren($context);
    }

    public function visitQualifiedIdentifier(\Context\QualifiedIdentifierContext $context): mixed
    {
        $tokens = $context->IDENTIFIER(null);
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        if (count($tokens) === 1 && $tokens[0] !== null) {
            $name = $tokens[0]->getText();
            if (BuiltIns::isBuiltIn($name)) {
                return $this->visitChildren($context);
            }
            $sym = $this->symbolTable->resolve($name);
            if ($sym === null) {
                $line = $tokens[0]->getSymbol() !== null ? $tokens[0]->getSymbol()->getLine() : 0;
                $col = $tokens[0]->getSymbol() !== null ? $tokens[0]->getSymbol()->getCharPositionInLine() : 0;
                $this->errorHandler->add(
                    'Semántico',
                    [$line, $col],
                    "Variable o identificador '$name' no declarado."
                );
            }
        }
        return $this->visitChildren($context);
    }

    // -------------------------------------------------------------------------
    // Control de flujo: if, for, switch, case — scopes y condiciones bool
    // -------------------------------------------------------------------------

    public function visitIfStmt(IfStmtContext $context): mixed
    {
        $expr = $context->expression();
        if ($expr !== null) {
            $condType = $this->getExpressionType($expr);
            if ($condType !== null && TypeSystem::primitiveName($condType) !== 'bool') {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($expr),
                    "La condición del 'if' debe ser de tipo bool."
                );
            }
        }
        return $this->visitChildren($context);
    }

    public function visitForStmt(ForStmtContext $context): mixed
    {
        $this->loopDepth++;
        $expr = $context->expression();
        if ($expr === null && $context->forClause() !== null) {
            $fc = $context->forClause();
            if ($fc !== null) {
                $mid = $fc->expression();
                if ($mid !== null) {
                    $condType = $this->getExpressionType($mid);
                    if ($condType !== null && TypeSystem::primitiveName($condType) !== 'bool') {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($mid),
                            "La condición del 'for' debe ser de tipo bool."
                        );
                    }
                }
            }
        } elseif ($expr !== null) {
            $condType = $this->getExpressionType($expr);
            if ($condType !== null && TypeSystem::primitiveName($condType) !== 'bool') {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($expr),
                    "La condición del 'for' debe ser de tipo bool."
                );
            }
        }
        $result = $this->visitChildren($context);
        $this->loopDepth--;
        return $result;
    }

    public function visitSwitchStmt(SwitchStmtContext $context): mixed
    {
        $this->switchDepth++;
        $expr = $context->expression();
        if ($expr !== null) {
            $switchType = $this->getExpressionType($expr);
            if ($switchType === null) {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($expr),
                    "La expresión del 'switch' debe tener tipo definido."
                );
            }
        }
        $this->validateDuplicateCases($context);
        $this->symbolTable->pushScope();
        $result = $this->visitChildren($context);
        $this->symbolTable->popScope();
        $this->switchDepth--;
        return $result;
    }

    /** Detecta case duplicados en el mismo switch (misma etiqueta constante). */
    private function validateDuplicateCases(SwitchStmtContext $context): void
    {
        $seen = [];
        $n = 0;
        while (true) {
            $caseClause = $context->caseClause($n);
            if ($caseClause === null) {
                break;
            }
            $exprList = $caseClause->expressionList();
            if ($exprList === null) {
                $n++;
                continue;
            }
            $exprs = $exprList->expression(null);
            $exprs = is_array($exprs) ? $exprs : [$exprs];
            foreach ($exprs as $e) {
                if ($e === null) {
                    continue;
                }
                $key = $this->caseExpressionKey($e);
                if ($key !== null && isset($seen[$key])) {
                    $this->errorHandler->add(
                        'Semántico',
                        $this->lineCol($e),
                        "Case duplicado en switch: la etiqueta ya aparece en otro case."
                    );
                }
                if ($key !== null) {
                    $seen[$key] = true;
                }
            }
            $n++;
        }
    }

    /** Clave única para detectar duplicados (literales: tipo+valor; otros: texto). */
    private function caseExpressionKey(?\Context\ExpressionContext $expr): ?string
    {
        if ($expr === null) {
            return null;
        }
        $prim = $this->getPrimaryFromExpression($expr);
        if ($prim !== null && $prim->literal() !== null) {
            $lit = $prim->literal();
            $type = $this->typeOfLiteral($lit);
            return (string) $type . ':' . $lit->getText();
        }
        return $expr->getText();
    }

    public function visitCaseClause(CaseClauseContext $context): mixed
    {
        $this->symbolTable->pushScope();
        $result = $this->visitChildren($context);
        $this->symbolTable->popScope();
        return $result;
    }

    public function visitDefaultClause(\Context\DefaultClauseContext $context): mixed
    {
        $this->symbolTable->pushScope();
        $result = $this->visitChildren($context);
        $this->symbolTable->popScope();
        return $result;
    }

    public function visitBreakStmt(\Context\BreakStmtContext $context): mixed
    {
        if ($this->loopDepth === 0 && $this->switchDepth === 0) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "'break' solo puede usarse dentro de 'for' o 'switch'."
            );
        }
        return $this->visitChildren($context);
    }

    public function visitContinueStmt(\Context\ContinueStmtContext $context): mixed
    {
        if ($this->loopDepth === 0) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "'continue' solo puede usarse dentro de 'for'."
            );
        }
        return $this->visitChildren($context);
    }

    public function visitReturnStmt(ReturnStmtContext $context): mixed
    {
        if ($this->currentFunctionIsMain) {
            $hasExpr = $context->expressionList() !== null && $context->expressionList()->getChildCount() > 0;
            if ($hasExpr) {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($context),
                    'La función main no puede retornar un valor.'
                );
            }
        } else {
            $exprList = $context->expressionList();
            if ($exprList !== null) {
                $retExprs = $exprList->expression(null);
                $retExprs = is_array($retExprs) ? $retExprs : [$retExprs];
                $retExprs = array_values(array_filter($retExprs));
                if (count($retExprs) > 0) {
                    $this->currentFunctionHasReturn = true;
                }
                $expectedReturns = ($this->currentFunctionReturnTypes !== null && count($this->currentFunctionReturnTypes) > 0)
                    ? $this->currentFunctionReturnTypes
                    : [];
                if (count($expectedReturns) > 0) {
                    if (count($retExprs) !== count($expectedReturns)) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($context),
                            'Cantidad de valores retornados no coincide con la firma de la función (se esperaban ' . count($expectedReturns) . ').'
                        );
                    } else {
                        foreach ($expectedReturns as $idx => $expectedType) {
                            if (!isset($retExprs[$idx])) continue;
                            $actualType = $this->getExpressionType($retExprs[$idx]);
                            if ($actualType !== null && !$expectedType->equals($actualType)) {
                                $this->errorHandler->add(
                                    'Semántico',
                                    $this->lineCol($context),
                                    'El tipo del valor retornado en la posición ' . ($idx + 1) . ' no coincide con el tipo de retorno de la función.'
                                );
                            }
                        }
                    }
                }
            }
        }
        return $this->visitChildren($context);
    }

    /** Tipos de retorno de la función actual (múltiples). */
    // -------------------------------------------------------------------------
    // Asignación: solo TypeSystem (tabla de asignación)
    // -------------------------------------------------------------------------

    public function visitAssignment(AssignmentContext $context): mixed
    {
        $exprs = $context->expression(null);
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        $assignOp = $context->assignOp();
        if (count($exprs) >= 2 && $exprs[0] !== null && $exprs[1] !== null && $assignOp !== null) {
            $rhsExpr = $exprs[1];
            $m = $this->getRhsValueCount([$rhsExpr]);
            if ($m > 1) {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($context),
                    'La cantidad de variables en la asignación no coincide con la cantidad de valores retornados.'
                );
            }
            $lhsType = $this->getLhsType($exprs[0]);
            $rhsType = $this->getExpressionType($rhsExpr);
            $opText = $assignOp->getText();
            if ($exprs[0] !== null && str_contains($exprs[0]->getText(), '*')) {
                $derefType = $this->getDereferenceLhsType($exprs[0]);
                if ($derefType !== null) {
                    $lhsType = $derefType;
                } elseif ($lhsType === null || (string) $lhsType === 'nil') {
                    $lhsType = $rhsType;
                }
            }
            if ($lhsType !== null && $rhsType !== null) {
                $sym = $this->getLhsSymbol($exprs[0]);
                if ($sym !== null && $sym->kind === 'constant') {
                    $this->errorHandler->add(
                        'Semántico',
                        $this->lineCol($context),
                        'No se puede asignar a una constante.'
                    );
                }
                if ($opText === '=') {
                    if (!TypeSystem::assignmentAllowed($lhsType, $rhsType)) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($context),
                            'Asignación incompatible: no se puede asignar tipo ' . (string) $rhsType . ' a ' . (string) $lhsType . '.'
                        );
                    }
                } else {
                    $op = rtrim($opText, '=');
                    if (!TypeSystem::compoundAssignmentAllowed($op, $lhsType, $rhsType)) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($context),
                            "Operador de asignación compuesta '$opText' no válido para los tipos dados."
                        );
                    }
                }
            }
        }
        return $this->visitChildren($context);
    }

    // -------------------------------------------------------------------------
    // Operadores: solo matrices TypeSystem (PDF)
    // -------------------------------------------------------------------------

    public function visitAddition(AdditionContext $context): mixed
    {
        $mults = $context->multiplication(null);
        $mults = is_array($mults) ? $mults : [$mults];
        $mults = array_values(array_filter($mults));
        if (count($mults) < 2) {
            return $this->visitChildren($context);
        }
        $leftType = $this->typeOfMultiplication($mults[0]);
        for ($i = 1; $i < count($mults); $i++) {
            $op = $this->getAdditionOperatorBetween($context, $i - 1);
            $rightType = $this->typeOfMultiplication($mults[$i]);
            if ($leftType !== null && $rightType !== null) {
                $result = TypeSystem::arithmeticResult($op, $leftType, $rightType);
                if ($result === null) {
                    $this->errorHandler->add(
                        'Semántico',
                        $this->lineCol($context),
                        "Operador '$op' no válido para tipos " . (string) $leftType . " y " . (string) $rightType . " (tabla aritmética PDF)."
                    );
                } else {
                    $leftType = new Type($result);
                }
            }
        }
        return $this->visitChildren($context);
    }

    public function visitMultiplication(MultiplicationContext $context): mixed
    {
        $unaries = $context->unary(null);
        $unaries = is_array($unaries) ? $unaries : [$unaries];
        $unaries = array_values(array_filter($unaries));
        if (count($unaries) < 2) {
            return $this->visitChildren($context);
        }
        $leftType = $this->typeOfUnary($unaries[0]);
        for ($i = 1; $i < count($unaries); $i++) {
            $op = $this->getMultiplicationOperatorBetween($context, $i - 1);
            $rightType = $this->typeOfUnary($unaries[$i]);
            if ($op === '*' && $rightType !== null && $rightType->isPointer()) {
                $leftType = $rightType->pointedType ?? $leftType;
                continue;
            }
            if ($leftType !== null && $rightType !== null) {
                $result = TypeSystem::arithmeticResult($op, $leftType, $rightType);
                if ($result === null) {
                    $this->errorHandler->add(
                        'Semántico',
                        $this->lineCol($context),
                        "Operador '$op' no válido para tipos " . (string) $leftType . " y " . (string) $rightType . " (tabla aritmética PDF)."
                    );
                } else {
                    $leftType = new Type($result);
                }
            }
        }
        return $this->visitChildren($context);
    }

    public function visitEquality(\Context\EqualityContext $context): mixed
    {
        $comps = $context->comparison(null);
        $comps = is_array($comps) ? $comps : [$comps];
        $comps = array_values(array_filter($comps));
        if (count($comps) < 2) {
            return $this->visitChildren($context);
        }
        $leftType = $this->typeOfComparison($comps[0]);
        for ($i = 1; $i < count($comps); $i++) {
            $rightType = $this->typeOfComparison($comps[$i]);
            if ($leftType !== null && $rightType !== null) {
                $result = TypeSystem::equalityResult($leftType, $rightType);
                if ($result === null) {
                    $this->errorHandler->add(
                        'Semántico',
                        $this->lineCol($context),
                        "Operador de igualdad no válido para tipos " . (string) $leftType . " y " . (string) $rightType . " (tabla PDF)."
                    );
                }
            }
        }
        return $this->visitChildren($context);
    }

    public function visitComparison(ComparisonContext $context): mixed
    {
        $adds = $context->addition(null);
        $adds = is_array($adds) ? $adds : [$adds];
        $adds = array_values(array_filter($adds));
        if (count($adds) < 2) {
            return $this->visitChildren($context);
        }
        $leftType = $this->typeOfAddition($adds[0]);
        for ($i = 1; $i < count($adds); $i++) {
            $rightType = $this->typeOfAddition($adds[$i]);
            if ($leftType !== null && $rightType !== null) {
                $result = TypeSystem::relationalResult($leftType, $rightType);
                if ($result === null) {
                    $this->errorHandler->add(
                        'Semántico',
                        $this->lineCol($context),
                        "Operador relacional no válido para tipos " . (string) $leftType . " y " . (string) $rightType . " (tabla PDF)."
                    );
                }
            }
        }
        return $this->visitChildren($context);
    }

    public function visitLogicalAnd(LogicalAndContext $context): mixed
    {
        $eqs = $context->equality(null);
        $eqs = is_array($eqs) ? $eqs : [$eqs];
        $eqs = array_values(array_filter($eqs));
        if (count($eqs) < 2) {
            return $this->visitChildren($context);
        }
        foreach ($eqs as $e) {
            $t = $this->typeOfEquality($e);
            if ($t !== null && TypeSystem::primitiveName($t) !== 'bool') {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($context),
                    "Operador '&&' requiere operandos de tipo bool (PDF §3.3.8)."
                );
                break;
            }
        }
        return $this->visitChildren($context);
    }

    public function visitLogicalOr(LogicalOrContext $context): mixed
    {
        $ands = $context->logicalAnd(null);
        $ands = is_array($ands) ? $ands : [$ands];
        $ands = array_values(array_filter($ands));
        if (count($ands) < 2) {
            return $this->visitChildren($context);
        }
        foreach ($ands as $a) {
            $t = $this->typeOfLogicalAnd($a);
            if ($t !== null && TypeSystem::primitiveName($t) !== 'bool') {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($context),
                    "Operador '||' requiere operandos de tipo bool (PDF §3.3.8)."
                );
                break;
            }
        }
        return $this->visitChildren($context);
    }

    public function visitUnary(UnaryContext $context): mixed
    {
        $operand = $context->unary();
        $primary = $context->primary();
        if ($operand !== null && $primary === null) {
            $op = $this->getUnaryOperator($context);
            $operandType = $this->typeOfUnary($operand);
            if ($operandType !== null) {
                if ($op === '!') {
                    if (TypeSystem::unaryNotResult($operandType) === null) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($context),
                            "Operador '!' solo acepta tipo bool (PDF §3.3.8)."
                        );
                    }
                } elseif ($op === '-') {
                    if (TypeSystem::unaryMinusResult($operandType) === null) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($context),
                            "Negación unaria '-' no válida para tipo " . (string) $operandType . " (tabla PDF)."
                        );
                    }
                } elseif ($op === '&') {
                    if ($operand->primary() === null || $operand->primary()->qualifiedIdentifier() === null) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($context),
                            "Operador '&' solo aplica a variables (identificador)."
                        );
                    }
                } elseif ($op === '*') {
                    if (!$operandType->isPointer()) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($context),
                            "Operador '*' solo aplica a tipos puntero."
                        );
                    }
                }
            }
        }
        return $this->visitChildren($context);
    }

    // -------------------------------------------------------------------------
    // Llamadas a función
    // -------------------------------------------------------------------------

    public function visitFunctionCall(FunctionCallContext $context): mixed
    {
        $qual = $context->qualifiedIdentifier();
        if ($qual === null) {
            return $this->visitChildren($context);
        }
        $tokens = $qual->IDENTIFIER(null);
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        $tokens = array_values(array_filter($tokens));
        $funcName = $tokens[0] !== null ? $tokens[0]->getText() : '';
        $isBuiltIn = count($tokens) > 1;
        if ($isBuiltIn) {
            return $this->visitChildren($context);
        }
        if ($funcName === 'main') {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                'La función main no puede ser invocada explícitamente.'
            );
            return $this->visitChildren($context);
        }
        if (BuiltIns::isBuiltIn($funcName)) {
            $this->validateBuiltInCall($context, $funcName, $tokens, $context->argumentList());
            return $this->visitChildren($context);
        }
        $sym = $this->symbolTable->resolve($funcName);
        if ($sym === null) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "Función '$funcName' no declarada."
            );
            return $this->visitChildren($context);
        }
        if (!$sym->isFunction()) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "'$funcName' no es una función."
            );
            return $this->visitChildren($context);
        }
        $expectedParams = $sym->paramTypes ?? [];
        $argList = $context->argumentList();
        $actualExprs = $argList !== null ? $argList->expression(null) : [];
        $actualExprs = is_array($actualExprs) ? $actualExprs : [$actualExprs];
        $actualExprs = array_values(array_filter($actualExprs));
        if (count($actualExprs) !== count($expectedParams)) {
            $this->errorHandler->add(
                'Semántico',
                $this->lineCol($context),
                "Número de argumentos incorrecto: se esperaban " . count($expectedParams) . ", se pasaron " . count($actualExprs) . "."
            );
        } else {
            foreach ($expectedParams as $idx => $expectedType) {
                if (!isset($actualExprs[$idx])) {
                    continue;
                }
                $actualType = $this->getExpressionType($actualExprs[$idx]);
                if ($actualType !== null && !$expectedType->equals($actualType)) {
                    $this->errorHandler->add(
                        'Semántico',
                        $this->lineCol($actualExprs[$idx]),
                        "Tipo del argumento " . ($idx + 1) . " no coincide: esperado " . (string) $expectedType . ", dado " . (string) $actualType . "."
                    );
                }
            }
        }
        return $this->visitChildren($context);
    }

    private function validateBuiltInCall(
        FunctionCallContext $context,
        string $funcName,
        array $tokens,
        ?\Context\ArgumentListContext $argList
    ): void {
        $exprs = $argList !== null ? $argList->expression(null) : [];
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        $exprs = array_values(array_filter($exprs));
        $n = count($exprs);
        if ($funcName === BuiltIns::LEN) {
            if ($n !== 1) {
                $this->errorHandler->add('Semántico', $this->lineCol($context), "Built-in 'len' requiere exactamente 1 argumento (string o array).");
                return;
            }
            $t = $this->getExpressionType($exprs[0]);
            if ($t !== null && !BuiltIns::lenParamAcceptable($t)) {
                $this->errorHandler->add('Semántico', $this->lineCol($exprs[0]), "'len' solo acepta string o array, no " . (string) $t . ".");
            }
            return;
        }
        if ($funcName === BuiltIns::NOW) {
            if ($n !== 0) {
                $this->errorHandler->add('Semántico', $this->lineCol($context), "Built-in 'now' no acepta argumentos.");
            }
            return;
        }
        if ($funcName === BuiltIns::SUBSTR) {
            if ($n !== 3) {
                $this->errorHandler->add('Semántico', $this->lineCol($context), "Built-in 'substr' requiere exactamente 3 argumentos: (string, int32, int32).");
                return;
            }
            $t0 = $this->getExpressionType($exprs[0]);
            $t1 = $this->getExpressionType($exprs[1]);
            $t2 = $this->getExpressionType($exprs[2]);
            if ($t0 !== null && $t0->name !== Type::STRING) {
                $this->errorHandler->add('Semántico', $this->lineCol($exprs[0]), "El primer argumento de 'substr' debe ser string.");
            }
            if ($t1 !== null && TypeSystem::primitiveName($t1) !== 'int32') {
                $this->errorHandler->add('Semántico', $this->lineCol($exprs[1]), "El segundo argumento de 'substr' debe ser int32.");
            }
            if ($t2 !== null && TypeSystem::primitiveName($t2) !== 'int32') {
                $this->errorHandler->add('Semántico', $this->lineCol($exprs[2]), "El tercer argumento de 'substr' debe ser int32.");
            }
            return;
        }
        if ($funcName === BuiltIns::TYPEOF) {
            if ($n !== 1) {
                $this->errorHandler->add('Semántico', $this->lineCol($context), "Built-in 'typeOf' requiere exactamente 1 argumento.");
            }
            return;
        }
    }

    // -------------------------------------------------------------------------
    // Arrays: índice int32
    // -------------------------------------------------------------------------

    public function visitArrayAccess(\Context\ArrayAccessContext $context): mixed
    {
        $qi = $context->qualifiedIdentifier();
        $baseName = null;
        $baseType = null;
        if ($qi !== null) {
            $tokens = $qi->IDENTIFIER(null);
            $tokens = is_array($tokens) ? $tokens : [$tokens];
            if (count($tokens) === 1 && $tokens[0] !== null) {
                $baseName = $tokens[0]->getText();
                $sym = $this->symbolTable->resolve($baseName);
                $baseType = $sym !== null ? $sym->type : null;
            }
        }
        $exprs = $context->expression(null);
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        $exprs = array_values(array_filter($exprs));
        $arraySize = $baseType !== null && $baseType->isArray() && isset($baseType->arrayInfo['length'])
            ? $baseType->arrayInfo['length']
            : null;
        foreach ($exprs as $i => $e) {
            if ($e === null) {
                continue;
            }
            $idxType = $this->getExpressionType($e);
            if ($idxType !== null && TypeSystem::primitiveName($idxType) !== 'int32') {
                $this->errorHandler->add(
                    'Semántico',
                    $this->lineCol($e),
                    "El índice de array debe ser de tipo int32."
                );
            }
            if ($arraySize !== null && $i === 0) {
                $literalIdx = $this->getConstantIntFromExpression($e);
                if ($literalIdx !== null) {
                    if ($literalIdx < 0 || $literalIdx >= $arraySize) {
                        $this->errorHandler->add(
                            'Semántico',
                            $this->lineCol($e),
                            "Índice fuera de rango para array de tamaño {$arraySize}."
                        );
                    }
                }
            }
        }
        return $this->visitChildren($context);
    }

    /** Si la expresión es un literal entero constante, retorna su valor; si no, null. */
    private function getConstantIntFromExpression(?\Context\ExpressionContext $expr): ?int
    {
        if ($expr === null) return null;
        $prim = $this->getPrimaryFromExpression($expr);
        if ($prim === null || $prim->literal() === null) return null;
        $lit = $prim->literal();
        $text = $lit->getText();
        if ($lit->INT_LITERAL() !== null || (is_numeric($text) && !str_contains($text, '.'))) {
            return (int) $text;
        }
        return null;
    }

    // -------------------------------------------------------------------------
    // Helpers: tipos de expresiones (para TypeSystem)
    // -------------------------------------------------------------------------

    private function getExpressionType(?\Context\ExpressionContext $expr): ?Type
    {
        if ($expr === null) {
            return null;
        }
        $lo = $expr->logicalOr(0);
        if ($lo === null) {
            return null;
        }
        return $this->typeOfLogicalOr($lo);
    }

    private function typeOfLogicalOr(?\Context\LogicalOrContext $ctx): ?Type
    {
        if ($ctx === null) {
            return null;
        }
        $ands = $ctx->logicalAnd(null);
        $ands = is_array($ands) ? $ands : [$ands];
        $ands = array_values(array_filter($ands));
        if (count($ands) === 0) {
            return null;
        }
        if (count($ands) === 1) {
            return $this->typeOfLogicalAnd($ands[0]);
        }
        return Type::bool();
    }

    private function typeOfLogicalAnd(?\Context\LogicalAndContext $ctx): ?Type
    {
        if ($ctx === null) {
            return null;
        }
        $eqs = $ctx->equality(null);
        $eqs = is_array($eqs) ? $eqs : [$eqs];
        return isset($eqs[0]) && $eqs[0] !== null ? $this->typeOfEquality($eqs[0]) : null;
    }

    private function typeOfEquality(?\Context\EqualityContext $ctx): ?Type
    {
        if ($ctx === null) {
            return null;
        }
        $comps = $ctx->comparison(null);
        $comps = is_array($comps) ? $comps : [$comps];
        $comps = array_values(array_filter($comps));
        if (count($comps) === 0) return null;
        if (count($comps) >= 2) return Type::bool();
        return $this->typeOfComparison($comps[0]);
    }

    private function typeOfComparison(?\Context\ComparisonContext $ctx): ?Type
    {
        if ($ctx === null) {
            return null;
        }
        $adds = $ctx->addition(null);
        $adds = is_array($adds) ? $adds : [$adds];
        $adds = array_values(array_filter($adds));
        if (count($adds) === 0) return null;
        if (count($adds) >= 2) return Type::bool();
        return $this->typeOfAddition($adds[0]);
    }

    private function typeOfAddition(?\Context\AdditionContext $ctx): ?Type
    {
        if ($ctx === null) {
            return null;
        }
        $mults = $ctx->multiplication(null);
        $mults = is_array($mults) ? $mults : [$mults];
        return isset($mults[0]) && $mults[0] !== null ? $this->typeOfMultiplication($mults[0]) : null;
    }

    private function typeOfMultiplication(?\Context\MultiplicationContext $ctx): ?Type
    {
        if ($ctx === null) {
            return null;
        }
        $unaries = $ctx->unary(null);
        $unaries = is_array($unaries) ? $unaries : [$unaries];
        return isset($unaries[0]) && $unaries[0] !== null ? $this->typeOfUnary($unaries[0]) : null;
    }

    private function typeOfUnary(?\Context\UnaryContext $un): ?Type
    {
        if ($un === null) {
            return null;
        }
        $prim = $un->primary();
        if ($prim !== null) {
            return $this->typeOfPrimary($prim);
        }
        $inner = $un->unary();
        if ($inner !== null && $un->getChildCount() >= 2) {
            $op = $un->getChild(0);
            $opText = method_exists($op, 'getText') ? $op->getText() : null;
            $innerType = $this->typeOfUnary($inner);
            if ($opText === '&') {
                return $innerType !== null ? Type::pointerTo($innerType) : null;
            }
            if ($opText === '*') {
                if ($innerType !== null && $innerType->isPointer() && $innerType->pointedType !== null) {
                    return $innerType->pointedType;
                }
                return null;
            }
        }
        return null;
    }

    private function typeOfPrimary(?\Context\PrimaryContext $ctx): ?Type
    {
        if ($ctx === null) {
            return null;
        }
        if ($ctx->literal() !== null) {
            return $this->typeOfLiteral($ctx->literal());
        }
        if ($ctx->qualifiedIdentifier() !== null) {
            $qi = $ctx->qualifiedIdentifier();
            $tokens = $qi->IDENTIFIER(null);
            $tokens = is_array($tokens) ? $tokens : [$tokens];
            if (count($tokens) === 1 && $tokens[0] !== null) {
                $sym = $this->symbolTable->resolve($tokens[0]->getText());
                return $sym !== null ? $sym->type : null;
            }
            return Type::nil();
        }
        if ($ctx->functionCall() !== null) {
            $fc = $ctx->functionCall();
            $qual = $fc->qualifiedIdentifier();
            if ($qual !== null) {
                $tokens = $qual->IDENTIFIER(null);
                $tokens = is_array($tokens) ? $tokens : [$tokens];
                $name = $tokens[0] !== null ? $tokens[0]->getText() : '';
                if (BuiltIns::isBuiltIn($name)) {
                    $ret = BuiltIns::returnType($name);
                    return $ret ?? Type::nil();
                }
                $sym = $this->symbolTable->resolve($name);
                return $sym !== null ? $sym->type : Type::nil();
            }
            return Type::nil();
        }
        if ($ctx->arrayAccess() !== null) {
            return Type::nil();
        }
        if ($ctx->arrayLiteral() !== null) {
            return Type::nil();
        }
        if ($ctx->expression() !== null) {
            return $this->getExpressionType($ctx->expression());
        }
        return null;
    }

    private function typeOfLiteral(?\Context\LiteralContext $ctx): Type
    {
        if ($ctx === null) {
            return Type::nil();
        }
        $text = $ctx->getText();
        if ($ctx->INT_LITERAL() !== null || (is_numeric($text) && !str_contains($text, '.'))) {
            return Type::int32();
        }
        if ($ctx->FLOAT_LITERAL() !== null || (is_numeric($text) && str_contains($text, '.'))) {
            return Type::float32();
        }
        if ($ctx->STRING_LITERAL() !== null) {
            return Type::string();
        }
        if ($ctx->RUNE_LITERAL() !== null) {
            return Type::rune();
        }
        if ($text === 'true' || $text === 'false') {
            return Type::bool();
        }
        if ($text === 'nil') {
            return Type::nil();
        }
        return Type::nil();
    }

    private function getLhsType(?\Context\ExpressionContext $expr): ?Type
    {
        if ($expr === null) {
            return null;
        }
        $derefType = $this->getDereferenceLhsType($expr);
        if ($derefType !== null) {
            return $derefType;
        }
        return $this->getExpressionType($expr);
    }

    /** Tipo del destino de *expr (desreferencia) si expr es ese patrón. */
    private function getDereferenceLhsType(?\Context\ExpressionContext $expr): ?Type
    {
        $un = $this->getUnaryFromExpression($expr);
        if ($un === null || $un->getChildCount() < 2 || $un->unary() === null) {
            return null;
        }
        $op = $un->getChild(0);
        $opText = method_exists($op, 'getText') ? $op->getText() : null;
        if ($opText !== '*') {
            return null;
        }
        $innerType = $this->typeOfUnary($un->unary());
        if ($innerType !== null && $innerType->isPointer() && $innerType->pointedType !== null) {
            return $innerType->pointedType;
        }
        return null;
    }

    private function getUnaryFromExpression(?\Context\ExpressionContext $expr): ?\Context\UnaryContext
    {
        if ($expr === null) return null;
        $lo = $expr->logicalOr(0);
        if ($lo === null) return null;
        $la = $lo->logicalAnd(0);
        if ($la === null) return null;
        $eq = $la->equality(0);
        if ($eq === null) return null;
        $cmp = $eq->comparison(0);
        if ($cmp === null) return null;
        $add = $cmp->addition(0);
        if ($add === null) return null;
        $mul = $add->multiplication(0);
        if ($mul === null) return null;
        $unaries = $mul->unary(null);
        $unaries = is_array($unaries) ? $unaries : [$unaries];
        return isset($unaries[0]) ? $unaries[0] : null;
    }

    private function getLhsSymbol(?\Context\ExpressionContext $expr): ?Symbol
    {
        if ($expr === null) {
            return null;
        }
        $prim = $this->getPrimaryFromExpression($expr);
        if ($prim === null || $prim->qualifiedIdentifier() === null) {
            return null;
        }
        $qi = $prim->qualifiedIdentifier();
        $tokens = $qi->IDENTIFIER(null);
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        if (count($tokens) !== 1 || $tokens[0] === null) {
            return null;
        }
        return $this->symbolTable->resolve($tokens[0]->getText());
    }

    private function getPrimaryFromExpression(?\Context\ExpressionContext $expr): ?\Context\PrimaryContext
    {
        if ($expr === null) {
            return null;
        }
        $lo = $expr->logicalOr(0);
        if ($lo === null) {
            return null;
        }
        $la = $lo->logicalAnd(0);
        if ($la === null) {
            return null;
        }
        $eq = $la->equality(0);
        if ($eq === null) {
            return null;
        }
        $cmp = $eq->comparison(0);
        if ($cmp === null) {
            return null;
        }
        $add = $cmp->addition(0);
        if ($add === null) {
            return null;
        }
        $mul = $add->multiplication(0);
        if ($mul === null) {
            return null;
        }
        $un = $mul->unary(0);
        return $un !== null ? $un->primary() : null;
    }

    private function getAdditionOperatorBetween(AdditionContext $context, int $pairIndex): string
    {
        $mults = $context->multiplication(null);
        $mults = is_array($mults) ? $mults : [$mults];
        $n = count(array_values(array_filter($mults)));
        $childIdx = 1 + $pairIndex * 2;
        if ($childIdx >= $context->getChildCount()) {
            return '+';
        }
        $tok = $context->getChild($childIdx);
        if ($tok instanceof \Antlr\Antlr4\Runtime\Tree\TerminalNodeImpl) {
            $sym = $tok->getSymbol();
            $text = $sym !== null ? $sym->getText() : '+';
            return $text === '-' ? '-' : '+';
        }
        return '+';
    }

    private function getMultiplicationOperatorBetween(MultiplicationContext $context, int $pairIndex): string
    {
        $childIdx = 1 + $pairIndex * 2;
        if ($childIdx >= $context->getChildCount()) {
            return '*';
        }
        $tok = $context->getChild($childIdx);
        if ($tok instanceof \Antlr\Antlr4\Runtime\Tree\TerminalNodeImpl) {
            $text = $tok->getSymbol() !== null ? $tok->getSymbol()->getText() : '*';
            return $text === '/' ? '/' : ($text === '%' ? '%' : '*');
        }
        return '*';
    }

    private function getUnaryOperator(UnaryContext $context): string
    {
        if ($context->getChildCount() > 0) {
            $first = $context->getChild(0);
            if ($first instanceof \Antlr\Antlr4\Runtime\Tree\TerminalNodeImpl && $first->getSymbol() !== null) {
                return $first->getSymbol()->getText();
            }
        }
        return '!';
    }

    // -------------------------------------------------------------------------
    // Validación de flujo: todas las rutas deben retornar (funciones con tipo retorno)
    // -------------------------------------------------------------------------

    /**
     * Indica si el bloque garantiza que toda ruta de ejecución termina en return.
     * Un bloque garantiza retorno si su última sentencia garantiza retorno.
     */
    private function blockGuaranteesReturn(BlockContext $block): bool
    {
        $stmts = $block->statement(null);
        $stmts = is_array($stmts) ? $stmts : [$stmts];
        $stmts = array_values(array_filter($stmts));
        if (count($stmts) === 0) {
            return false;
        }
        $last = $stmts[count($stmts) - 1];
        return $this->statementGuaranteesReturn($last);
    }

    /**
     * Indica si la sentencia garantiza que la ejecución termina en return.
     * - return con expresión → true
     * - block → última sentencia garantiza
     * - if con else → ambas ramas deben garantizar
     * - if sin else → false
     * - switch → todos los case (y default si existe) deben garantizar
     * - resto (for, asignación, etc.) → false
     */
    private function statementGuaranteesReturn(\Context\StatementContext $stmt): bool
    {
        if ($stmt->returnStmt() !== null) {
            $ret = $stmt->returnStmt();
            return $ret->expressionList() !== null && $ret->expressionList()->expression(0) !== null;
        }
        if ($stmt->block() !== null) {
            return $this->blockGuaranteesReturn($stmt->block());
        }
        if ($stmt->ifStmt() !== null) {
            return $this->ifStmtGuaranteesReturn($stmt->ifStmt());
        }
        if ($stmt->switchStmt() !== null) {
            return $this->switchStmtGuaranteesReturn($stmt->switchStmt());
        }
        return false;
    }

    /**
     * if garantiza retorno solo si tiene else y ambas ramas garantizan retorno.
     */
    private function ifStmtGuaranteesReturn(IfStmtContext $context): bool
    {
        $blocks = $context->block(null);
        $blocks = is_array($blocks) ? $blocks : [$blocks];
        $blocks = array_values(array_filter($blocks));
        $thenBlock = $blocks[0] ?? null;
        if ($thenBlock === null) {
            return false;
        }
        $elseBlock = $blocks[1] ?? null;
        $elseIf = $context->ifStmt();
        if ($elseBlock === null && $elseIf === null) {
            return false;
        }
        if (!$this->blockGuaranteesReturn($thenBlock)) {
            return false;
        }
        if ($elseBlock !== null) {
            return $this->blockGuaranteesReturn($elseBlock);
        }
        return $this->ifStmtGuaranteesReturn($elseIf);
    }

    /**
     * switch garantiza retorno si todos los case garantizan y, si hay default, también.
     */
    private function switchStmtGuaranteesReturn(SwitchStmtContext $context): bool
    {
        $cases = $context->caseClause(null);
        $cases = is_array($cases) ? $cases : [$cases];
        $cases = array_values(array_filter($cases));
        foreach ($cases as $case) {
            if (!$this->caseClauseGuaranteesReturn($case)) {
                return false;
            }
        }
        $default = $context->defaultClause();
        if ($default !== null) {
            return $this->defaultClauseGuaranteesReturn($default);
        }
        return count($cases) > 0;
    }

    private function caseClauseGuaranteesReturn(CaseClauseContext $context): bool
    {
        $stmts = $context->statement(null);
        $stmts = is_array($stmts) ? $stmts : [$stmts];
        $stmts = array_values(array_filter($stmts));
        if (count($stmts) === 0) {
            return false;
        }
        $last = $stmts[count($stmts) - 1];
        return $this->statementGuaranteesReturn($last);
    }

    private function defaultClauseGuaranteesReturn(\Context\DefaultClauseContext $context): bool
    {
        $stmts = $context->statement(null);
        $stmts = is_array($stmts) ? $stmts : [$stmts];
        $stmts = array_values(array_filter($stmts));
        if (count($stmts) === 0) {
            return false;
        }
        $last = $stmts[count($stmts) - 1];
        return $this->statementGuaranteesReturn($last);
    }

    private function resolveType(\Context\TypeContext $typeContext): Type
    {
        if ($typeContext->baseType() !== null) {
            $text = $typeContext->baseType()->getText();
            return new Type($text === 'int' ? 'int32' : $text);
        }
        if ($typeContext->arrayType() !== null) {
            $arr = $typeContext->arrayType();
            $elem = $arr->type() !== null ? $this->resolveType($arr->type()) : Type::int32();
            $len = null;
            if ($arr->expression() !== null) {
                $exprText = $arr->expression()->getText();
                if (is_numeric($exprText)) {
                    $len = (int) $exprText;
                }
            }
            return Type::arrayOf($elem, $len);
        }
        if ($typeContext->pointerType() !== null) {
            $inner = $typeContext->pointerType()->type();
            return $inner !== null ? Type::pointerTo($this->resolveType($inner)) : Type::nil();
        }
        return Type::nil();
    }

    private function lineCol($context): array
    {
        $token = $context->getStart();
        return [
            $token !== null ? $token->getLine() : 0,
            $token !== null ? $token->getCharPositionInLine() : 0,
        ];
    }
}
