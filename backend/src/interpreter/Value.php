<?php

declare(strict_types=1);

namespace Golampi\interpreter;

/**
 * Valor en tiempo de ejecución (resultado de evaluar expresiones).
 */
class Value
{
    public mixed $data;
    public Type $type;

    public function __construct(mixed $data, Type $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    public static function int(int $v): self
    {
        return new self($v, Type::int32());
    }

    public static function float(float $v): self
    {
        return new self($v, Type::float32());
    }

    public static function bool(bool $v): self
    {
        return new self($v, Type::bool());
    }

    public static function string(string $v): self
    {
        return new self($v, Type::string());
    }

    public static function rune(string $v): self
    {
        return new self($v, Type::rune());
    }

    public static function nil(): self
    {
        return new self(null, Type::nil());
    }

    /** @param list<Value> $elements */
    public static function array(array $elements, Type $elementType, ?int $length = null): self
    {
        $type = Type::arrayOf($elementType, $length ?? count($elements));
        return new self($elements, $type);
    }

    /** Referencia a variable: data = ['scope' => int, 'name' => string] para resolver en ExecutionVisitor. */
    public static function pointer(int $scopeIndex, string $variableName): self
    {
        $type = Type::pointerTo(Type::nil());
        return new self(['scope' => $scopeIndex, 'name' => $variableName], $type);
    }

    public function isPointerRef(): bool
    {
        return $this->type->isPointer() && is_array($this->data) && isset($this->data['scope'], $this->data['name']);
    }

    public function isNil(): bool
    {
        return $this->type->name === Type::NIL || $this->data === null;
    }
}
