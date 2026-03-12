<?php

/**
 * API HTTP para el intérprete Golampi.
 * Acepta POST con JSON { "code": "..." } y devuelve JSON con resultado, errores y reportes.
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

$input = file_get_contents('php://input');
$body = json_decode($input, true);
$code = $body['code'] ?? '';

if ($code === '') {
    echo json_encode([
        'ok' => true,
        'output' => '',
        'errors' => [],
        'symbolTable' => [],
        'reportResult' => '',
        'reportErrors' => '',
        'reportSymbols' => '',
    ]);
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/generated/GolampiLexer.php';
require_once __DIR__ . '/generated/GolampiParser.php';
require_once __DIR__ . '/generated/GolampiVisitor.php';
require_once __DIR__ . '/generated/GolampiBaseVisitor.php';

use Antlr\Antlr4\Runtime\CommonTokenStream;
use Antlr\Antlr4\Runtime\Error\Listeners\BaseErrorListener;
use Antlr\Antlr4\Runtime\InputStream;
use Antlr\Antlr4\Runtime\Recognizer;

$parseErrors = [];
$input = InputStream::fromString($code);
$lexer = new GolampiLexer($input);
$tokens = new CommonTokenStream($lexer);
$parser = new GolampiParser($tokens);
$parser->removeErrorListeners();
$parser->addErrorListener(new class($parseErrors) extends BaseErrorListener {
    private array $errors;
    public function __construct(array &$errors) { $this->errors = &$errors; }
    public function syntaxError($recognizer, $offendingSymbol, int $line, int $charPositionInLine, string $msg, $e): void {
        $this->errors[] = ['type' => 'Sintáctico', 'message' => $msg, 'line' => $line, 'column' => $charPositionInLine];
    }
});

$tree = $parser->program();
$semantic = new \Golampi\Visitors\SemanticVisitor();
$semantic->visit($tree);
$semanticErrors = $semantic->getErrorHandler()->getErrors();
$errors = array_merge(
    array_map(fn($e) => ['type' => $e['type'] ?? 'Semántico', 'message' => $e['message'] ?? '', 'line' => $e['line'] ?? 0, 'column' => $e['column'] ?? 0], $semanticErrors),
    $parseErrors
);

$symbolTable = $semantic->getSymbolTable();
$symbolTableRows = [];
$scopes = $symbolTable->getAllScopes();
$scopeNames = ['global', 'función', 'bloque'];
foreach ($scopes as $level => $scope) {
    $scopeLabel = $scopeNames[min($level, 2)] ?? "nivel $level";
    foreach ($scope as $name => $sym) {
        if (!$sym instanceof \Golampi\interpreter\Symbol) continue;
        $symbolTableRows[] = [
            'name' => $name,
            'type' => (string) $sym->type,
            'scope' => $scopeLabel,
            'line' => $sym->line ?? 0,
            'column' => $sym->column ?? 0,
        ];
    }
}

$output = '';
$runtimeError = null;
if ($tree !== null && !$semantic->hasErrors() && count($parseErrors) === 0) {
    try {
        $exec = new \Golampi\Visitors\ExecutionVisitor($symbolTable);
        $exec->visit($tree);
        $output = $exec->getOutput();
    } catch (\RuntimeException $e) {
        $runtimeError = ['type' => 'Ejecución', 'message' => $e->getMessage(), 'line' => 0, 'column' => 0];
    }
}
if ($runtimeError !== null) {
    $errors[] = $runtimeError;
}

$reportGen = new \Golampi\Utils\ReportGenerator($semantic->getErrorHandler(), $symbolTable);
$reportResult = $reportGen->analysisReport();
$reportErrors = $reportGen->errorsReport();
$reportSymbols = $reportGen->symbolTableReport();

echo json_encode([
    'ok' => count($errors) === 0,
    'output' => $output,
    'errors' => $errors,
    'symbolTable' => $symbolTableRows,
    'reportResult' => $reportResult,
    'reportErrors' => $reportErrors,
    'reportSymbols' => $reportSymbols,
], JSON_UNESCAPED_UNICODE);
