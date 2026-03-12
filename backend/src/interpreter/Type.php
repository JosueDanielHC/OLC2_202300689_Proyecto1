<?php

declare(strict_types=1);

namespace Golampi\interpreter;

/**
 * Representación de tipos del lenguaje: primitivos, array, puntero.
 */
class Type
{
    public const INT32   = 'int32';
    public const FLOAT32 = 'float32';
    public const BOOL   = 'bool';
    public const STRING = 'string';
    public const RUNE   = 'rune';
    public const NIL    = 'nil';

    public string $name;
    /** @var null|array{length?: int, element: Type} para arrays */
    public ?array $arrayInfo = null;
    /** Para punteros: tipo apuntado */
    public ?Type $pointedType = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function int32(): self
    {
        return new self(self::INT32);
    }

    public static function float32(): self
    {
        return new self(self::FLOAT32);
    }

    public static function bool(): self
    {
        return new self(self::BOOL);
    }

    public static function string(): self
    {
        return new self(self::STRING);
    }

    public static function rune(): self
    {
        return new self(self::RUNE);
    }

    public static function nil(): self
    {
        return new self(self::NIL);
    }

    /** Array de tipo base con tamaño (opcional) */
    public static function arrayOf(Type $element, ?int $length = null): self
    {
        $t = new self('array');
        $t->arrayInfo = ['element' => $element, 'length' => $length];
        return $t;
    }

    /** Puntero a tipo */
    public static function pointerTo(Type $pointed): self
    {
        $t = new self('pointer');
        $t->pointedType = $pointed;
        return $t;
    }

    public function isPrimitive(): bool
    {
        return in_array($this->name, [self::INT32, self::FLOAT32, self::BOOL, self::STRING, self::RUNE], true);
    }

    public function isArray(): bool
    {
        return $this->arrayInfo !== null;
    }

    public function isPointer(): bool
    {
        return $this->pointedType !== null;
    }

    public function equals(Type $other): bool
    {
        if ($this->name !== $other->name) {
            return false;
        }
        if ($this->arrayInfo !== null && $other->arrayInfo !== null) {
            return $this->arrayInfo['element']->equals($other->arrayInfo['element']);
        }
        if ($this->pointedType !== null && $other->pointedType !== null) {
            return $this->pointedType->equals($other->pointedType);
        }
        return true;
    }

    /** Descripción para reportes (ej. "int32", "[2]int32", "*int32") */
    public function __toString(): string
    {
        if ($this->arrayInfo !== null) {
            $elem = $this->arrayInfo['element'];
            $len  = $this->arrayInfo['length'] ?? null;
            $s    = $len !== null ? "[$len]" : '[]';
            return $s . (string) $elem;
        }
        if ($this->pointedType !== null) {
            return '*' . (string) $this->pointedType;
        }
        return $this->name;
    }
}
