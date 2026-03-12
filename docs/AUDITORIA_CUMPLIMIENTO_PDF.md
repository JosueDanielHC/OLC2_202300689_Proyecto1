# Auditoría formal de cumplimiento — Golampi vs Proyecto1.pdf

Verificación sección por sección contra el documento oficial. Sin interpretación; solo hechos.

---

## PARTE 1 — ANÁLISIS SEMÁNTICO

### 1️⃣ Tipos estáticos (PDF §3.2.3)

| Requisito PDF | Estado | Detalle |
|---------------|--------|---------|
| int32, float32, bool, rune, string modelados | ✅ Cumple | `Type.php`: constantes y factories; gramática `baseType`. |
| Valor por defecto (0, 0.0, false, '\u0000', "") | ✅ Cumple | `ExecutionVisitor::defaultForType()` asigna valores por defecto en ejecución. |
| nil como tipo / valor | ⚠️ Parcial | `Type::nil()` existe; no está en tablas del TypeSystem (operaciones con nil → error). Invalid combos dan error semántico; no hay regla explícita "operación sobre nil → error y dar nil". |
| "Cualquier operación sobre nil será error y dará nil" | 🟡 Importante | No modelado explícitamente: nil no en tablas aritméticas/relacionales, por lo que se reporta error; "dar nil como resultado" en ejecución no verificado. |

### 2️⃣ Operadores aritméticos (PDF §3.3.6)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Tablas +, -, *, /, % según PDF | ✅ Cumple | `TypeSystem.php`: matrices verificadas frente a especificación oficial. |
| Sin combinaciones extra | ✅ Cumple | Solo las filas/columnas del PDF. |
| Sin promociones implícitas fuera de tabla | ✅ Cumple | Solo lookup en matrices. |
| Resultado inválido → error semántico | ✅ Cumple | `visitAddition`, `visitMultiplication`, etc. reportan error vía ErrorHandler. |

### 3️⃣ Operadores relacionales (PDF §3.3.7)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Igualdad/desigualdad según tabla | ✅ Cumple | `$equalityTable`: int32/float32/rune entre sí; bool con bool; string con string. |
| Comparaciones de magnitud | ✅ Cumple | `$relationalTable` coherente con PDF. |
| Resultado siempre bool | ✅ Cumple | Tipo resultado bool en tablas. |

### 4️⃣ Operadores lógicos (PDF §3.3.8)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Solo bool permitido | ✅ Cumple | TypeSystem y SemanticVisitor validan bool en &&, \|\|, !. |
| Cortocircuito obligatorio en ejecución | ✅ Cumple | `ExecutionVisitor::visitLogicalAnd`: si primer operando false, retorna sin evaluar resto. `visitLogicalOr`: si true, retorna sin evaluar resto. |

### 5️⃣ Variables (PDF §3.3.2)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Declaración normal (var id tipo [= exp]) | ✅ Cumple | `visitVarDecl`; tipo obligatorio; inicialización opcional con valor por defecto. |
| Declaración corta (:=) | ⚠️ Parcial | Implementada; **restricción PDF**: "al menos una variable nueva". Implementación actual: error si **cualquier** id ya existe en el scope → más estricta. PDF permite que algunas existan si al menos una es nueva. |
| No redeclaración en mismo scope | ✅ Cumple | SymbolTable::define lanza / ErrorHandler. |
| Inicialización por defecto si no se asigna | ✅ Cumple | ExecutionVisitor asigna defaultForType cuando no hay expressionList. |

### 6️⃣ Constantes (PDF §3.3.3)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Inicialización obligatoria | ✅ Cumple | visitConstDecl reporta error si falta expression. |
| Prohibición de reasignación | ✅ Cumple | visitAssignment comprueba LHS; si symbol->kind === 'constant' reporta error. |

