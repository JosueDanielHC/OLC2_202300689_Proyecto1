# Golampi Interpreter

Intérprete para el lenguaje **Golampi**, un lenguaje académico con sintaxis inspirada en Go. Realiza análisis léxico, sintáctico y semántico, ejecuta programas desde la función `main` y genera reportes de errores y tabla de símbolos mediante una interfaz gráfica web.

---

## Tecnologías utilizadas

| Componente | Tecnología |
|------------|------------|
| Backend | PHP 8.x |
| Análisis léxico y sintáctico | ANTLR4 (gramática en `.g4`, código generado para PHP) |
| Frontend | HTML, CSS y JavaScript (sin frameworks) |
| Comunicación | HTTP (cliente-servidor); el frontend envía el código por POST y recibe JSON |
| Dependencias PHP | Composer; runtime ANTLR4 para PHP |

---

## Instalación rápida

1. **Clonar o descargar el repositorio**
   ```bash
   git clone https://github.com/JosueDanielHC/OLC2_202300689_Proyecto1.git
   cd golampi-interpreter
   ```

2. **Instalar dependencias del backend**
   ```bash
   cd backend
   composer install
   cd ..
   ```

3. **Iniciar el servidor** (desde la **raíz** del proyecto)
   ```bash
   php -S 0.0.0.0:8000
   ```

4. **Abrir en el navegador**
   - Interfaz: [http://localhost:8000/frontend/index.html](http://localhost:8000/frontend/index.html)

---

## Uso rápido

1. Escribir o pegar código Golampi en el editor (por ejemplo, un `func main() { fmt.Println("Hola") }`).
2. Pulsar **Ejecutar / Analizar**.
3. Revisar la salida y los errores en la consola; descargar reportes desde el panel de reportes si se desea.

Para instrucciones detalladas, instalación paso a paso e interpretación de reportes, consultar el **Manual de Usuario**.

---

## Documentación

| Documento | Descripción |
|-----------|-------------|
| [Documentación técnica](docs/DOCUMENTACION_TECNICA.md) | Gramática formal, diagramas de clases y flujo, módulos del sistema, arquitectura, estructura de carpetas y evidencia de pruebas. |
| [Manual de usuario](docs/MANUAL_DE_USUARIO.md) | Instalación, descripción de la GUI, creación y ejecución de código, interpretación de reportes y mensajes de error. |

---

## Estructura del proyecto (resumen)

```
golampi-interpreter/
├── backend/          # Lógica del intérprete (PHP, ANTLR, visitores, tabla de símbolos)
├── frontend/         # Interfaz web (HTML/CSS/JS)
├── docs/             # Documentación técnica y manual de usuario
├── tests/            # Casos de prueba
└── Proyecto1.pdf     # Enunciado del proyecto
```

---

## Créditos e información del autor

| Campo | Valor |
|-------|--------|
| **Nombre** | Josue Daniel Herrera Cottom |
| **Carné** | 202300689 |
| **Sección** | [Sección] |
| **Curso** | Organización de Lenguajes y Compiladores 2 |
| **Repositorio** | https://github.com/JosueDanielHC/OLC2_202300689_Proyecto1 |

### Agregar al auxiliar (según enunciado)

- **Sección N:** [AllVides](https://github.com/AllVides)

---

## Licencia

[Indicar licencia si aplica; por ejemplo: uso académico, MIT, etc.]
