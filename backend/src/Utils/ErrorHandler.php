<?php

declare(strict_types=1);

namespace Golampi\Utils;

/**
 * Acumula errores del análisis (léxico, sintáctico, semántico).
 * No detiene la ejecución; permite registrar y reportar después.
 */
class ErrorHandler
{
    /** @var list<array{type: string, line: int, column: int, message: string}> */
    private array $errors = [];

    public function add(string $type, array $lineCol, string $message): void
    {
        $this->errors[] = [
            'type'    => $type,
            'line'    => $lineCol[0] ?? 0,
            'column'  => $lineCol[1] ?? 0,
            'message' => $message,
        ];
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    /** @return list<array{type: string, line: int, column: int, message: string}> */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function clear(): void
    {
        $this->errors = [];
    }
}
