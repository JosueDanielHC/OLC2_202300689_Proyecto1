<?php

declare(strict_types=1);

namespace Golampi\interpreter;

/**
 * Sistema de tipos verificado frente a la especificación oficial de compatibilidad Golampi.
 * Todas las validaciones de operadores usan estas matrices; no se usan ifs manuales.
 *
 * Verificación formal (tabla por tabla):
 * - Suma (+): int32(int32,rune,float32), float32(int32,float32,rune), rune(int32,rune,float32), string(string), bool no.
 * - Resta (-): idem suma; bool/string no.
 * - Multiplicación (*): int32(+string→string), float32, rune; string(int32→string); bool no.
 * - División (/): como resta; bool/string no.
 * - Módulo (%): solo int32 y rune entre sí; float32/bool/string no.
 * - Igualdad (==,!=): int32/float32/rune entre sí; bool solo con bool; string solo con string.
 * - Relacionales (>,>=,<,<=): int32/float32/rune entre sí; string(string); bool no.
 * - Asignación: solo igualdad exacta de tipo; sin promoción implícita.
 */
final class TypeSystem
{
    private const INT32 = 'int32';
    private const FLOAT32 = 'float32';
    private const BOOL = 'bool';
    private const RUNE = 'rune';
    private const STRING = 'string';