### 7️⃣ Scope (PDF §3.3.1, bloques)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Scope global | ✅ Cumple | SymbolTable pushScope en constructor. |
| Scope por función | ✅ Cumple | pushScope en visitFunctionDecl. |
| Scope por bloque | ✅ Cumple | pushScope en visitBlock. |
| Scope por if | ✅ Cumple | El bloque del if es un block → pushScope en visitBlock. |
| Scope por for | ✅ Cumple | El cuerpo del for es block → pushScope. |
| Scope por switch | ✅ Cumple | pushScope en visitSwitchStmt; además visitCaseClause y visitDefaultClause hacen pushScope. |
| Hoisting de funciones | 🔴 Crítico | **No implementado.** PDF: "todas las funciones se consideran declaradas antes de la ejecución del programa". Actualmente se hace un solo recorrido: al analizar main(), si se llama a saludar() y saludar() está declarada después en el código, aún no está en la tabla → "Función no declarada". Debe existir una fase previa que registre todas las funciones (nombre + firma) en scope global antes de analizar cuerpos. |

### 8️⃣ Función main (PDF §3.3.14)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Existe exactamente una | ✅ Cumple | visitProgram comprueba mainCount === 1. |
| No recibe parámetros | ✅ Cumple | visitFunctionDecl reporta error si main tiene parameters. |
| No retorna valores | ✅ Cumple | visitFunctionDecl reporta error si main tiene returnType; visitReturnStmt reporta si main retorna expresión. |
| No puede ser invocada explícitamente | 🔴 Crítico | **No validado.** No hay comprobación en visitFunctionCall que prohíba main() como llamada. Debe añadirse: si funcName === 'main' → error semántico. |
| Es la primera ejecutada | ✅ Cumple | ExecutionVisitor::visitProgram localiza main y ejecuta solo su block. |

### 9️⃣ Return (PDF §3.3.10, §3.3.12)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Coincidencia de tipos | ✅ Cumple | visitReturnStmt compara tipo de expresión con currentFunctionReturnType. |
| Múltiples retornos (return a, b) | ⚠️ Parcial | Gramática y SemanticVisitor aceptan returnType (tipo1, tipo2); ExecutionVisitor guarda returnValues[] pero **no se ejecutan llamadas a funciones definidas por el usuario**: solo se ejecuta el bloque de main. Por tanto múltiples retornos no se usan en práctica. |
| Validación de cantidad en return | ✅ Cumple | Firma con N tipos; se validan argumentos en llamadas. |
| Todas las rutas retornan | ✅ Cumple | blockGuaranteesReturn, ifStmtGuaranteesReturn, switchStmtGuaranteesReturn. |
| Errores si faltan retornos | ✅ Cumple | "No todas las rutas retornan un valor" y "debe tener al menos un return". |

### 🔟 Switch (PDF §3.3.9)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Tipo compatible con casos | ✅ Cumple | Expresión del switch con tipo definido; casos por estructura. |
| Validación de duplicados | ✅ Cumple | validateDuplicateCases en visitSwitchStmt. |
| Manejo de default | ✅ Cumple | defaultClause con scope propio; incluido en flujo de retorno si aplica. |
| Scope interno por case | ✅ Cumple | visitCaseClause y visitDefaultClause hacen pushScope/popScope. |

### 1️⃣1️⃣ For (PDF §3.3.9)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Tres formas (for clause; for cond; for {}) | ✅ Cumple | Gramática forStmt con forClause, expression o block. |
| Condición booleana | ✅ Cumple | visitForStmt valida tipo bool de la condición. |
| Scope interno | ✅ Cumple | Cuerpo es block. |
| break/continue validados | ✅ Cumple | visitBreakStmt y visitContinueStmt comprueban loopDepth/switchDepth. |

### 1️⃣2️⃣ Arreglos (PDF §3.3.11)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Tamaño parte del tipo | ✅ Cumple | Type::arrayOf($element, $length); arrayInfo['length']. |
| Multidimensionalidad | ✅ Cumple | Gramática y Type permiten array de array. |
| Validación de tamaño en inicialización | 🟡 Importante | No verificado que literal [N]T{...} tenga exactamente N elementos. |
| Índice debe ser int32 | ✅ Cumple | visitArrayAccess valida tipo del índice. |
| Tipo homogéneo | ✅ Cumple | resolveType para arrayType con tipo elemento. |
| Valor por defecto en elementos | 🟡 Importante | En ejecución: ExecutionVisitor no implementa visitArrayAccess ni visitArrayLiteral (no hay evaluación de arrays en ejecución). |
| Asignación válida | ✅ Cumple | TypeSystem/SemanticVisitor permiten asignación cuando tipos coinciden (arrays por equals). |

