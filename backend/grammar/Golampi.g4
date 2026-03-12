grammar Golampi;

/* ======================================================
   PROGRAMA
====================================================== */

program
    : topLevelDecl* EOF
    ;

topLevelDecl
    : varDecl
    | constDecl
    | functionDecl
    ;

/* ======================================================
   TIPOS
====================================================== */

type
    : baseType
    | arrayType
    | pointerType
    ;

baseType
    : 'int32'
    | 'int'         // alias aceptado por ejemplos del enunciado
    | 'float32'
    | 'bool'
    | 'rune'
    | 'string'
    ;

arrayType
    : '[' expression ']' type
    ;

pointerType
    : '*' type
    ;
        

/* ======================================================
   DECLARACIONES
====================================================== */

varDecl
    : 'var' identifierList type ('=' expressionList)?
    ;

shortVarDecl
    : identifierList ':=' expressionList
    ;

constDecl
    : 'const' IDENTIFIER type '=' expression
    ;

identifierList
    : IDENTIFIER (',' IDENTIFIER)*
    ;

expressionList
    : expression (',' expression)* ','?
    ;

/* ======================================================
   FUNCIONES
====================================================== */

functionDecl
    : 'func' IDENTIFIER '(' parameters? ')' returnType? block
    ;

parameters
    : parameter (',' parameter)*
    ;

parameter
    : IDENTIFIER type
    ;

returnType
    : type
    | '(' type (',' type)* ')'
    ;

/* ======================================================
   BLOQUES Y SENTENCIAS
====================================================== */

block
    : '{' statement* '}'
    ;

statement
    : varDecl
    | shortVarDecl
    | constDecl
    | assignment
    | incDecStmt
    | ifStmt
    | switchStmt
    | forStmt
    | breakStmt
    | continueStmt
    | returnStmt
    | expressionStmt
    | block
    ;

/* ======================================================
   ASIGNACIONES E INCREMENTOS
====================================================== */

assignment
    : expression assignOp expression
    ;

expressionStmt
    : expression
    ;

assignOp
    : '='
    | '+='
    | '-='
    | '*='
    | '/='
    ;

incDecStmt
    : expression ('++' | '--')
    ;

/* ======================================================
   IF
   Soporta inicialización opcional tipo Go:
   if x := 5; x > 0 { }
====================================================== */

ifStmt
    : 'if' ( simpleStmt ';' )? expression block
      ( 'else' ( ifStmt | block ) )?
    ;

/* ======================================================
   SWITCH
====================================================== */

switchStmt
    : 'switch' expression '{' caseClause* defaultClause? '}'
    ;

caseClause
    : 'case' expressionList ':' statement*
    ;

defaultClause
    : 'default' ':' statement*
    ;

/* ======================================================
   FOR
====================================================== */

forStmt
    : 'for' forClause block
    | 'for' expression block
    | 'for' block
    ;

forClause
    : ( simpleStmt )? ';' ( expression )? ';' ( simpleStmt )?
    ;

simpleStmt
    : shortVarDecl
    | varDecl
    | assignment
    | incDecStmt
    | expressionStmt
    ;

/* ======================================================
   TRANSFERENCIA
====================================================== */

breakStmt
    : 'break'
    ;

continueStmt
    : 'continue'
    ;

returnStmt
    : 'return' expressionList?
    ;

/* ======================================================
   EXPRESIONES (PRECEDENCIA CORRECTA)
====================================================== */

expression
    : logicalOr
    ;

logicalOr
    : logicalAnd ( '||' logicalAnd )*
    ;

logicalAnd
    : equality ( '&&' equality )*
    ;

equality
    : comparison ( ( '==' | '!=' ) comparison )*
    ;

comparison
    : addition ( ( '>' | '>=' | '<' | '<=' ) addition )*
    ;

addition
    : multiplication ( ( '+' | '-' ) multiplication )*
    ;

multiplication
    : unary ( ( '*' | '/' | '%' ) unary )*
    ;

unary
    : ( '!' | '-' | '*' | '&' ) unary
    | primary
    ;

/* ======================================================
   PRIMARIOS
====================================================== */

primary
    : literal
    | arrayLiteral
    | functionCall
    | qualifiedIdentifier
    | arrayAccess
    | '(' expression ')'
    ;

/* ======================================================
   ARREGLOS
====================================================== */

arrayAccess
    : qualifiedIdentifier ('[' expression ']')+
    ;

arrayLiteral
    : arrayType arrayLiteralBody
    ;

arrayLiteralBody
    : '{' arrayElementList? '}'
    ;

arrayElementList
    : arrayElement (',' arrayElement)* ','?
    ;

arrayElement
    : expression
    | arrayLiteralBody    // permite literales anidados: { {1,2}, {3,4} }
    ;

/* ======================================================
   FUNCIONES Y BUILT-INS
====================================================== */

functionCall
    : qualifiedIdentifier '(' argumentList? ')'
    ;

argumentList
    : expression (',' expression)*
    ;

qualifiedIdentifier
    : IDENTIFIER ('.' IDENTIFIER)*
    ;

/* ======================================================
   LITERALES
====================================================== */

literal
    : INT_LITERAL
    | FLOAT_LITERAL
    | STRING_LITERAL
    | RUNE_LITERAL
    | 'true'
    | 'false'
    | 'nil'
    ;

/* ======================================================
   LÉXICO
====================================================== */

IDENTIFIER
    : [_a-zA-Z] [_a-zA-Z0-9]*
    ;

INT_LITERAL
    : [0-9]+
    ;

FLOAT_LITERAL
    : [0-9]+ '.' [0-9]+ ([eE] [+-]? [0-9]+)?
    ;

STRING_LITERAL
    : '"' ( ~["\\] | '\\' . )* '"'
    ;

RUNE_LITERAL
    : '\'' ( ~['\\] | '\\' . ) '\''
    ;

WS
    : [ \t\r\n]+ -> skip
    ;

LINE_COMMENT
    : '//' ~[\r\n]* -> skip
    ;

BLOCK_COMMENT
    : '/*' .*? '*/' -> skip
    ;