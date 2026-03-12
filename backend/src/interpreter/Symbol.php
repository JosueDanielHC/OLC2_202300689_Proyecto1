<?php

declare(strict_types=1);

namespace Golampi\interpreter;

/**
 * Símbolo en la tabla de símbolos (variable, constante, función, etc.).
 */
class Symbol
{
    public string $name;
    public Type $type;
    public string $kind; // 'variable' | 'constant' | 'function' | 'parameter'
    public ?int $line;
    public ?int $column;

    /** Solo para kind === 'function': tipos de los parámetros (orden). */
    public ?array $paramTypes = null;

    /** Solo para kind === 'function': tipos de retorno (uno o varios). Si múltiples, type = primer tipo. */
    public ?array $returnTypes = null;

    public function __construct(
        string $name,
        Type $type,
        string $kind = 'variable',
        ?int $line = null,
        ?int $column = null,
        ?array $paramTypes = null,
        ?array $returnTypes = null
    ) {
        $this->name        = $name;
        $this->type        = $type;
        $this->kind        = $kind;
        $this->line        = $line;
        $this->column      = $column;
        $this->paramTypes  = $paramTypes;
        $this->returnTypes = $returnTypes;
    }

    public function isFunction(): bool
    {
        return $this->kind === 'function';
    }
}
