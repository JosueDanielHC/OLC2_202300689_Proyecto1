# Manual de Usuario — Golampi Interpreter

**Proyecto:** Intérprete del lenguaje Golampi  
**Versión:** 1.0  
**Fecha:** [Completar según entrega]

---

## 1. Instalación y requisitos previos

### 1.1 Requisitos

- **PHP** 8.0 o superior (con extensión estándar para JSON y CLI).
- **Composer** (gestor de dependencias de PHP), para instalar el runtime de ANTLR4.
- Navegador web actual (Chrome, Firefox, Edge, Safari).

[Opcional: servidor web Apache/Nginx si no se usa el servidor integrado de PHP.]

### 1.2 Obtención del proyecto

1. Clonar o descargar el repositorio:
   ```bash
   git clone [URL del repositorio]
   cd golampi-interpreter
   ```
2. Instalar dependencias del backend:
   ```bash
   cd backend
   composer install
   cd ..
   ```
   [Si el proyecto usa `antlr4/antlr4-php-runtime`, asegurarse de que esté en `composer.json` y ejecutar `composer update` si es necesario.]

### 1.3 Puesta en marcha del servidor

El proyecto se ejecuta con el servidor de desarrollo integrado de PHP. **Debe iniciarse desde la raíz del proyecto** (carpeta `golampi-interpreter`), no desde `frontend` ni `backend`.

1. Abrir una terminal.
2. Ir a la raíz del proyecto:
   ```bash
   cd /ruta/completa/golampi-interpreter
   ```
3. Iniciar el servidor:
   ```bash
   php -S 0.0.0.0:8000
   ```
4. Debe aparecer un mensaje similar a:
   ```text
   PHP 8.x Development Server (http://0.0.0.0:8000) started
   ```
5. Dejar esta terminal abierta mientras se use la aplicación.

### 1.4 Acceso desde el navegador

