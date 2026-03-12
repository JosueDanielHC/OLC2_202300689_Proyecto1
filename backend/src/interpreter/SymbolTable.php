<?php

declare(strict_types=1);

namespace Golampi\interpreter;

/**
 * Pila de ámbitos (scopes) para el análisis semántico.
 */
class SymbolTable
{
    /** @var list<array<string, Symbol>> Pila de scopes; cada scope es un mapa nombre -> símbolo */
    private array $scopes = [];

    public function __construct()
    {
        $this->pushScope();
    }

    public function pushScope(): void
    {
        $this->scopes[] = [];
    }

    public function popScope(): void
    {
        if (count($this->scopes) <= 1) {
            return;
        }
        array_pop($this->scopes);
    }

    /**
     * Define un símbolo en el scope actual.
     * @throws \RuntimeException si ya existe en el mismo scope (redeclaración)
     */
    public function define(string $name, Symbol $symbol): void
    {
        $idx = count($this->scopes) - 1;
        if (isset($this->scopes[$idx][$name])) {
            throw new \RuntimeException("Identificador '$name' ya declarado en este ámbito.");
        }
        $this->scopes[$idx][$name] = $symbol;
    }

    /**
     * Resuelve un nombre desde el scope más interno hacia afuera.
     */
    public function resolve(string $name): ?Symbol
    {
        for ($i = count($this->scopes) - 1; $i >= 0; $i--) {
            if (isset($this->scopes[$i][$name])) {
                return $this->scopes[$i][$name];
            }
        }
        return null;
    }

    /** Comprueba si está declarado en el scope actual (solo el tope) */
    public function isDefinedInCurrentScope(string $name): bool
    {
        $idx = count($this->scopes) - 1;
        return isset($this->scopes[$idx][$name]);
    }

    public function getScopeCount(): int
    {
        return count($this->scopes);
    }

    /**
     * Para reportes: devuelve todos los símbolos con su ámbito (índice de scope).
     * @return array<int, array<string, Symbol>>
     */
    public function getAllScopes(): array
    {
        return $this->scopes;
    }
}
