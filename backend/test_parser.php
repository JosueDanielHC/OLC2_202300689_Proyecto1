<?php

/**
 * Test completo: Parser + Análisis semántico + Ejecución.
 * Valida que la gramática Golampi.g4 y las fases implementadas funcionen bien.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/generated/GolampiLexer.php';
require_once __DIR__ . '/generated/GolampiParser.php';
require_once __DIR__ . '/generated/GolampiVisitor.php';
require_once __DIR__ . '/generated/GolampiBaseVisitor.php';

use Antlr\Antlr4\Runtime\CommonTokenStream;
use Antlr\Antlr4\Runtime\Error\Listeners\BaseErrorListener;
use Antlr\Antlr4\Runtime\InputStream;
use Antlr\Antlr4\Runtime\Recognizer;
use Antlr\Antlr4\Runtime\Tree\ParseTree;

function printTree(ParseTree $node, $parser, int $indent = 0): void
{
    if (method_exists($node, 'getRuleIndex')) {
        $ruleNames = $parser->getRuleNames();
        $nodeName = $ruleNames[$node->getRuleIndex()];
    } else {
        $nodeName = $node->getText();
    }
    echo str_repeat("  ", $indent) . $nodeName . PHP_EOL;
    for ($i = 0; $i < $node->getChildCount(); $i++) {
        printTree($node->getChild($i), $parser, $indent + 1);
    }
}

function runPipeline(string $code, bool $verbose = true): array
{
    $input = InputStream::fromString($code);
    $lexer = new GolampiLexer($input);
    $tokens = new CommonTokenStream($lexer);
    $parser = new GolampiParser($tokens);
    $parser->removeErrorListeners();
    $parser->addErrorListener(new class extends BaseErrorListener {
        public function syntaxError(
            Recognizer $recognizer,
            ?object $offendingSymbol,
            int $line,
            int $charPositionInLine,
            string $msg,
            ?\Antlr\Antlr4\Runtime\Error\Exceptions\RecognitionException $exception,
        ): void {
            echo "❌ Error sintáctico en línea $line:$charPositionInLine -> $msg\n";
        }
    });

    $tree = $parser->program();
    $parseOk = $tree !== null;

    $semantic = new \Golampi\Visitors\SemanticVisitor();
    $semantic->visit($tree);
    $semanticOk = !$semantic->hasErrors();
    $errors = $semantic->getErrorHandler()->getErrors();
    $functions = $semantic->getFunctions();
    $symbolTable = $semantic->getSymbolTable();

    $execOutput = '';
    $execOk = false;
    if ($parseOk && $semanticOk) {
        $exec = new \Golampi\Visitors\ExecutionVisitor($symbolTable);
        $exec->visit($tree);
        $execOutput = $exec->getOutput();
        $execOk = true;
    }

    return [
        'parse_ok'     => $parseOk,
        'semantic_ok'  => $semanticOk,
        'exec_ok'      => $execOk,
        'errors'       => $errors,
        'functions'    => $functions,
        'symbol_table' => $symbolTable,
        'output'       => $execOutput,
        'tree'         => $tree,
        'parser'       => $parser,
        'verbose'      => $verbose,
    ];
}

// =============================================================================
// 1) Leer archivo de prueba
// =============================================================================

$inputFile = __DIR__ . '/../tests/test.golampi';
if (!file_exists($inputFile)) {
    die("❌ No se encontró tests/test.golampi\n");
}

$code = file_get_contents($inputFile);

// =============================================================================
// 2) Ejecutar pipeline (parse → semántico → ejecución)
// =============================================================================

echo "=============================\n";
echo "🌳 Árbol Sintáctico (gramática Golampi.g4)\n";
echo "=============================\n\n";

$result = runPipeline($code, true);

if ($result['verbose'] && $result['tree'] !== null && $result['parser'] !== null) {
    printTree($result['tree'], $result['parser']);
    echo "\n";
}

// =============================================================================
// 3) Validaciones de fases
// =============================================================================

$allOk = true;

echo "=============================\n";
echo "✅ Validación de fases\n";
echo "=============================\n\n";

// Fase sintáctica
echo "1️⃣ Parse (gramática): " . ($result['parse_ok'] ? "OK" : "FALLO") . "\n";
if (!$result['parse_ok']) $allOk = false;

// Fase A: una sola main, sin params ni retorno
$hasMain = in_array('main', $result['functions'], true);
$mainCount = count(array_filter($result['functions'], fn($f) => $f === 'main'));
echo "2️⃣ Fase A (main única, sin params/retorno): " . ($hasMain && $mainCount === 1 && $result['semantic_ok'] ? "OK" : "FALLO") . "\n";
if (!$result['semantic_ok'] && $hasMain) {
    foreach ($result['errors'] as $e) {
        echo "   - {$e['message']}\n";
    }
}
if (!$result['semantic_ok']) $allOk = false;

// Fase B/C: tabla de símbolos y scopes
$symbolTable = $result['symbol_table'] ?? null;
$scopes = $result['parse_ok'] && $result['semantic_ok'] && $symbolTable !== null ? $symbolTable->getAllScopes() : [];
$totalSyms = 0;
foreach ($scopes as $scope) {
    $totalSyms += count($scope);
}
echo "3️⃣ Fase B/C (SymbolTable + scopes): " . ($result['semantic_ok'] && $totalSyms >= 1 ? "OK ($totalSyms símbolos)" : "FALLO") . "\n";

// Fase F: ejecución y salida
$expectedOutput = "5\n";
$outputMatch = trim($result['output'] ?? '') === trim($expectedOutput);
echo "4️⃣ Fase F (ejecución, fmt.Println(x)): " . ($result['exec_ok'] && $outputMatch ? "OK" : "FALLO") . "\n";
if ($result['exec_ok'] && !$outputMatch) {
    echo "   Esperado: " . json_encode($expectedOutput) . "\n";
    echo "   Obtenido: " . json_encode($result['output']) . "\n";
}
if (!$outputMatch && $result['exec_ok']) $allOk = false;

echo "\n";
echo "=============================\n";
if ($allOk) {
    echo "✅ Todas las fases OK. Gramática y pipeline correctos.\n";
} else {
    echo "❌ Alguna fase falló. Revisar arriba.\n";
}
echo "=============================\n";

// Mostrar salida del programa
if ($result['output'] !== '') {
    echo "\n📺 Salida del programa:\n";
    echo $result['output'];
}

exit($allOk ? 0 : 1);
