<?php

declare(strict_types=1);

namespace Golampi\Visitors;

use Golampi\interpreter\Symbol;
use Golampi\interpreter\BuiltIns;
use Golampi\interpreter\SymbolTable;
use Golampi\interpreter\Type;
use Golampi\interpreter\Value;

/** Excepción para propagar return con múltiples valores desde el cuerpo de una función. */
final class ReturnException extends \Exception
{
    /** @var list<Value> */
    public array $values;

    /** @param list<Value> $values */
    public function __construct(array $values)
    {
        $this->values = $values;
        parent::__construct('return');
    }
}

/**
 * Visitor de ejecución: recorre el árbol y ejecuta sentencias,
 * evaluando expresiones, llamadas a funciones y built-ins.
 */
class ExecutionVisitor extends \GolampiBaseVisitor
{
    /** @var list<array<string, Value>> Pila de ámbitos de valores (nombre => Value) */
    private array $valueScopes = [];

    private SymbolTable $symbolTable;
    /** @var array<string, \Context\FunctionDeclContext> nombre función -> declaración (para invocar) */
    private array $functionDecls = [];

    private int $loopDepth = 0;
    private int $switchDepth = 0;

    /** Valor(es) de return (para propagar fuera del visitor) */
    private ?array $returnValues = null;

    /** Salida capturada (para tests y reportes) */
    private string $output = '';