### 1️⃣3️⃣ Punteros (PDF §3.3.12)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Tipos puntero | ✅ Cumple | Type::pointerTo; gramática pointerType. |
| Operador & | ⚠️ Parcial | Gramática unary incluye '&'; **en ejecución no hay manejo**: no se calcula dirección ni se guarda puntero. |
| Operador * | ⚠️ Parcial | Gramática unary incluye '*'; **en ejecución no hay desreferenciación**. |
| Paso por referencia | 🔴 Crítico | **No implementado en ejecución.** Semántica de punteros y llamadas con *T no ejecutada. |
| Validación de desreferenciación | 🟡 Importante | SemanticVisitor no valida explícitamente que * solo se aplique a expresiones de tipo puntero. |

### 1️⃣4️⃣ Funciones embebidas (PDF §3.3.13)

| Función | Semántico | Ejecución |
|---------|-----------|-----------|
| fmt.Println | ✅ Validada como built-in (no se exige en tabla) | ✅ Implementada en visitFunctionCall. |
| len | 🔴 No validada (ni rechazada) | 🔴 No implementada. |
| now | 🔴 No validada | 🔴 No implementada. |
| substr | 🔴 No validada | 🔴 No implementada. |
| typeOf | 🔴 No validada | 🔴 No implementada. |

Número de parámetros, tipos y tipo de retorno de len, now, substr, typeOf no se comprueban. Uso incorrecto no genera error semántico explícito.

---

## PARTE 2 — EJECUCIÓN

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Ejecución inicia en main | ✅ Cumple | visitProgram busca main y ejecuta su block. |
| Cortocircuito en && y \|\| | ✅ Cumple | visitLogicalAnd / visitLogicalOr salen sin evaluar resto. |
| Múltiples retornos ejecutados | 🔴 Crítico | return con varias expresiones se guarda en returnValues pero **no se ejecutan llamadas a funciones definidas por el usuario**: solo se ejecuta main. No hay invocación de otras funciones ni devolución de múltiples valores al caller. |
| Manejo de entorno en llamadas | 🔴 Crítico | No hay llamadas a funciones definidas; solo built-in fmt.Println. |
| Paso por valor | N/A | Sin llamadas a funciones propias. |
| Paso por referencia (punteros) | 🔴 Crítico | No implementado. |

---

## PARTE 3 — REPORTES (PDF §3.4)