- **Interfaz principal:**  
  [http://localhost:8000/frontend/index.html](http://localhost:8000/frontend/index.html)

- Si se usa otro puerto o equipo, sustituir `localhost` y el puerto según corresponda (por ejemplo, `http://192.168.1.10:8000/frontend/index.html`).

---

## 2. Descripción de la interfaz gráfica

La interfaz está dividida en: **barra de acciones**, **panel de edición**, **consola de salida** y **panel de reportes**.

### 2.1 Barra de acciones

| Botón / Control | Función |
|-----------------|--------|
| **Nuevo** | Borra el contenido del editor y de la consola para empezar desde cero. |
| **Limpiar** | Borra solo el contenido del editor; la consola no se modifica. |
| **Cargar archivo** | Abre un cuadro para elegir un archivo (`.golampi`, `.go`, `.txt`) y carga su contenido en el editor. |
| **Guardar código** | Descarga el contenido actual del editor como archivo `programa.golampi`. |
| **Ejecutar / Analizar** | Envía el código al servidor, ejecuta el análisis (léxico, sintáctico, semántico) y, si no hay errores, ejecuta el programa. La salida y los errores se muestran en la consola. |
| **Limpiar consola** | Borra solo el contenido del área de consola. |

### 2.2 Panel de edición de código

- Área de texto central donde se escribe o pega el programa en lenguaje Golampi.
- Soporta varias líneas y refleja exactamente lo que se enviará al intérprete.
- No realiza validaciones en tiempo real; las validaciones se hacen al pulsar **Ejecutar / Analizar**.

### 2.3 Consola de salida

- Muestra la **salida estándar** del programa (por ejemplo, lo impreso con `fmt.Println`).
- Si hay **errores** (léxicos, sintácticos o semánticos), se muestran en formato **tabla** con columnas: **#**, **Tipo**, **Descripción**, **Línea**, **Columna**.
- Si ocurre un error de conexión con el servidor, se muestra un mensaje indicando revisar que el servidor esté en marcha y la URL de la API.
- El texto de error se muestra en color rojo; la salida normal en verde [o según estilos definidos en la aplicación].

### 2.4 Panel de reportes

Zona de descarga de archivos generados tras una ejecución/análisis:

| Botón | Archivo generado | Contenido |
|-------|------------------|-----------|
| **Descargar resultado** | `resultado.txt` | Reporte de análisis y/o salida mostrada en consola. |
| **Descargar errores** | `errores.html` o `errores.txt` | Si hay errores: tabla en HTML (abrible en el navegador). Si no hay errores: archivo de texto indicando que no hay errores. |
| **Descargar tabla de símbolos** | `tabla_simbolos.txt` | Tabla con identificadores, tipo, ámbito, valor (si aplica), línea y columna. |

Al pie del panel se muestra la **URL de la API** que usa la interfaz (por defecto, `http://localhost:8000/backend/api.php`). [Completar si en tu versión se muestra otra información.]

---

## 3. Crear, editar y ejecutar código en Golampi

### 3.1 Programa mínimo

Todo programa debe tener exactamente una función `main()` sin parámetros ni valor de retorno. Ejemplo:

```go
func main() {
    fmt.Println("Hola, Golampi")
}
```

1. Escribir o pegar el código en el editor.
2. Pulsar **Ejecutar / Analizar**.
3. En la consola debe aparecer: `Hola, Golampi`.

### 3.2 Variables y declaración corta

```go
func main() {
    x := 10
    var y int32 = 20
    fmt.Println(x, y)
}
```

- `:=` declara e inicializa (solo dentro de bloques; al menos una variable debe ser nueva).
- `var nombre tipo = valor` declara con tipo explícito.

### 3.3 Condicionales y bucles

```go
func main() {
    a := 5
    if a > 0 {
        fmt.Println("positivo")
    } else {
        fmt.Println("no positivo")
    }
    for i := 0; i < 3; i++ {
        fmt.Println(i)
    }
}
```

- La condición de `if` y `for` debe ser de tipo `bool`.
- No se permiten paréntesis alrededor de la condición del `if`.

### 3.4 Funciones con múltiples retornos

```go
func dividir(a int32, b int32) (int32, bool) {
    if b == 0 {
        return 0, false
    }
    return a / b, true
}
func main() {
    x, ok := dividir(10, 2)
    if ok {
        fmt.Println(x)
    }
}
```

- El número de variables a la izquierda de `:=` debe coincidir con el número de valores retornados por la función.

### 3.5 Arreglos

```go
func main() {
    var arr [3]int32 = [3]int32{1, 2, 3}
    fmt.Println(arr[0])
    arr[1] = 10
}
```

- El índice debe ser de tipo `int32` y estar dentro del rango del arreglo (de lo contrario se reporta error).

### 3.6 Funciones embebidas

- **fmt.Println:** imprime uno o más valores separados por espacios y un salto de línea.
- **len:** longitud de un string o de un arreglo.
- **now:** fecha y hora actual en formato cadena.
- **substr(s, inicio, longitud):** subcadena.
- **typeOf(variable):** tipo de la variable en formato string.

[Incluir ejemplos concretos si se desea ampliar esta sección.]

---

## 4. Interpretación de los reportes generados

### 4.1 Reporte de errores (tabla)

El reporte de errores se presenta como **tabla** con las siguientes columnas:

| Columna | Significado |
|---------|-------------|
| **#** | Número de orden del error (1, 2, 3, …). |
| **Tipo** | Clasificación: Léxico, Sintáctico, Semántico o Ejecución. |
| **Descripción** | Mensaje explicativo del error (por ejemplo, "Variable 'x' no declarada", "Índice fuera de rango para array de tamaño 3"). |
| **Línea** | Número de línea en el código fuente (habitualmente basado en 1). |
| **Columna** | Posición en la línea (habitualmente basada en 0). |

**Ejemplo (interpretación):**

| # | Tipo     | Descripción                          | Línea | Columna |
|---|----------|--------------------------------------|-------|---------|
| 1 | Semántico| La cantidad de variables en la asignación no coincide con la cantidad de valores retornados. | 6 | 1 |

Indica que en la línea 6 hay una asignación donde el número de variables a la izquierda no coincide con el número de valores que devuelve la expresión de la derecha (por ejemplo, una función que retorna dos valores asignada a una sola variable).

### 4.2 Reporte de tabla de símbolos

Columnas típicas:

| Columna        | Significado |
|----------------|-------------|
| **Identificador** | Nombre del símbolo (función, variable, constante). |
| **Tipo**       | Tipo del símbolo (int32, float32, bool, string, array, puntero, etc.). |
| **Ámbito**     | Dónde está definido (global, función, bloque). |
| **Valor**      | Valor final si aplica; en muchos casos se muestra "—". |
| **Línea**      | Línea de definición. |
| **Columna**    | Columna de definición. |

Este reporte refleja el estado de la tabla de símbolos tras el análisis semántico (y opcionalmente la ejecución). [Completar con un ejemplo real de salida de tu versión si lo tienes.]

---

## 5. Posibles mensajes de error y su significado

A continuación se listan mensajes típicos y cómo interpretarlos. [Completar o ajustar según los mensajes reales que genere tu implementación.]

| Mensaje (ejemplo) | Causa probable | Qué hacer |
|-------------------|----------------|-----------|
| Símbolo no reconocido | Carácter no válido en el lenguaje (p. ej. `@`, `#`). | Revisar la línea indicada y eliminar o reemplazar el carácter. |
| Se esperaba ';' después de la instrucción | Error sintáctico: falta un `;` o hay una construcción incorrecta. | Revisar la sintaxis en la línea/columna indicadas. |
| Variable 'x' no declarada en el ámbito actual | Uso de un identificador sin declaración previa en ese scope. | Declarar la variable (con `var` o `:=`) antes de usarla. |
| Identificador 'y' ya ha sido declarado | Redeclaración en el mismo ámbito. | Usar otro nombre o reutilizar la variable existente. |
| La función main no puede ser invocada explícitamente | Llamada a `main()` desde el código. | No llamar a `main`; es el punto de entrada automático. |
| Debe existir exactamente una función main | Cero o más de una función `main`. | Definir una sola función `main()` sin parámetros ni retorno. |
| La cantidad de variables en la asignación no coincide con la cantidad de valores retornados | En `x := f()` o `x, y, z := f()`, el número de variables no coincide con el número de retornos de `f`. | Ajustar el número de variables (p. ej. `x, ok := dividir(10, 2)` si `dividir` retorna 2 valores). |
| Índice fuera de rango para array de tamaño N | Acceso a un índice &lt; 0 o ≥ tamaño del arreglo (validado en análisis o en ejecución). | Asegurarse de que el índice esté dentro de `[0, N-1]`. |
| El índice de array debe ser de tipo int32 | El valor usado como índice no es entero. | Usar una expresión de tipo `int32` como índice. |
| Error de conexión: ... | El navegador no pudo contactar con el backend. | Comprobar que el servidor PHP está corriendo desde la raíz del proyecto y que la URL de la API es correcta (p. ej. `http://localhost:8000/backend/api.php`). |

[Incluir aquí cualquier otro mensaje específico de tu implementación.]

---

## 6. Apagar y volver a encender el servidor

- **Apagar:** En la terminal donde está corriendo el servidor, pulsar **Ctrl + C**.  
  Si no se tiene acceso a esa terminal, localizar el proceso que usa el puerto 8000 (por ejemplo con `lsof -i :8000` o `ss -tlnp | grep 8000`) y finalizarlo con `kill <PID>`.
- **Encender de nuevo:** Desde la raíz del proyecto ejecutar:
  ```bash
  php -S 0.0.0.0:8000
  ```
  y abrir de nuevo [http://localhost:8000/frontend/index.html](http://localhost:8000/frontend/index.html).

---

*Manual generado según lineamientos del Proyecto 1 — Organización de Lenguajes y Compiladores 2.*