    public function __construct(SymbolTable $symbolTable)
    {
        $this->symbolTable = $symbolTable;
        $this->pushScope();
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    public function clearOutput(): void
    {
        $this->output = '';
    }

    private function pushScope(): void
    {
        $this->valueScopes[] = [];
    }

    private function popScope(): void
    {
        if (count($this->valueScopes) <= 1) {
            return;
        }
        array_pop($this->valueScopes);
    }

    private function defineValue(string $name, Value $value): void
    {
        $idx = count($this->valueScopes) - 1;
        $this->valueScopes[$idx][$name] = $value;
    }

    private function resolveValue(string $name): ?Value
    {
        for ($i = count($this->valueScopes) - 1; $i >= 0; $i--) {
            if (isset($this->valueScopes[$i][$name])) {
                return $this->valueScopes[$i][$name];
            }
        }
        return null;
    }

    /** Retorna [Value, scopeIndex] o [null, null] si no existe. */
    private function resolveValueAndScope(string $name): array
    {
        for ($i = count($this->valueScopes) - 1; $i >= 0; $i--) {
            if (isset($this->valueScopes[$i][$name])) {
                return [$this->valueScopes[$i][$name], $i];
            }
        }
        return [null, null];
    }

    private function getValueByRef(int $scopeIndex, string $name): ?Value
    {
        if ($scopeIndex < 0 || $scopeIndex >= count($this->valueScopes)) return null;
        return $this->valueScopes[$scopeIndex][$name] ?? null;
    }

    private function setValueByRef(int $scopeIndex, string $name, Value $value): void
    {
        if ($scopeIndex >= 0 && $scopeIndex < count($this->valueScopes)) {
            $this->valueScopes[$scopeIndex][$name] = $value;
        }
    }

    private function setValue(string $name, Value $value): bool
    {
        for ($i = count($this->valueScopes) - 1; $i >= 0; $i--) {
            if (array_key_exists($name, $this->valueScopes[$i])) {
                $this->valueScopes[$i][$name] = $value;
                return true;
            }
        }
        return false;
    }

    public function visitProgram(\Context\ProgramContext $context): mixed
    {
        $decls = $context->topLevelDecl(null);
        $decls = is_array($decls) ? $decls : [$decls];
        $decls = array_values(array_filter($decls));
        foreach ($decls as $top) {
            $func = $top->functionDecl();
            if ($func !== null && $func->IDENTIFIER() !== null) {
                $this->functionDecls[$func->IDENTIFIER()->getText()] = $func;
            }
        }
        foreach ($decls as $top) {
            if ($top->varDecl() !== null) {
                $this->visitVarDecl($top->varDecl());
            } elseif ($top->constDecl() !== null) {
                $this->visitConstDecl($top->constDecl());
            }
        }
        $mainDecl = $this->functionDecls['main'] ?? null;
        if ($mainDecl !== null && $mainDecl->block() !== null) {
            $this->visit($mainDecl->block());
        }
        return null;
    }

    public function visitFunctionDecl(\Context\FunctionDeclContext $context): mixed
    {
        return null;
    }

    public function visitBlock(\Context\BlockContext $context): mixed
    {
        $this->pushScope();
        $this->visitChildren($context);
        $this->popScope();
        return null;
    }

    public function visitVarDecl(\Context\VarDeclContext $context): mixed
    {
        $typeCtx = $context->type();
        $type = $typeCtx !== null ? $this->resolveType($typeCtx) : Type::int32();
        $defaultVal = $this->defaultForType($type);
        $idList = $context->identifierList();
        if ($idList !== null) {
            $ids = $idList->IDENTIFIER(null);
            $ids = is_array($ids) ? $ids : [$ids];
            $exprList = $context->expressionList();
            $values = [];
            if ($exprList !== null) {
                $exprs = $exprList->expression(null);
                $exprs = is_array($exprs) ? $exprs : [$exprs];
                foreach ($exprs as $e) {
                    if ($e !== null) {
                        $values[] = $this->evaluateExpression($e);
                    }
                }
            }
            $i = 0;
            foreach ($ids as $tok) {
                if ($tok === null) continue;
                $name = $tok->getText();
                $val = $values[$i] ?? $defaultVal;
                $this->defineValue($name, $val);
                $i++;
            }
        }
        return null;
    }

    public function visitShortVarDecl(\Context\ShortVarDeclContext $context): mixed
    {
        $idList = $context->identifierList();
        $exprList = $context->expressionList();
        if ($idList === null || $exprList === null) return null;
        $ids = $idList->IDENTIFIER(null);
        $ids = is_array($ids) ? $ids : [$ids];
        $ids = array_values(array_filter($ids));
        $values = $this->getValuesFromExpressionList($exprList);
        foreach ($ids as $i => $tok) {
            if ($tok === null) continue;
            $name = $tok->getText();
            $val = $values[$i] ?? Value::nil();
            $this->defineValue($name, $val);
        }
        return null;
    }

    /**
     * Evalúa la lista de expresiones; si hay una sola y es llamada a función, devuelve todos sus retornos.
     * @return list<Value>
     */
    private function getValuesFromExpressionList(\Context\ExpressionListContext $exprList): array
    {
        $exprs = $exprList->expression(null);
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        $exprs = array_values(array_filter($exprs));
        if (count($exprs) === 1) {
            $fc = $this->getFunctionCallFromExpression($exprs[0]);
            if ($fc !== null) {
                $qual = $fc->qualifiedIdentifier();
                $tokens = $qual !== null ? $qual->IDENTIFIER(null) : [];
                $tokens = is_array($tokens) ? $tokens : [$tokens];
                $tokens = array_values(array_filter($tokens));
                $name = $tokens[0] !== null ? $tokens[0]->getText() : '';
                $isUserCall = count($tokens) === 1 && isset($this->functionDecls[$name]);
                if ($isUserCall) {
                    $args = [];
                    if ($fc->argumentList() !== null) {
                        $argExprs = $fc->argumentList()->expression(null);
                        $argExprs = is_array($argExprs) ? $argExprs : [$argExprs];
                        foreach ($argExprs as $e) {
                            if ($e !== null) $args[] = $this->evaluateExpression($e);
                        }
                    }
                    return $this->invokeUserFunction($name, $args);
                }
            }
        }
        $out = [];
        foreach ($exprs as $e) {
            $out[] = $e !== null ? $this->evaluateExpression($e) : Value::nil();
        }
        return $out;
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
        $expr = $context->expression();
        if ($id === null || $expr === null) return null;
        $name = $id->getText();
        $val = $this->evaluateExpression($expr);
        $this->defineValue($name, $val);
        return null;
    }

    public function visitAssignment(\Context\AssignmentContext $context): mixed
    {
        $exprs = $context->expression(null);
        if (!is_array($exprs) || count($exprs) < 2) return null;
        $lhs = $exprs[0];
        $rhs = $exprs[1];
        $arrAccess = $this->getAssignableArrayAccess($lhs);
        if ($arrAccess !== null) {
            [$name, $indexExprs] = $arrAccess;
            $indices = [];
            foreach ($indexExprs as $e) {
                $indices[] = (int) $this->evaluateExpression($e)->data;
            }
            $val = $this->evaluateExpression($rhs);
            $this->setArrayElement($name, $indices, $val);
            return null;
        }
        $derefUnary = $this->getDereferenceLhsUnary($lhs);
        if ($derefUnary !== null) {
            $ptrVal = $this->visit($derefUnary);
            $val = $this->evaluateExpression($rhs);
            if ($ptrVal instanceof Value && $ptrVal->isPointerRef()) {
                $this->setValueByRef($ptrVal->data['scope'], $ptrVal->data['name'], $val);
            }
            return null;
        }
        $name = $this->getAssignableName($lhs);
        if ($name !== null) {
            $val = $this->evaluateExpression($rhs);
            $this->setValue($name, $val);
        }
        return null;
    }

    /** Si LHS es *expr retorna el UnaryContext del operando (expr) para evaluar y obtener el puntero. */
    private function getDereferenceLhsUnary(?\Context\ExpressionContext $expr): ?\Context\UnaryContext
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
        $childCount = $un->getChildCount();
        if ($childCount >= 2) {
            $first = $un->getChild(0);
            $op = method_exists($first, 'getText') ? $first->getText() : null;
            if ($op === '*' && $un->unary() !== null) {
                return $un->unary();
            }
        }
        return null;
    }

