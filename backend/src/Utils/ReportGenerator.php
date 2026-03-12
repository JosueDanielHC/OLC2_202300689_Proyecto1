<?php

declare(strict_types=1);

namespace Golampi\Utils;

use Golampi\interpreter\SymbolTable;
use Golampi\interpreter\Symbol;

/**
 * Genera reportes de análisis: tabla de símbolos y lista de errores.
 */
class ReportGenerator
{
    public function __construct(
        private ErrorHandler $errorHandler,
        private SymbolTable $symbolTable
    ) {
    }

    /** Reporte de errores en formato tabla (para descarga) */
    public function errorsReport(): string
    {
        $lines = ["#\tTipo\tDescripción\tLínea\tColumna"];
        foreach ($this->errorHandler->getErrors() as $i => $e) {
            $lines[] = ($i + 1) . "\t" . ($e['type'] ?? '') . "\t" . ($e['message'] ?? '') . "\t" . ($e['line'] ?? 0) . "\t" . ($e['column'] ?? 0);
        }
        return implode("\n", $lines);
    }

    /** Reporte de tabla de símbolos (para descarga) */
    public function symbolTableReport(): string
    {
        $lines = ["Identificador\tTipo\tÁmbito\tValor\tLínea\tColumna"];
        $scopeNames = ['global', 'función', 'bloque'];
        $scopes = $this->symbolTable->getAllScopes();
        foreach ($scopes as $scopeLevel => $scope) {
            $scopeLabel = $scopeNames[min($scopeLevel, 2)] . ($scopeLevel > 0 ? " (nivel $scopeLevel)" : '');
            foreach ($scope as $name => $symbol) {
                if (!$symbol instanceof Symbol) continue;
                $typeStr = (string) $symbol->type;
                $value = '—';
                $line = $symbol->line ?? 0;
                $col = $symbol->column ?? 0;
                $lines[] = $name . "\t" . $typeStr . "\t" . $scopeLabel . "\t" . $value . "\t" . $line . "\t" . $col;
            }
        }
        return implode("\n", $lines);
    }

    /** Reporte combinado del análisis (resumen) */
    public function analysisReport(): string
    {
        $parts = [];
        $parts[] = "=== Reporte de análisis ===";
        $parts[] = "Errores: " . count($this->errorHandler->getErrors());
        $parts[] = "";
        $parts[] = "--- Errores ---";
        $parts[] = $this->errorsReport();
        $parts[] = "";
        $parts[] = "--- Tabla de símbolos ---";
        $parts[] = $this->symbolTableReport();
        return implode("\n", $parts);
    }
}
