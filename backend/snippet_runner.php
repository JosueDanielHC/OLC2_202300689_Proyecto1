<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/generated/GolampiLexer.php';
require_once __DIR__ . '/generated/GolampiParser.php';
require_once __DIR__ . '/generated/GolampiVisitor.php';
require_once __DIR__ . '/generated/GolampiBaseVisitor.php';

use Antlr\Antlr4\Runtime\CommonTokenStream;
use Antlr\Antlr4\Runtime\InputStream;

$code = stream_get_contents(STDIN);
if ($code === false) {
    $code = '';
}

$input = InputStream::fromString($code);
$lexer = new GolampiLexer($input);
$tokens = new CommonTokenStream($lexer);
$parser = new GolampiParser($tokens);
$tree = $parser->program();

$semantic = new \Golampi\Visitors\SemanticVisitor();
$semantic->visit($tree);
$errorHandler = $semantic->getErrorHandler();
$errors = $errorHandler->getErrors();

$output = '';
if (!$semantic->hasErrors()) {
    try {
        $exec = new \Golampi\Visitors\ExecutionVisitor($semantic->getSymbolTable());
        $exec->visit($tree);
        $output = $exec->getOutput();
    } catch (\RuntimeException $e) {
        $errors[] = ['type' => 'Ejecución', 'message' => $e->getMessage(), 'line' => 0, 'column' => 0];
    }
}

echo json_encode([
    'errors' => $errors,
    'output' => $output,
], JSON_UNESCAPED_UNICODE);