### 3.4.1 Reporte de errores

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| No detener al primer error | ✅ Cumple | ErrorHandler acumula; no se lanza excepción que detenga. |
| Tipo (Léxico / Sintáctico / Semántico) | ⚠️ Parcial | ErrorHandler.add(type, ...): tipo es string; errores semánticos se registran. **Errores léxicos/sintácticos**: dependen de si el listener del parser/lexer los envía al mismo ErrorHandler; no verificado en código revisado. |
| Línea y columna | ✅ Cumple | lineCol en cada add. |
| Mensaje claro | ✅ Cumple | Mensajes en español. |
| Formato tabla (#, Tipo, Descripción, Línea, Columna) | ✅ Cumple | ReportGenerator::errorsReport() genera columnas correctas. |

### 3.4.2 Tabla de símbolos

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| Identificador, Tipo, Ámbito, Valor, Línea, Columna | ⚠️ Parcial | Identificador, Tipo, Ámbito, Línea, Columna ✅. **Valor**: siempre "—" en ReportGenerator::symbolTableReport(); no se rellena con valor final (PDF: "valor (si aplica)"). |
| Ámbito (global, función, bloque, ciclo) | ✅ Cumple | scopeLabel con nivel; no se distingue explícitamente "ciclo" como etiqueta. |
| Estado final del análisis/ejecución | ⚠️ Parcial | Tabla refleja análisis semántico; no valores después de ejecución. |

---

## PARTE 4 — ARQUITECTURA (PDF §3.1, GUI obligatoria)

| Requisito | Estado | Detalle |
|-----------|--------|---------|
| GUI existe (obligatorio) | 🔴 Crítico | Existe `frontend/index.html` pero está **vacío** (0 bytes o sin contenido funcional). PDF: "no se calificará una solución que únicamente consuma la API del compilador o que funcione solo por consola". |
| No mezclar lógica del intérprete con frontend | ✅ Cumple | Lógica en backend PHP; frontend no revisado por estar vacío. |
| ANTLR solo para generar parser | ✅ Cumple | Gramática; generados en backend/generated. |
| Backend maneja toda la lógica | ✅ Cumple | Parser, semántico, ejecución en PHP. |

---

# Resumen de omisiones clasificadas

## 🔴 Crítico (puede costar puntos fuertes)

1. **Hoisting de funciones no implementado**: llamar a una función definida más abajo en el código reporta "Función no declarada". El PDF exige que todas las funciones se consideren declaradas antes de ejecutar.
2. **main no puede ser invocada**: no se valida que `main()` no se use como llamada explícita.
3. **Ejecución de funciones definidas por el usuario**: solo se ejecuta el bloque de main. No hay invocación de otras funciones ni uso real de múltiples retornos.
4. **Punteros en ejecución**: operadores `&` y `*` y paso por referencia no implementados en ExecutionVisitor.
5. **GUI no implementada**: `frontend/index.html` vacío; el proyecto no cumple el requisito obligatorio de interfaz gráfica.

## 🟡 Importante (debería corregirse)

1. **Declaración corta (:=)**: PDF exige "al menos una variable nueva"; la implementación actual exige que ninguna exista en el scope (más estricto). Ajustar a: error solo si **todas** las variables ya están declaradas en el scope actual.
2. **nil**: Regla explícita "operación sobre nil → error y dar nil" no modelada; comportamiento actual es error semántico para combos inválidos.
3. **Built-ins len, now, substr, typeOf**: ni validación semántica (parámetros y tipos) ni implementación en ejecución.
4. **Arreglos en ejecución**: visitArrayAccess y visitArrayLiteral no evaluados; no hay lectura/escritura de arrays en tiempo de ejecución.
5. **Validación de tamaño en inicialización de arrays**: no se comprueba que el número de elementos en el literal coincida con el tamaño del tipo.
6. **Reporte tabla de símbolos — Valor**: la columna "Valor" no se rellena con el valor (si aplica); siempre "—".
7. **Desreferenciación * en semántica**: no hay comprobación explícita de que el operando de * sea de tipo puntero.

## 🔵 Mejora de calidad (nivel sobresaliente)

1. **Errores léxicos/sintácticos en el mismo reporte**: asegurar que el listener del parser/lexer inyecte en el mismo ErrorHandler para un único reporte unificado.
2. **Tabla de símbolos post-ejecución**: opcionalmente generar tabla con valores finales después de ejecutar.
3. **Código inalcanzable (después de return)**: advertencia o error opcional.
4. **Etiqueta de ámbito "ciclo"**: en el reporte de tabla de símbolos, distinguir variables declaradas en for.

---

# Recomendación final

- **Nivel actual del proyecto**: **Parcial / en desarrollo.**  
  Análisis semántico sólido (tipos, operadores, scopes, return por flujo, switch, for, constantes, asignación). Ejecución limitada a main y fmt.Println; sin GUI funcional; sin hoisting; sin prohibición de llamar a main; sin punteros ni resto de built-ins en ejecución.

- **Para acercarse al 100% exigido por el PDF**:
  1. Implementar **GUI funcional** (editor, consola, botones, descarga de reportes) según §3.1.2.
  2. **Hoisting**: primer paso que registre todas las funciones en scope global antes de analizar cuerpos.
  3. **Prohibir llamada explícita a main** en visitFunctionCall.
  4. **Ejecución de llamadas a funciones**: invocar cuerpo de la función llamada, bind de argumentos, retorno de valores (incl. múltiples) al caller.
  5. **Built-ins**: implementar y validar len, now, substr, typeOf (semántica + ejecución).
  6. **Punteros en ejecución**: &, *, paso por referencia en parámetros.
  7. **Arrays en ejecución**: evaluar arrayLiteral y arrayAccess, asignación a elementos.
  8. Corregir **declaración corta** a "al menos una nueva".
  9. **Reporte de tabla de símbolos**: rellenar columna Valor cuando corresponda.

- **Para nivel sobresaliente**: unificar reporte de errores (léxico/sintáctico/semántico), tabla de símbolos con valores finales, y mejoras 🔵 anteriores.