    /**
     * Tabla aritmética binaria: [operador][tipoIzq][tipoDer] = tipoResultado | null
     * PDF §3.3.6 Operadores Aritméticos
     */
    private static array $arithmeticTable = [
        '+' => [
            self::INT32   => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32],
            self::FLOAT32 => [self::INT32 => self::FLOAT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::FLOAT32],
            self::BOOL    => [],
            self::RUNE    => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32],
            self::STRING  => [self::STRING => self::STRING],
        ],
        '-' => [
            self::INT32   => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32],
            self::FLOAT32 => [self::INT32 => self::FLOAT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::FLOAT32],
            self::BOOL    => [],
            self::RUNE    => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32],
            self::STRING  => [],
        ],
        '*' => [
            self::INT32   => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32, self::STRING => self::STRING],
            self::FLOAT32 => [self::INT32 => self::FLOAT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::FLOAT32],
            self::BOOL    => [],
            self::RUNE    => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32],
            self::STRING  => [self::INT32 => self::STRING],
        ],
        '/' => [
            self::INT32   => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32],
            self::FLOAT32 => [self::INT32 => self::FLOAT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::FLOAT32],
            self::BOOL    => [],
            self::RUNE    => [self::INT32 => self::INT32, self::FLOAT32 => self::FLOAT32, self::RUNE => self::INT32],
            self::STRING  => [],
        ],
        '%' => [
            self::INT32   => [self::INT32 => self::INT32, self::RUNE => self::INT32],
            self::FLOAT32 => [],
            self::BOOL    => [],
            self::RUNE    => [self::INT32 => self::INT32, self::RUNE => self::INT32],
            self::STRING  => [],
        ],
    ];

    /**
     * Negación unaria: [tipoOperando] = tipoResultado | null
     */
    private static array $unaryMinusTable = [
        self::INT32   => self::INT32,
        self::FLOAT32 => self::FLOAT32,
        self::RUNE    => self::INT32,
    ];

    /**
     * Operador ! : solo bool → bool. PDF §3.3.8
     */
    private static array $unaryNotTable = [
        self::BOOL => self::BOOL,
    ];

    /**
     * Igualdad y desigualdad (==, !=): [tipoIzq][tipoDer] = 'bool' | null.
     * Especificación: int32/float32/rune entre sí; bool solo con bool; string solo con string.
     */
    private static array $equalityTable = [
        self::INT32   => [self::INT32 => self::BOOL, self::FLOAT32 => self::BOOL, self::RUNE => self::BOOL],
        self::FLOAT32 => [self::INT32 => self::BOOL, self::FLOAT32 => self::BOOL, self::RUNE => self::BOOL],
        self::BOOL    => [self::BOOL => self::BOOL],
        self::RUNE    => [self::INT32 => self::BOOL, self::FLOAT32 => self::BOOL, self::RUNE => self::BOOL],
        self::STRING  => [self::STRING => self::BOOL],
    ];

    /**
     * Relacionales > >= < <= : [tipoIzq][tipoDer] = 'bool' | null. PDF §3.3.7
     */
    private static array $relationalTable = [
        self::INT32   => [self::INT32 => self::BOOL, self::FLOAT32 => self::BOOL, self::RUNE => self::BOOL],
        self::FLOAT32 => [self::INT32 => self::BOOL, self::FLOAT32 => self::BOOL, self::RUNE => self::BOOL],
        self::BOOL    => [],
        self::RUNE    => [self::INT32 => self::BOOL, self::FLOAT32 => self::BOOL, self::RUNE => self::BOOL],
        self::STRING  => [self::STRING => self::BOOL],
    ];

    /**
     * Asignación: [tipoTarget][tipoSource] = permitido. PDF §3.3.5
     * Sin conversión implícita: solo igualdad exacta de tipo.
     */
    private static array $assignmentTable = [
        self::INT32   => [self::INT32 => true],
        self::FLOAT32 => [self::FLOAT32 => true],
        self::BOOL    => [self::BOOL => true],
        self::RUNE    => [self::RUNE => true],
        self::STRING  => [self::STRING => true],
    ];

    /**
     * Obtiene el nombre primitivo para consultar tablas (int32, float32, bool, rune, string).
     * Para array/pointer devuelve null (validación aparte).
     */
    public static function primitiveName(Type $type): ?string
    {
        if ($type->isArray() || $type->isPointer()) {
            return null;
        }
        $n = $type->name;
        if ($n === 'int') {
            return self::INT32;
        }
        return in_array($n, [self::INT32, self::FLOAT32, self::BOOL, self::RUNE, self::STRING], true) ? $n : null;
    }

    /**
     * Resultado de operador binario aritmético (+, -, *, /, %).
     * @return string|null Tipo resultado o null si combinación inválida
     */
    public static function arithmeticResult(string $op, Type $left, Type $right): ?string
    {
        $l = self::primitiveName($left);
        $r = self::primitiveName($right);
        if ($l === null || $r === null) {
            return null;
        }
        return self::$arithmeticTable[$op][$l][$r] ?? null;
    }

    /**
     * Resultado de negación unaria (-).
     */
    public static function unaryMinusResult(Type $operand): ?string
    {
        $n = self::primitiveName($operand);
        return $n === null ? null : (self::$unaryMinusTable[$n] ?? null);
    }

    /**
     * Resultado de ! operando.
     */
    public static function unaryNotResult(Type $operand): ?string
    {
        $n = self::primitiveName($operand);
        return $n === null ? null : (self::$unaryNotTable[$n] ?? null);
    }

    /**
     * Resultado de == o !=. Siempre bool si válido.
     */
    public static function equalityResult(Type $left, Type $right): ?string
    {
        $l = self::primitiveName($left);
        $r = self::primitiveName($right);
        if ($l === null || $r === null) {
            return null;
        }
        return self::$equalityTable[$l][$r] ?? null;
    }

    /**
     * Resultado de >, >=, <, <=.
     */
    public static function relationalResult(Type $left, Type $right): ?string
    {
        $l = self::primitiveName($left);
        $r = self::primitiveName($right);
        if ($l === null || $r === null) {
            return null;
        }
        return self::$relationalTable[$l][$r] ?? null;
    }

    /**
     * Operadores lógicos: solo bool && bool → bool, bool || bool → bool.
     */
    public static function logicalAndResult(Type $left, Type $right): ?string
    {
        $l = self::primitiveName($left);
        $r = self::primitiveName($right);
        if ($l === self::BOOL && $r === self::BOOL) {
            return self::BOOL;
        }
        return null;
    }

    public static function logicalOrResult(Type $left, Type $right): ?string
    {
        return self::logicalAndResult($left, $right);
    }

    /**
     * Asignación permitida: [tipoTarget][tipoSource] = true.
     * Sin conversión implícita.
     */
    public static function assignmentAllowed(Type $target, Type $source): bool
    {
        if ($target->isArray() || $target->isPointer()) {
            return $target->equals($source);
        }
        $t = self::primitiveName($target);
        $s = self::primitiveName($source);
        if ($t === null || $s === null) {
            return false;
        }
        return self::$assignmentTable[$t][$s] ?? false;
    }

    /**
     * Para +=, -=, *=, /=: el resultado del operador aritmético debe ser asignable al target.
     */
    public static function compoundAssignmentAllowed(string $op, Type $target, Type $source): bool
    {
        $resultType = self::arithmeticResult($op, $target, $source);
        if ($resultType === null) {
            return false;
        }
        $result = new Type($resultType);
        return self::assignmentAllowed($target, $result);
    }
}