    /**
     * Si la expresión es un array access (arr[i] o arr[i][j]), retorna [nombreBase, [exprÍndices]].
     * @return array{0: string, 1: list<\Context\ExpressionContext>}|null
     */
    private function getAssignableArrayAccess(?\Context\ExpressionContext $expr): ?array
    {
        if ($expr === null) return null;
        $aa = $this->getArrayAccessFromExpression($expr);
        if ($aa === null) return null;
        $qi = $aa->qualifiedIdentifier();
        $tokens = $qi !== null ? $qi->IDENTIFIER(null) : [];
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        $name = $tokens[0] !== null ? $tokens[0]->getText() : '';
        $indexExprs = $aa->expression(null);
        $indexExprs = is_array($indexExprs) ? $indexExprs : [$indexExprs];
        $indexExprs = array_values(array_filter($indexExprs));
        return [$name, $indexExprs];
    }

    private function getArrayAccessFromExpression(?\Context\ExpressionContext $expr): ?\Context\ArrayAccessContext
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
        return $prim !== null ? $prim->arrayAccess() : null;
    }

    /**
     * Asigna valor a elemento(s) del array; indices son los índices evaluados.
     * @param list<int> $indices
     */
    private function setArrayElement(string $name, array $indices, Value $value): void
    {
        $base = $this->resolveValue($name);
        if ($base === null || !is_array($base->data) || count($indices) === 0) return;
        $n = count($indices);
        $curr = $base;
        for ($i = 0; $i < $n - 1; $i++) {
            $idx = $indices[$i];
            $arr = $curr->data;
            if (!is_array($arr)) return;
            $size = count($arr);
            if ($idx < 0 || $idx >= $size) {
                throw new \RuntimeException("Índice fuera de rango: {$idx} para array de tamaño {$size}.");
            }
            $curr = $arr[$idx] instanceof Value ? $arr[$idx] : Value::nil();
        }
        $idx = $indices[$n - 1];
        if (!is_array($curr->data)) return;
        $size = count($curr->data);
        if ($idx < 0 || $idx >= $size) {
            throw new \RuntimeException("Índice fuera de rango: {$idx} para array de tamaño {$size}.");
        }
        $curr->data[$idx] = $value;
    }

    public function visitExpressionStmt(\Context\ExpressionStmtContext $context): mixed
    {
        $expr = $context->expression();
        if ($expr !== null) {
            $this->evaluateExpression($expr);
        }
        return null;
    }

    public function visitIfStmt(\Context\IfStmtContext $context): mixed
    {
        if ($context->simpleStmt() !== null) {
            $this->visit($context->simpleStmt());
        }
        $cond = $context->expression();
        if ($cond === null) return null;
        $v = $this->evaluateExpression($cond);
        $thenBlock = $context->block(0);
        if ($thenBlock !== null && $this->isTruthy($v)) {
            $this->visit($thenBlock);
            return null;
        }
        $elseIf = $context->ifStmt();
        if ($elseIf !== null) {
            $this->visit($elseIf);
            return null;
        }
        $elseBlock = $context->block(1);
        if ($elseBlock !== null) {
            $this->visit($elseBlock);
        }
        return null;
    }

    private function isTruthy(Value $v): bool
    {
        if ($v->isNil()) return false;
        if ($v->type->name === Type::BOOL) return (bool) $v->data;
        return true;
    }

    public function visitForStmt(\Context\ForStmtContext $context): mixed
    {
        $this->loopDepth++;
        $this->visitChildren($context);
        $this->loopDepth--;
        return null;
    }

    public function visitSwitchStmt(\Context\SwitchStmtContext $context): mixed
    {
        $this->switchDepth++;
        $this->visitChildren($context);
        $this->switchDepth--;
        return null;
    }

    public function visitReturnStmt(\Context\ReturnStmtContext $context): mixed
    {
        $values = [];
        $exprList = $context->expressionList();
        if ($exprList !== null) {
            $exprs = $exprList->expression(null);
            $exprs = is_array($exprs) ? $exprs : [$exprs];
            foreach ($exprs as $e) {
                if ($e !== null) {
                    $values[] = $this->evaluateExpression($e);
                }
            }
        }
        throw new ReturnException($values);
    }

    private function getAssignableName(?\Context\ExpressionContext $expr): ?string
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
        $primary = $un->primary();
        if ($primary === null) return null;
        $qi = $primary->qualifiedIdentifier();
        if ($qi === null) return null;
        $tokens = $qi->IDENTIFIER(null);
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        if (count($tokens) === 1 && $tokens[0] !== null) {
            return $tokens[0]->getText();
        }
        return null;
    }

    private function evaluateExpression(\Context\ExpressionContext $expr): Value
    {
        $result = $this->visit($expr);
        return $result instanceof Value ? $result : Value::nil();
    }

    public function visitLiteral(\Context\LiteralContext $context): mixed
    {
        $text = $context->getText();
        if ($text === '') return Value::nil();
        if ($text === '5' || (is_numeric($text) && (string)(int)$text === $text)) {
            return Value::int((int) $text);
        }
        if ($text === 'true') return Value::bool(true);
        if ($text === 'false') return Value::bool(false);
        if ($text === 'nil') return Value::nil();
        if (is_numeric($text)) {
            return str_contains($text, '.') || stripos($text, 'e') !== false
                ? Value::float((float) $text)
                : Value::int((int) $text);
        }
        if ($context->STRING_LITERAL() !== null) {
            return Value::string($this->unescapeString($text));
        }
        if ($context->RUNE_LITERAL() !== null) {
            return Value::rune($this->unescapeString($text));
        }
        if ($context->INT_LITERAL() !== null) {
            return Value::int((int) $text);
        }
        if ($context->FLOAT_LITERAL() !== null) {
            return Value::float((float) $text);
        }
        return Value::nil();
    }

    public function visitQualifiedIdentifier(\Context\QualifiedIdentifierContext $context): mixed
    {
        $tokens = $context->IDENTIFIER(null);
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        if (count($tokens) === 1 && $tokens[0] !== null) {
            $name = $tokens[0]->getText();
            $v = $this->resolveValue($name);
            return $v ?? Value::nil();
        }
        return Value::nil();
    }

    public function visitPrimary(\Context\PrimaryContext $context): mixed
    {
        if ($context->literal() !== null) return $this->visit($context->literal());
        if ($context->qualifiedIdentifier() !== null) return $this->visit($context->qualifiedIdentifier());
        if ($context->arrayLiteral() !== null) return $this->visit($context->arrayLiteral());
        if ($context->arrayAccess() !== null) return $this->visit($context->arrayAccess());
        if ($context->functionCall() !== null) return $this->visit($context->functionCall());
        if ($context->expression() !== null) return $this->evaluateExpression($context->expression());
        return Value::nil();
    }

    public function visitArrayLiteral(\Context\ArrayLiteralContext $context): mixed
    {
        $at = $context->arrayType();
        $body = $context->arrayLiteralBody();
        if ($at === null || $body === null) return Value::nil();
        $sizeExpr = $at->expression();
        $size = $sizeExpr !== null ? (int) $this->evaluateExpression($sizeExpr)->data : 0;
        $elemType = $this->resolveType($at->type());
        $elements = $this->evaluateArrayLiteralBody($body, $elemType);
        return Value::array($elements, $elemType, $size);
    }

    /**
     * @return list<Value>
     */
    private function evaluateArrayLiteralBody(\Context\ArrayLiteralBodyContext $body, Type $elemType): array
    {
        $list = $body->arrayElementList();
        if ($list === null) return [];
        $elements = [];
        $elCtxs = $list->arrayElement(null);
        $elCtxs = is_array($elCtxs) ? $elCtxs : [$elCtxs];
        foreach (array_filter($elCtxs) as $el) {
            if ($el->expression() !== null) {
                $elements[] = $this->evaluateExpression($el->expression());
            } elseif ($el->arrayLiteralBody() !== null) {
                $innerType = $elemType->arrayInfo['element'] ?? $elemType;
                $inner = $this->evaluateArrayLiteralBody($el->arrayLiteralBody(), $innerType);
                $elements[] = Value::array($inner, $innerType);
            }
        }
        return $elements;
    }

    public function visitArrayAccess(\Context\ArrayAccessContext $context): mixed
    {
        $qi = $context->qualifiedIdentifier();
        if ($qi === null) return Value::nil();
        $tokens = $qi->IDENTIFIER(null);
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        $name = $tokens[0] !== null ? $tokens[0]->getText() : '';
        $elem = $this->resolveValue($name);
        if ($elem === null || !is_array($elem->data)) return Value::nil();
        $exprs = $context->expression(null);
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        foreach (array_filter($exprs) as $e) {
            $arr = $elem->data;
            if (!is_array($arr)) return Value::nil();
            $idx = (int) $this->evaluateExpression($e)->data;
            $size = count($arr);
            if ($idx < 0 || $idx >= $size) {
                throw new \RuntimeException("Índice fuera de rango: {$idx} para array de tamaño {$size}.");
            }
            $elem = $arr[$idx] instanceof Value ? $arr[$idx] : Value::nil();
        }
        return $elem;
    }

    public function visitFunctionCall(\Context\FunctionCallContext $context): mixed
    {
        $qi = $context->qualifiedIdentifier();
        if ($qi === null) return Value::nil();
        $tokens = $qi->IDENTIFIER(null);
        $tokens = is_array($tokens) ? $tokens : [$tokens];
        $tokens = array_values(array_filter($tokens));
        $name = $tokens[0] !== null ? $tokens[0]->getText() : '';
        $isBuiltIn = count($tokens) > 1;
        $args = [];
        if ($context->argumentList() !== null) {
            $exprs = $context->argumentList()->expression(null);
            $exprs = is_array($exprs) ? $exprs : [$exprs];
            foreach ($exprs as $e) {
                if ($e !== null) $args[] = $this->evaluateExpression($e);
            }
        }
        if ($isBuiltIn || $name === 'fmt.Println' || str_contains($name, 'Println')) {
            $parts = [];
            foreach ($args as $v) {
                $parts[] = $this->valueToString($v);
            }
            $this->output .= implode(' ', $parts) . "\n";
            return Value::nil();
        }
        $builtInResult = $this->executeBuiltIn($name, $args);
        if ($builtInResult !== null) {
            return $builtInResult;
        }
        $values = $this->invokeUserFunction($name, $args);
        return $values[0] ?? Value::nil();
    }

    /**
     * Invoca una función definida por el usuario y devuelve todos sus valores de retorno.
     * @param list<Value> $argValues
     * @return list<Value>
     */
    private function invokeUserFunction(string $name, array $argValues): array
    {
        $decl = $this->functionDecls[$name] ?? null;
        if ($decl === null) {
            return [Value::nil()];
        }
        $sym = $this->symbolTable->resolve($name);
        $paramNames = [];
        if ($decl->parameters() !== null) {
            $params = $decl->parameters()->parameter(null);
            $params = is_array($params) ? $params : [$params];
            foreach ($params as $p) {
                if ($p !== null && $p->IDENTIFIER() !== null) {
                    $paramNames[] = $p->IDENTIFIER()->getText();
                }
            }
        }
        $this->pushScope();
        foreach ($paramNames as $i => $pname) {
            $val = $argValues[$i] ?? Value::nil();
            $this->defineValue($pname, $val);
        }
        try {
            $block = $decl->block();
            if ($block !== null) {
                $this->visit($block);
            }
            return [];
        } catch (ReturnException $e) {
            return $e->values;
        } finally {
            $this->popScope();
        }
    }

    /**
     * Ejecuta built-in len, now, substr, typeOf. Retorna null si no es built-in.
     * @param list<Value> $args
     */
    private function executeBuiltIn(string $name, array $args): ?Value
    {
        if ($name === BuiltIns::LEN) {
            if (count($args) !== 1) return Value::nil();
            $v = $args[0];
            if ($v->type->name === Type::STRING) {
                return Value::int(\strlen((string) $v->data));
            }
            if ($v->type->isArray() && is_array($v->data)) {
                return Value::int(count($v->data));
            }
            return Value::nil();
        }
        if ($name === BuiltIns::NOW) {
            return Value::string(date('Y-m-d H:i:s'));
        }
        if ($name === BuiltIns::SUBSTR) {
            if (count($args) !== 3) return Value::nil();
            $s = (string) $args[0]->data;
            $start = (int) $args[1]->data;
            $end = (int) $args[2]->data;
            $len = \strlen($s);
            if ($start < 0) $start = 0;
            if ($end > $len) $end = $len;
            if ($start >= $end) return Value::string('');
            return Value::string(substr($s, $start, $end - $start));
        }
        if ($name === BuiltIns::TYPEOF) {
            if (count($args) !== 1) return Value::string('nil');
            $v = $args[0];
            if ($v->isNil()) return Value::string('nil');
            return Value::string($v->type->__toString());
        }
        return null;
    }

    public function visitAddition(\Context\AdditionContext $context): mixed
    {
        $mults = $context->multiplication(null);
        $mults = is_array($mults) ? $mults : [$mults];
        $result = null;
        $opIdx = 0;
        $childCount = $context->getChildCount();
        foreach ($mults as $i => $m) {
            if ($m === null) continue;
            $v = $this->visit($m);
            $v = $v instanceof Value ? $v : Value::nil();
            if ($result === null) {
                $result = $v;
                continue;
            }
            $op = null;
            for ($j = $opIdx; $j < $childCount; $j++) {
                $t = $context->getChild($j);
                if (method_exists($t, 'getText')) {
                    $txt = $t->getText();
                    if ($txt === '+' || $txt === '-') {
                        $op = $txt;
                        $opIdx = $j + 1;
                        break;
                    }
                }
            }
            if ($op === '+') $result = $this->addValues($result, $v);
            elseif ($op === '-') $result = $this->subValues($result, $v);
        }
        return $result ?? Value::nil();
    }

    public function visitMultiplication(\Context\MultiplicationContext $context): mixed
    {
        $unaries = $context->unary(null);
        $unaries = is_array($unaries) ? $unaries : [$unaries];
        $result = null;
        $opIdx = 0;
        $childCount = $context->getChildCount();
        foreach ($unaries as $i => $u) {
            if ($u === null) continue;
            $v = $this->visit($u);
            $v = $v instanceof Value ? $v : Value::nil();
            if ($result === null) {
                $result = $v;
                continue;
            }
            $op = null;
            for ($j = $opIdx; $j < $childCount; $j++) {
                $t = $context->getChild($j);
                if (method_exists($t, 'getText')) {
                    $txt = $t->getText();
                    if ($txt === '*' || $txt === '/' || $txt === '%') {
                        $op = $txt;
                        $opIdx = $j + 1;
                        break;
                    }
                }
            }
            if ($op === '*') $result = $this->mulValues($result, $v);
            elseif ($op === '/') $result = $this->divValues($result, $v);
            elseif ($op === '%') $result = $this->modValues($result, $v);
        }
        return $result ?? Value::nil();
    }

    public function visitUnary(\Context\UnaryContext $context): mixed
    {
        $childCount = $context->getChildCount();
        if ($childCount >= 2) {
            $first = $context->getChild(0);
            $op = method_exists($first, 'getText') ? $first->getText() : null;
            $inner = $context->unary();
            if ($inner !== null) {
                if ($op === '&') {
                    $varName = $this->getVariableNameFromUnary($inner);
                    if ($varName !== null) {
                        [$_, $scopeIdx] = $this->resolveValueAndScope($varName);
                        if ($scopeIdx !== null) {
                            return Value::pointer($scopeIdx, $varName);
                        }
                    }
                    return Value::nil();
                }
                if ($op === '*') {
                    $v = $this->visit($inner);
                    if ($v instanceof Value && $v->isPointerRef()) {
                        $ref = $this->getValueByRef($v->data['scope'], $v->data['name']);
                        return $ref ?? Value::nil();
                    }
                    return Value::nil();
                }
                $v = $this->visit($inner);
                if ($v instanceof Value && $op === '-') {
                    if ($v->type->name === Type::INT32) return Value::int(- (int) $v->data);
                    if ($v->type->name === Type::FLOAT32) return Value::float(- (float) $v->data);
                }
                if ($v instanceof Value && $op === '!') {
                    return Value::bool(! (bool) $v->data);
                }
            }
        }
        return $this->visitChildren($context);
    }

    private function getVariableNameFromUnary(?\Context\UnaryContext $unary): ?string
    {
        if ($unary === null) return null;
        if ($unary->primary() !== null) {
            $prim = $unary->primary();
            if ($prim->qualifiedIdentifier() !== null) {
                $qi = $prim->qualifiedIdentifier();
                $tokens = $qi->IDENTIFIER(null);
                $tokens = is_array($tokens) ? $tokens : [$tokens];
                if (count($tokens) === 1 && $tokens[0] !== null) {
                    return $tokens[0]->getText();
                }
            }
            return null;
        }
        if ($unary->unary() !== null) {
            return $this->getVariableNameFromUnary($unary->unary());
        }
        return null;
    }

    public function visitLogicalOr(\Context\LogicalOrContext $context): mixed
    {
        $exprs = $context->logicalAnd(null);
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        $last = Value::bool(false);
        foreach ($exprs as $e) {
            if ($e === null) continue;
            $v = $this->visit($e);
            $last = $v instanceof Value ? $v : Value::nil();
            if ((bool) $last->data === true) {
                return $last;
            }
        }
        return $last;
    }

    public function visitLogicalAnd(\Context\LogicalAndContext $context): mixed
    {
        $exprs = $context->equality(null);
        $exprs = is_array($exprs) ? $exprs : [$exprs];
        $last = Value::bool(true);
        foreach ($exprs as $e) {
            if ($e === null) continue;
            $v = $this->visit($e);
            $last = $v instanceof Value ? $v : Value::nil();
            if ((bool) $last->data === false) {
                return Value::bool(false);
            }
        }
        return $last;
    }

    public function visitEquality(\Context\EqualityContext $context): mixed
    {
        $comps = $context->comparison(null);
        $comps = is_array($comps) ? $comps : [$comps];
        if (count($comps) < 2 || $comps[0] === null) {
            return isset($comps[0]) && $comps[0] !== null ? $this->visit($comps[0]) : Value::nil();
        }
        $a = $this->visit($comps[0]);
        $b = $this->visit($comps[1]);
        $op = null;
        for ($i = 0; $i < $context->getChildCount(); $i++) {
            $t = $context->getChild($i);
            if (method_exists($t, 'getText')) {
                $txt = $t->getText();
                if ($txt === '==' || $txt === '!=') { $op = $txt; break; }
            }
        }
        if ($op === '==') return Value::bool($this->valueEquals($a, $b));
        if ($op === '!=') return Value::bool(!$this->valueEquals($a, $b));
        return $a instanceof Value ? $a : Value::nil();
    }

    public function visitComparison(\Context\ComparisonContext $context): mixed
    {
        $adds = $context->addition(null);
        $adds = is_array($adds) ? $adds : [$adds];
        if (count($adds) < 2 || $adds[0] === null) {
            return isset($adds[0]) && $adds[0] !== null ? $this->visit($adds[0]) : Value::nil();
        }
        $a = $this->visit($adds[0]);
        $b = $this->visit($adds[1]);
        $op = null;
        for ($i = 0; $i < $context->getChildCount(); $i++) {
            $t = $context->getChild($i);
            if (method_exists($t, 'getText')) {
                $txt = $t->getText();
                if (in_array($txt, ['>', '>=', '<', '<='], true)) { $op = $txt; break; }
            }
        }
        $va = $a instanceof Value ? $a : Value::nil();
        $vb = $b instanceof Value ? $b : Value::nil();
        $cmp = $this->compareValues($va, $vb);
        if ($op === '>') return Value::bool($cmp > 0);
        if ($op === '>=') return Value::bool($cmp >= 0);
        if ($op === '<') return Value::bool($cmp < 0);
        if ($op === '<=') return Value::bool($cmp <= 0);
        return $va;
    }

    public function visitExpression(\Context\ExpressionContext $context): mixed
    {
        return $this->visitChildren($context);
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
            return Type::arrayOf($elem, null);
        }
        if ($typeContext->pointerType() !== null) {
            $inner = $typeContext->pointerType()->type();
            return $inner !== null ? Type::pointerTo($this->resolveType($inner)) : Type::nil();
        }
        return Type::nil();
    }

    private function defaultForType(Type $type): Value
    {
        if ($type->isArray() && $type->arrayInfo !== null) {
            $elemType = $type->arrayInfo['element'];
            $len = $type->arrayInfo['length'] ?? 0;
            $elements = [];
            for ($i = 0; $i < $len; $i++) {
                $elements[] = $this->defaultForType($elemType);
            }
            return Value::array($elements, $elemType, $len);
        }
        switch ($type->name) {
            case Type::INT32: return Value::int(0);
            case Type::FLOAT32: return Value::float(0.0);
            case Type::BOOL: return Value::bool(false);
            case Type::STRING: return Value::string('');
            case Type::RUNE: return Value::rune("\0");
        }
        return Value::nil();
    }

    private function valueToString(Value $v): string
    {
        if ($v->isNil()) return 'nil';
        if ($v->type->name === Type::BOOL) return $v->data ? 'true' : 'false';
        if ($v->type->isArray() && is_array($v->data)) {
            $parts = [];
            foreach ($v->data as $el) {
                $parts[] = $el instanceof Value ? $this->valueToString($el) : (string) $el;
            }
            return '[' . implode(' ', $parts) . ']';
        }
        return (string) $v->data;
    }

    private function unescapeString(string $s): string
    {
        $s = trim($s, '"\'');
        return stripcslashes($s);
    }

    private function addValues(Value $a, Value $b): Value
    {
        if ($a->type->name === Type::INT32 && $b->type->name === Type::INT32) {
            return Value::int((int)$a->data + (int)$b->data);
        }
        if ($a->type->name === Type::FLOAT32 || $b->type->name === Type::FLOAT32) {
            return Value::float((float)$a->data + (float)$b->data);
        }
        if ($a->type->name === Type::STRING || $b->type->name === Type::STRING) {
            return Value::string((string)$a->data . (string)$b->data);
        }
        return Value::nil();
    }

    private function subValues(Value $a, Value $b): Value
    {
        if ($a->type->name === Type::INT32 && $b->type->name === Type::INT32) {
            return Value::int((int)$a->data - (int)$b->data);
        }
        return Value::float((float)$a->data - (float)$b->data);
    }

    private function mulValues(Value $a, Value $b): Value
    {
        if ($a->type->name === Type::INT32 && $b->type->name === Type::INT32) {
            return Value::int((int)$a->data * (int)$b->data);
        }
        return Value::float((float)$a->data * (float)$b->data);
    }

    private function divValues(Value $a, Value $b): Value
    {
        if ((float)$b->data === 0.0) return Value::nil();
        if ($a->type->name === Type::INT32 && $b->type->name === Type::INT32) {
            return Value::int((int)$a->data / (int)$b->data);
        }
        return Value::float((float)$a->data / (float)$b->data);
    }

    private function modValues(Value $a, Value $b): Value
    {
        if ((int)$b->data === 0) return Value::nil();
        return Value::int((int)$a->data % (int)$b->data);
    }

    private function valueEquals($a, $b): bool
    {
        $va = $a instanceof Value ? $a : Value::nil();
        $vb = $b instanceof Value ? $b : Value::nil();
        if ($va->isNil() && $vb->isNil()) return true;
        if ($va->isNil() || $vb->isNil()) return false;
        return $va->data == $vb->data;
    }

    private function compareValues(Value $a, Value $b): int
    {
        $x = $a->data;
        $y = $b->data;
        if (is_int($x) && is_int($y)) return $x <=> $y;
        return (float)$x <=> (float)$y;
    }
}
