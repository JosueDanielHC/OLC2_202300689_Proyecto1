<?php

declare(strict_types=1);

namespace Golampi\interpreter;

/**
 * Definición de funciones embebidas (built-ins) para validación semántica.
 * fmt.Println se trata como calificador (fmt.Println) en el visitor.
 */
final class BuiltIns
{
    public const LEN    = 'len';
    public const NOW    = 'now';
    public const SUBSTR = 'substr';
    public const TYPEOF = 'typeOf';

    /** @var array<string, array{params: list<Type>, return: Type}> */
    private static array $specs = [];

    private static function init(): void
    {
        if (self::$specs !== []) {
            return;
        }
        self::$specs[self::LEN] = [
            'params' => [/* string | array, validado por tipo */],
            'return' => Type::int32(),
        ];
        self::$specs[self::NOW] = [
            'params' => [],
            'return' => Type::string(),
        ];
        self::$specs[self::SUBSTR] = [
            'params' => [Type::string(), Type::int32(), Type::int32()],
            'return' => Type::string(),
        ];
        self::$specs[self::TYPEOF] = [
            'params' => [/* cualquier tipo */],
            'return' => Type::string(),
        ];
    }

    public static function isBuiltIn(string $name): bool
    {
        self::init();
        return isset(self::$specs[$name]);
    }

    /** @return list<Type>|null null = cualquier cantidad para typeOf (1 arg) */
    public static function paramTypes(string $name): ?array
    {
        self::init();
        return self::$specs[$name]['params'] ?? null;
    }

    public static function returnType(string $name): ?Type
    {
        self::init();
        return self::$specs[$name]['return'] ?? null;
    }

    /** len acepta 1 arg: string o array. */
    public static function lenParamAcceptable(Type $t): bool
    {
        return $t->name === Type::STRING || $t->isArray();
    }
}
