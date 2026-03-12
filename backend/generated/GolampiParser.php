<?php

/*
 * Generated from Golampi.g4 by ANTLR 4.13.1
 */

namespace {
	use Antlr\Antlr4\Runtime\Atn\ATN;
	use Antlr\Antlr4\Runtime\Atn\ATNDeserializer;
	use Antlr\Antlr4\Runtime\Atn\ParserATNSimulator;
	use Antlr\Antlr4\Runtime\Dfa\DFA;
	use Antlr\Antlr4\Runtime\Error\Exceptions\FailedPredicateException;
	use Antlr\Antlr4\Runtime\Error\Exceptions\NoViableAltException;
	use Antlr\Antlr4\Runtime\PredictionContexts\PredictionContextCache;
	use Antlr\Antlr4\Runtime\Error\Exceptions\RecognitionException;
	use Antlr\Antlr4\Runtime\RuleContext;
	use Antlr\Antlr4\Runtime\Token;
	use Antlr\Antlr4\Runtime\TokenStream;
	use Antlr\Antlr4\Runtime\Vocabulary;
	use Antlr\Antlr4\Runtime\VocabularyImpl;
	use Antlr\Antlr4\Runtime\RuntimeMetaData;
	use Antlr\Antlr4\Runtime\Parser;

	final class GolampiParser extends Parser
	{
		public const T__0 = 1, T__1 = 2, T__2 = 3, T__3 = 4, T__4 = 5, T__5 = 6, 
               T__6 = 7, T__7 = 8, T__8 = 9, T__9 = 10, T__10 = 11, T__11 = 12, 
               T__12 = 13, T__13 = 14, T__14 = 15, T__15 = 16, T__16 = 17, 
               T__17 = 18, T__18 = 19, T__19 = 20, T__20 = 21, T__21 = 22, 
               T__22 = 23, T__23 = 24, T__24 = 25, T__25 = 26, T__26 = 27, 
               T__27 = 28, T__28 = 29, T__29 = 30, T__30 = 31, T__31 = 32, 
               T__32 = 33, T__33 = 34, T__34 = 35, T__35 = 36, T__36 = 37, 
               T__37 = 38, T__38 = 39, T__39 = 40, T__40 = 41, T__41 = 42, 
               T__42 = 43, T__43 = 44, T__44 = 45, T__45 = 46, T__46 = 47, 
               T__47 = 48, T__48 = 49, T__49 = 50, T__50 = 51, T__51 = 52, 
               T__52 = 53, T__53 = 54, IDENTIFIER = 55, INT_LITERAL = 56, 
               FLOAT_LITERAL = 57, STRING_LITERAL = 58, RUNE_LITERAL = 59, 
               WS = 60, LINE_COMMENT = 61, BLOCK_COMMENT = 62;

		public const RULE_program = 0, RULE_topLevelDecl = 1, RULE_type = 2, RULE_baseType = 3, 
               RULE_arrayType = 4, RULE_pointerType = 5, RULE_varDecl = 6, 
               RULE_shortVarDecl = 7, RULE_constDecl = 8, RULE_identifierList = 9, 
               RULE_expressionList = 10, RULE_functionDecl = 11, RULE_parameters = 12, 
               RULE_parameter = 13, RULE_returnType = 14, RULE_block = 15, 
               RULE_statement = 16, RULE_assignment = 17, RULE_expressionStmt = 18, 
               RULE_assignOp = 19, RULE_incDecStmt = 20, RULE_ifStmt = 21, 
               RULE_switchStmt = 22, RULE_caseClause = 23, RULE_defaultClause = 24, 
               RULE_forStmt = 25, RULE_forClause = 26, RULE_simpleStmt = 27, 
               RULE_breakStmt = 28, RULE_continueStmt = 29, RULE_returnStmt = 30, 
               RULE_expression = 31, RULE_logicalOr = 32, RULE_logicalAnd = 33, 
               RULE_equality = 34, RULE_comparison = 35, RULE_addition = 36, 
               RULE_multiplication = 37, RULE_unary = 38, RULE_primary = 39, 
               RULE_arrayAccess = 40, RULE_arrayLiteral = 41, RULE_arrayLiteralBody = 42, 
               RULE_arrayElementList = 43, RULE_arrayElement = 44, RULE_functionCall = 45, 
               RULE_argumentList = 46, RULE_qualifiedIdentifier = 47, RULE_literal = 48;

		/**
		 * @var array<string>
		 */
		public const RULE_NAMES = [
			'program', 'topLevelDecl', 'type', 'baseType', 'arrayType', 'pointerType', 
			'varDecl', 'shortVarDecl', 'constDecl', 'identifierList', 'expressionList', 
			'functionDecl', 'parameters', 'parameter', 'returnType', 'block', 'statement', 
			'assignment', 'expressionStmt', 'assignOp', 'incDecStmt', 'ifStmt', 'switchStmt', 
			'caseClause', 'defaultClause', 'forStmt', 'forClause', 'simpleStmt', 
			'breakStmt', 'continueStmt', 'returnStmt', 'expression', 'logicalOr', 
			'logicalAnd', 'equality', 'comparison', 'addition', 'multiplication', 
			'unary', 'primary', 'arrayAccess', 'arrayLiteral', 'arrayLiteralBody', 
			'arrayElementList', 'arrayElement', 'functionCall', 'argumentList', 'qualifiedIdentifier', 
			'literal'
		];

		/**
		 * @var array<string|null>
		 */
		private const LITERAL_NAMES = [
		    null, "'int32'", "'int'", "'float32'", "'bool'", "'rune'", "'string'", 
		    "'['", "']'", "'*'", "'var'", "'='", "':='", "'const'", "','", "'func'", 
		    "'('", "')'", "'{'", "'}'", "'+='", "'-='", "'*='", "'/='", "'++'", 
		    "'--'", "'if'", "';'", "'else'", "'switch'", "'case'", "':'", "'default'", 
		    "'for'", "'break'", "'continue'", "'return'", "'||'", "'&&'", "'=='", 
		    "'!='", "'>'", "'>='", "'<'", "'<='", "'+'", "'-'", "'/'", "'%'", 
		    "'!'", "'&'", "'.'", "'true'", "'false'", "'nil'"
		];

		/**
		 * @var array<string>
		 */
		private const SYMBOLIC_NAMES = [
		    null, null, null, null, null, null, null, null, null, null, null, 
		    null, null, null, null, null, null, null, null, null, null, null, 
		    null, null, null, null, null, null, null, null, null, null, null, 
		    null, null, null, null, null, null, null, null, null, null, null, 
		    null, null, null, null, null, null, null, null, null, null, null, 
		    "IDENTIFIER", "INT_LITERAL", "FLOAT_LITERAL", "STRING_LITERAL", "RUNE_LITERAL", 
		    "WS", "LINE_COMMENT", "BLOCK_COMMENT"
		];

		private const SERIALIZED_ATN =
			[4, 1, 62, 443, 2, 0, 7, 0, 2, 1, 7, 1, 2, 2, 7, 2, 2, 3, 7, 3, 2, 4, 
		    7, 4, 2, 5, 7, 5, 2, 6, 7, 6, 2, 7, 7, 7, 2, 8, 7, 8, 2, 9, 7, 9, 
		    2, 10, 7, 10, 2, 11, 7, 11, 2, 12, 7, 12, 2, 13, 7, 13, 2, 14, 7, 
		    14, 2, 15, 7, 15, 2, 16, 7, 16, 2, 17, 7, 17, 2, 18, 7, 18, 2, 19, 
		    7, 19, 2, 20, 7, 20, 2, 21, 7, 21, 2, 22, 7, 22, 2, 23, 7, 23, 2, 
		    24, 7, 24, 2, 25, 7, 25, 2, 26, 7, 26, 2, 27, 7, 27, 2, 28, 7, 28, 
		    2, 29, 7, 29, 2, 30, 7, 30, 2, 31, 7, 31, 2, 32, 7, 32, 2, 33, 7, 
		    33, 2, 34, 7, 34, 2, 35, 7, 35, 2, 36, 7, 36, 2, 37, 7, 37, 2, 38, 
		    7, 38, 2, 39, 7, 39, 2, 40, 7, 40, 2, 41, 7, 41, 2, 42, 7, 42, 2, 
		    43, 7, 43, 2, 44, 7, 44, 2, 45, 7, 45, 2, 46, 7, 46, 2, 47, 7, 47, 
		    2, 48, 7, 48, 1, 0, 5, 0, 100, 8, 0, 10, 0, 12, 0, 103, 9, 0, 1, 0, 
		    1, 0, 1, 1, 1, 1, 1, 1, 3, 1, 110, 8, 1, 1, 2, 1, 2, 1, 2, 3, 2, 115, 
		    8, 2, 1, 3, 1, 3, 1, 4, 1, 4, 1, 4, 1, 4, 1, 4, 1, 5, 1, 5, 1, 5, 
		    1, 6, 1, 6, 1, 6, 1, 6, 1, 6, 3, 6, 132, 8, 6, 1, 7, 1, 7, 1, 7, 1, 
		    7, 1, 8, 1, 8, 1, 8, 1, 8, 1, 8, 1, 8, 1, 9, 1, 9, 1, 9, 5, 9, 147, 
		    8, 9, 10, 9, 12, 9, 150, 9, 9, 1, 10, 1, 10, 1, 10, 5, 10, 155, 8, 
		    10, 10, 10, 12, 10, 158, 9, 10, 1, 10, 3, 10, 161, 8, 10, 1, 11, 1, 
		    11, 1, 11, 1, 11, 3, 11, 167, 8, 11, 1, 11, 1, 11, 3, 11, 171, 8, 
		    11, 1, 11, 1, 11, 1, 12, 1, 12, 1, 12, 5, 12, 178, 8, 12, 10, 12, 
		    12, 12, 181, 9, 12, 1, 13, 1, 13, 1, 13, 1, 14, 1, 14, 1, 14, 1, 14, 
		    1, 14, 5, 14, 191, 8, 14, 10, 14, 12, 14, 194, 9, 14, 1, 14, 1, 14, 
		    3, 14, 198, 8, 14, 1, 15, 1, 15, 5, 15, 202, 8, 15, 10, 15, 12, 15, 
		    205, 9, 15, 1, 15, 1, 15, 1, 16, 1, 16, 1, 16, 1, 16, 1, 16, 1, 16, 
		    1, 16, 1, 16, 1, 16, 1, 16, 1, 16, 1, 16, 1, 16, 3, 16, 222, 8, 16, 
		    1, 17, 1, 17, 1, 17, 1, 17, 1, 18, 1, 18, 1, 19, 1, 19, 1, 20, 1, 
		    20, 1, 20, 1, 21, 1, 21, 1, 21, 1, 21, 3, 21, 239, 8, 21, 1, 21, 1, 
		    21, 1, 21, 1, 21, 1, 21, 3, 21, 246, 8, 21, 3, 21, 248, 8, 21, 1, 
		    22, 1, 22, 1, 22, 1, 22, 5, 22, 254, 8, 22, 10, 22, 12, 22, 257, 9, 
		    22, 1, 22, 3, 22, 260, 8, 22, 1, 22, 1, 22, 1, 23, 1, 23, 1, 23, 1, 
		    23, 5, 23, 268, 8, 23, 10, 23, 12, 23, 271, 9, 23, 1, 24, 1, 24, 1, 
		    24, 5, 24, 276, 8, 24, 10, 24, 12, 24, 279, 9, 24, 1, 25, 1, 25, 1, 
		    25, 1, 25, 1, 25, 1, 25, 1, 25, 1, 25, 1, 25, 1, 25, 3, 25, 291, 8, 
		    25, 1, 26, 3, 26, 294, 8, 26, 1, 26, 1, 26, 3, 26, 298, 8, 26, 1, 
		    26, 1, 26, 3, 26, 302, 8, 26, 1, 27, 1, 27, 1, 27, 1, 27, 1, 27, 3, 
		    27, 309, 8, 27, 1, 28, 1, 28, 1, 29, 1, 29, 1, 30, 1, 30, 3, 30, 317, 
		    8, 30, 1, 31, 1, 31, 1, 32, 1, 32, 1, 32, 5, 32, 324, 8, 32, 10, 32, 
		    12, 32, 327, 9, 32, 1, 33, 1, 33, 1, 33, 5, 33, 332, 8, 33, 10, 33, 
		    12, 33, 335, 9, 33, 1, 34, 1, 34, 1, 34, 5, 34, 340, 8, 34, 10, 34, 
		    12, 34, 343, 9, 34, 1, 35, 1, 35, 1, 35, 5, 35, 348, 8, 35, 10, 35, 
		    12, 35, 351, 9, 35, 1, 36, 1, 36, 1, 36, 5, 36, 356, 8, 36, 10, 36, 
		    12, 36, 359, 9, 36, 1, 37, 1, 37, 1, 37, 5, 37, 364, 8, 37, 10, 37, 
		    12, 37, 367, 9, 37, 1, 38, 1, 38, 1, 38, 3, 38, 372, 8, 38, 1, 39, 
		    1, 39, 1, 39, 1, 39, 1, 39, 1, 39, 1, 39, 1, 39, 1, 39, 3, 39, 383, 
		    8, 39, 1, 40, 1, 40, 1, 40, 1, 40, 1, 40, 4, 40, 390, 8, 40, 11, 40, 
		    12, 40, 391, 1, 41, 1, 41, 1, 41, 1, 42, 1, 42, 3, 42, 399, 8, 42, 
		    1, 42, 1, 42, 1, 43, 1, 43, 1, 43, 5, 43, 406, 8, 43, 10, 43, 12, 
		    43, 409, 9, 43, 1, 43, 3, 43, 412, 8, 43, 1, 44, 1, 44, 3, 44, 416, 
		    8, 44, 1, 45, 1, 45, 1, 45, 3, 45, 421, 8, 45, 1, 45, 1, 45, 1, 46, 
		    1, 46, 1, 46, 5, 46, 428, 8, 46, 10, 46, 12, 46, 431, 9, 46, 1, 47, 
		    1, 47, 1, 47, 5, 47, 436, 8, 47, 10, 47, 12, 47, 439, 9, 47, 1, 48, 
		    1, 48, 1, 48, 0, 0, 49, 0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 
		    24, 26, 28, 30, 32, 34, 36, 38, 40, 42, 44, 46, 48, 50, 52, 54, 56, 
		    58, 60, 62, 64, 66, 68, 70, 72, 74, 76, 78, 80, 82, 84, 86, 88, 90, 
		    92, 94, 96, 0, 9, 1, 0, 1, 6, 2, 0, 11, 11, 20, 23, 1, 0, 24, 25, 
		    1, 0, 39, 40, 1, 0, 41, 44, 1, 0, 45, 46, 2, 0, 9, 9, 47, 48, 3, 0, 
		    9, 9, 46, 46, 49, 50, 2, 0, 52, 54, 56, 59, 457, 0, 101, 1, 0, 0, 
		    0, 2, 109, 1, 0, 0, 0, 4, 114, 1, 0, 0, 0, 6, 116, 1, 0, 0, 0, 8, 
		    118, 1, 0, 0, 0, 10, 123, 1, 0, 0, 0, 12, 126, 1, 0, 0, 0, 14, 133, 
		    1, 0, 0, 0, 16, 137, 1, 0, 0, 0, 18, 143, 1, 0, 0, 0, 20, 151, 1, 
		    0, 0, 0, 22, 162, 1, 0, 0, 0, 24, 174, 1, 0, 0, 0, 26, 182, 1, 0, 
		    0, 0, 28, 197, 1, 0, 0, 0, 30, 199, 1, 0, 0, 0, 32, 221, 1, 0, 0, 
		    0, 34, 223, 1, 0, 0, 0, 36, 227, 1, 0, 0, 0, 38, 229, 1, 0, 0, 0, 
		    40, 231, 1, 0, 0, 0, 42, 234, 1, 0, 0, 0, 44, 249, 1, 0, 0, 0, 46, 
		    263, 1, 0, 0, 0, 48, 272, 1, 0, 0, 0, 50, 290, 1, 0, 0, 0, 52, 293, 
		    1, 0, 0, 0, 54, 308, 1, 0, 0, 0, 56, 310, 1, 0, 0, 0, 58, 312, 1, 
		    0, 0, 0, 60, 314, 1, 0, 0, 0, 62, 318, 1, 0, 0, 0, 64, 320, 1, 0, 
		    0, 0, 66, 328, 1, 0, 0, 0, 68, 336, 1, 0, 0, 0, 70, 344, 1, 0, 0, 
		    0, 72, 352, 1, 0, 0, 0, 74, 360, 1, 0, 0, 0, 76, 371, 1, 0, 0, 0, 
		    78, 382, 1, 0, 0, 0, 80, 384, 1, 0, 0, 0, 82, 393, 1, 0, 0, 0, 84, 
		    396, 1, 0, 0, 0, 86, 402, 1, 0, 0, 0, 88, 415, 1, 0, 0, 0, 90, 417, 
		    1, 0, 0, 0, 92, 424, 1, 0, 0, 0, 94, 432, 1, 0, 0, 0, 96, 440, 1, 
		    0, 0, 0, 98, 100, 3, 2, 1, 0, 99, 98, 1, 0, 0, 0, 100, 103, 1, 0, 
		    0, 0, 101, 99, 1, 0, 0, 0, 101, 102, 1, 0, 0, 0, 102, 104, 1, 0, 0, 
		    0, 103, 101, 1, 0, 0, 0, 104, 105, 5, 0, 0, 1, 105, 1, 1, 0, 0, 0, 
		    106, 110, 3, 12, 6, 0, 107, 110, 3, 16, 8, 0, 108, 110, 3, 22, 11, 
		    0, 109, 106, 1, 0, 0, 0, 109, 107, 1, 0, 0, 0, 109, 108, 1, 0, 0, 
		    0, 110, 3, 1, 0, 0, 0, 111, 115, 3, 6, 3, 0, 112, 115, 3, 8, 4, 0, 
		    113, 115, 3, 10, 5, 0, 114, 111, 1, 0, 0, 0, 114, 112, 1, 0, 0, 0, 
		    114, 113, 1, 0, 0, 0, 115, 5, 1, 0, 0, 0, 116, 117, 7, 0, 0, 0, 117, 
		    7, 1, 0, 0, 0, 118, 119, 5, 7, 0, 0, 119, 120, 3, 62, 31, 0, 120, 
		    121, 5, 8, 0, 0, 121, 122, 3, 4, 2, 0, 122, 9, 1, 0, 0, 0, 123, 124, 
		    5, 9, 0, 0, 124, 125, 3, 4, 2, 0, 125, 11, 1, 0, 0, 0, 126, 127, 5, 
		    10, 0, 0, 127, 128, 3, 18, 9, 0, 128, 131, 3, 4, 2, 0, 129, 130, 5, 
		    11, 0, 0, 130, 132, 3, 20, 10, 0, 131, 129, 1, 0, 0, 0, 131, 132, 
		    1, 0, 0, 0, 132, 13, 1, 0, 0, 0, 133, 134, 3, 18, 9, 0, 134, 135, 
		    5, 12, 0, 0, 135, 136, 3, 20, 10, 0, 136, 15, 1, 0, 0, 0, 137, 138, 
		    5, 13, 0, 0, 138, 139, 5, 55, 0, 0, 139, 140, 3, 4, 2, 0, 140, 141, 
		    5, 11, 0, 0, 141, 142, 3, 62, 31, 0, 142, 17, 1, 0, 0, 0, 143, 148, 
		    5, 55, 0, 0, 144, 145, 5, 14, 0, 0, 145, 147, 5, 55, 0, 0, 146, 144, 
		    1, 0, 0, 0, 147, 150, 1, 0, 0, 0, 148, 146, 1, 0, 0, 0, 148, 149, 
		    1, 0, 0, 0, 149, 19, 1, 0, 0, 0, 150, 148, 1, 0, 0, 0, 151, 156, 3, 
		    62, 31, 0, 152, 153, 5, 14, 0, 0, 153, 155, 3, 62, 31, 0, 154, 152, 
		    1, 0, 0, 0, 155, 158, 1, 0, 0, 0, 156, 154, 1, 0, 0, 0, 156, 157, 
		    1, 0, 0, 0, 157, 160, 1, 0, 0, 0, 158, 156, 1, 0, 0, 0, 159, 161, 
		    5, 14, 0, 0, 160, 159, 1, 0, 0, 0, 160, 161, 1, 0, 0, 0, 161, 21, 
		    1, 0, 0, 0, 162, 163, 5, 15, 0, 0, 163, 164, 5, 55, 0, 0, 164, 166, 
		    5, 16, 0, 0, 165, 167, 3, 24, 12, 0, 166, 165, 1, 0, 0, 0, 166, 167, 
		    1, 0, 0, 0, 167, 168, 1, 0, 0, 0, 168, 170, 5, 17, 0, 0, 169, 171, 
		    3, 28, 14, 0, 170, 169, 1, 0, 0, 0, 170, 171, 1, 0, 0, 0, 171, 172, 
		    1, 0, 0, 0, 172, 173, 3, 30, 15, 0, 173, 23, 1, 0, 0, 0, 174, 179, 
		    3, 26, 13, 0, 175, 176, 5, 14, 0, 0, 176, 178, 3, 26, 13, 0, 177, 
		    175, 1, 0, 0, 0, 178, 181, 1, 0, 0, 0, 179, 177, 1, 0, 0, 0, 179, 
		    180, 1, 0, 0, 0, 180, 25, 1, 0, 0, 0, 181, 179, 1, 0, 0, 0, 182, 183, 
		    5, 55, 0, 0, 183, 184, 3, 4, 2, 0, 184, 27, 1, 0, 0, 0, 185, 198, 
		    3, 4, 2, 0, 186, 187, 5, 16, 0, 0, 187, 192, 3, 4, 2, 0, 188, 189, 
		    5, 14, 0, 0, 189, 191, 3, 4, 2, 0, 190, 188, 1, 0, 0, 0, 191, 194, 
		    1, 0, 0, 0, 192, 190, 1, 0, 0, 0, 192, 193, 1, 0, 0, 0, 193, 195, 
		    1, 0, 0, 0, 194, 192, 1, 0, 0, 0, 195, 196, 5, 17, 0, 0, 196, 198, 
		    1, 0, 0, 0, 197, 185, 1, 0, 0, 0, 197, 186, 1, 0, 0, 0, 198, 29, 1, 
		    0, 0, 0, 199, 203, 5, 18, 0, 0, 200, 202, 3, 32, 16, 0, 201, 200, 
		    1, 0, 0, 0, 202, 205, 1, 0, 0, 0, 203, 201, 1, 0, 0, 0, 203, 204, 
		    1, 0, 0, 0, 204, 206, 1, 0, 0, 0, 205, 203, 1, 0, 0, 0, 206, 207, 
		    5, 19, 0, 0, 207, 31, 1, 0, 0, 0, 208, 222, 3, 12, 6, 0, 209, 222, 
		    3, 14, 7, 0, 210, 222, 3, 16, 8, 0, 211, 222, 3, 34, 17, 0, 212, 222, 
		    3, 40, 20, 0, 213, 222, 3, 42, 21, 0, 214, 222, 3, 44, 22, 0, 215, 
		    222, 3, 50, 25, 0, 216, 222, 3, 56, 28, 0, 217, 222, 3, 58, 29, 0, 
		    218, 222, 3, 60, 30, 0, 219, 222, 3, 36, 18, 0, 220, 222, 3, 30, 15, 
		    0, 221, 208, 1, 0, 0, 0, 221, 209, 1, 0, 0, 0, 221, 210, 1, 0, 0, 
		    0, 221, 211, 1, 0, 0, 0, 221, 212, 1, 0, 0, 0, 221, 213, 1, 0, 0, 
		    0, 221, 214, 1, 0, 0, 0, 221, 215, 1, 0, 0, 0, 221, 216, 1, 0, 0, 
		    0, 221, 217, 1, 0, 0, 0, 221, 218, 1, 0, 0, 0, 221, 219, 1, 0, 0, 
		    0, 221, 220, 1, 0, 0, 0, 222, 33, 1, 0, 0, 0, 223, 224, 3, 62, 31, 
		    0, 224, 225, 3, 38, 19, 0, 225, 226, 3, 62, 31, 0, 226, 35, 1, 0, 
		    0, 0, 227, 228, 3, 62, 31, 0, 228, 37, 1, 0, 0, 0, 229, 230, 7, 1, 
		    0, 0, 230, 39, 1, 0, 0, 0, 231, 232, 3, 62, 31, 0, 232, 233, 7, 2, 
		    0, 0, 233, 41, 1, 0, 0, 0, 234, 238, 5, 26, 0, 0, 235, 236, 3, 54, 
		    27, 0, 236, 237, 5, 27, 0, 0, 237, 239, 1, 0, 0, 0, 238, 235, 1, 0, 
		    0, 0, 238, 239, 1, 0, 0, 0, 239, 240, 1, 0, 0, 0, 240, 241, 3, 62, 
		    31, 0, 241, 247, 3, 30, 15, 0, 242, 245, 5, 28, 0, 0, 243, 246, 3, 
		    42, 21, 0, 244, 246, 3, 30, 15, 0, 245, 243, 1, 0, 0, 0, 245, 244, 
		    1, 0, 0, 0, 246, 248, 1, 0, 0, 0, 247, 242, 1, 0, 0, 0, 247, 248, 
		    1, 0, 0, 0, 248, 43, 1, 0, 0, 0, 249, 250, 5, 29, 0, 0, 250, 251, 
		    3, 62, 31, 0, 251, 255, 5, 18, 0, 0, 252, 254, 3, 46, 23, 0, 253, 
		    252, 1, 0, 0, 0, 254, 257, 1, 0, 0, 0, 255, 253, 1, 0, 0, 0, 255, 
		    256, 1, 0, 0, 0, 256, 259, 1, 0, 0, 0, 257, 255, 1, 0, 0, 0, 258, 
		    260, 3, 48, 24, 0, 259, 258, 1, 0, 0, 0, 259, 260, 1, 0, 0, 0, 260, 
		    261, 1, 0, 0, 0, 261, 262, 5, 19, 0, 0, 262, 45, 1, 0, 0, 0, 263, 
		    264, 5, 30, 0, 0, 264, 265, 3, 20, 10, 0, 265, 269, 5, 31, 0, 0, 266, 
		    268, 3, 32, 16, 0, 267, 266, 1, 0, 0, 0, 268, 271, 1, 0, 0, 0, 269, 
		    267, 1, 0, 0, 0, 269, 270, 1, 0, 0, 0, 270, 47, 1, 0, 0, 0, 271, 269, 
		    1, 0, 0, 0, 272, 273, 5, 32, 0, 0, 273, 277, 5, 31, 0, 0, 274, 276, 
		    3, 32, 16, 0, 275, 274, 1, 0, 0, 0, 276, 279, 1, 0, 0, 0, 277, 275, 
		    1, 0, 0, 0, 277, 278, 1, 0, 0, 0, 278, 49, 1, 0, 0, 0, 279, 277, 1, 
		    0, 0, 0, 280, 281, 5, 33, 0, 0, 281, 282, 3, 52, 26, 0, 282, 283, 
		    3, 30, 15, 0, 283, 291, 1, 0, 0, 0, 284, 285, 5, 33, 0, 0, 285, 286, 
		    3, 62, 31, 0, 286, 287, 3, 30, 15, 0, 287, 291, 1, 0, 0, 0, 288, 289, 
		    5, 33, 0, 0, 289, 291, 3, 30, 15, 0, 290, 280, 1, 0, 0, 0, 290, 284, 
		    1, 0, 0, 0, 290, 288, 1, 0, 0, 0, 291, 51, 1, 0, 0, 0, 292, 294, 3, 
		    54, 27, 0, 293, 292, 1, 0, 0, 0, 293, 294, 1, 0, 0, 0, 294, 295, 1, 
		    0, 0, 0, 295, 297, 5, 27, 0, 0, 296, 298, 3, 62, 31, 0, 297, 296, 
		    1, 0, 0, 0, 297, 298, 1, 0, 0, 0, 298, 299, 1, 0, 0, 0, 299, 301, 
		    5, 27, 0, 0, 300, 302, 3, 54, 27, 0, 301, 300, 1, 0, 0, 0, 301, 302, 
		    1, 0, 0, 0, 302, 53, 1, 0, 0, 0, 303, 309, 3, 14, 7, 0, 304, 309, 
		    3, 12, 6, 0, 305, 309, 3, 34, 17, 0, 306, 309, 3, 40, 20, 0, 307, 
		    309, 3, 36, 18, 0, 308, 303, 1, 0, 0, 0, 308, 304, 1, 0, 0, 0, 308, 
		    305, 1, 0, 0, 0, 308, 306, 1, 0, 0, 0, 308, 307, 1, 0, 0, 0, 309, 
		    55, 1, 0, 0, 0, 310, 311, 5, 34, 0, 0, 311, 57, 1, 0, 0, 0, 312, 313, 
		    5, 35, 0, 0, 313, 59, 1, 0, 0, 0, 314, 316, 5, 36, 0, 0, 315, 317, 
		    3, 20, 10, 0, 316, 315, 1, 0, 0, 0, 316, 317, 1, 0, 0, 0, 317, 61, 
		    1, 0, 0, 0, 318, 319, 3, 64, 32, 0, 319, 63, 1, 0, 0, 0, 320, 325, 
		    3, 66, 33, 0, 321, 322, 5, 37, 0, 0, 322, 324, 3, 66, 33, 0, 323, 
		    321, 1, 0, 0, 0, 324, 327, 1, 0, 0, 0, 325, 323, 1, 0, 0, 0, 325, 
		    326, 1, 0, 0, 0, 326, 65, 1, 0, 0, 0, 327, 325, 1, 0, 0, 0, 328, 333, 
		    3, 68, 34, 0, 329, 330, 5, 38, 0, 0, 330, 332, 3, 68, 34, 0, 331, 
		    329, 1, 0, 0, 0, 332, 335, 1, 0, 0, 0, 333, 331, 1, 0, 0, 0, 333, 
		    334, 1, 0, 0, 0, 334, 67, 1, 0, 0, 0, 335, 333, 1, 0, 0, 0, 336, 341, 
		    3, 70, 35, 0, 337, 338, 7, 3, 0, 0, 338, 340, 3, 70, 35, 0, 339, 337, 
		    1, 0, 0, 0, 340, 343, 1, 0, 0, 0, 341, 339, 1, 0, 0, 0, 341, 342, 
		    1, 0, 0, 0, 342, 69, 1, 0, 0, 0, 343, 341, 1, 0, 0, 0, 344, 349, 3, 
		    72, 36, 0, 345, 346, 7, 4, 0, 0, 346, 348, 3, 72, 36, 0, 347, 345, 
		    1, 0, 0, 0, 348, 351, 1, 0, 0, 0, 349, 347, 1, 0, 0, 0, 349, 350, 
		    1, 0, 0, 0, 350, 71, 1, 0, 0, 0, 351, 349, 1, 0, 0, 0, 352, 357, 3, 
		    74, 37, 0, 353, 354, 7, 5, 0, 0, 354, 356, 3, 74, 37, 0, 355, 353, 
		    1, 0, 0, 0, 356, 359, 1, 0, 0, 0, 357, 355, 1, 0, 0, 0, 357, 358, 
		    1, 0, 0, 0, 358, 73, 1, 0, 0, 0, 359, 357, 1, 0, 0, 0, 360, 365, 3, 
		    76, 38, 0, 361, 362, 7, 6, 0, 0, 362, 364, 3, 76, 38, 0, 363, 361, 
		    1, 0, 0, 0, 364, 367, 1, 0, 0, 0, 365, 363, 1, 0, 0, 0, 365, 366, 
		    1, 0, 0, 0, 366, 75, 1, 0, 0, 0, 367, 365, 1, 0, 0, 0, 368, 369, 7, 
		    7, 0, 0, 369, 372, 3, 76, 38, 0, 370, 372, 3, 78, 39, 0, 371, 368, 
		    1, 0, 0, 0, 371, 370, 1, 0, 0, 0, 372, 77, 1, 0, 0, 0, 373, 383, 3, 
		    96, 48, 0, 374, 383, 3, 82, 41, 0, 375, 383, 3, 90, 45, 0, 376, 383, 
		    3, 94, 47, 0, 377, 383, 3, 80, 40, 0, 378, 379, 5, 16, 0, 0, 379, 
		    380, 3, 62, 31, 0, 380, 381, 5, 17, 0, 0, 381, 383, 1, 0, 0, 0, 382, 
		    373, 1, 0, 0, 0, 382, 374, 1, 0, 0, 0, 382, 375, 1, 0, 0, 0, 382, 
		    376, 1, 0, 0, 0, 382, 377, 1, 0, 0, 0, 382, 378, 1, 0, 0, 0, 383, 
		    79, 1, 0, 0, 0, 384, 389, 3, 94, 47, 0, 385, 386, 5, 7, 0, 0, 386, 
		    387, 3, 62, 31, 0, 387, 388, 5, 8, 0, 0, 388, 390, 1, 0, 0, 0, 389, 
		    385, 1, 0, 0, 0, 390, 391, 1, 0, 0, 0, 391, 389, 1, 0, 0, 0, 391, 
		    392, 1, 0, 0, 0, 392, 81, 1, 0, 0, 0, 393, 394, 3, 8, 4, 0, 394, 395, 
		    3, 84, 42, 0, 395, 83, 1, 0, 0, 0, 396, 398, 5, 18, 0, 0, 397, 399, 
		    3, 86, 43, 0, 398, 397, 1, 0, 0, 0, 398, 399, 1, 0, 0, 0, 399, 400, 
		    1, 0, 0, 0, 400, 401, 5, 19, 0, 0, 401, 85, 1, 0, 0, 0, 402, 407, 
		    3, 88, 44, 0, 403, 404, 5, 14, 0, 0, 404, 406, 3, 88, 44, 0, 405, 
		    403, 1, 0, 0, 0, 406, 409, 1, 0, 0, 0, 407, 405, 1, 0, 0, 0, 407, 
		    408, 1, 0, 0, 0, 408, 411, 1, 0, 0, 0, 409, 407, 1, 0, 0, 0, 410, 
		    412, 5, 14, 0, 0, 411, 410, 1, 0, 0, 0, 411, 412, 1, 0, 0, 0, 412, 
		    87, 1, 0, 0, 0, 413, 416, 3, 62, 31, 0, 414, 416, 3, 84, 42, 0, 415, 
		    413, 1, 0, 0, 0, 415, 414, 1, 0, 0, 0, 416, 89, 1, 0, 0, 0, 417, 418, 
		    3, 94, 47, 0, 418, 420, 5, 16, 0, 0, 419, 421, 3, 92, 46, 0, 420, 
		    419, 1, 0, 0, 0, 420, 421, 1, 0, 0, 0, 421, 422, 1, 0, 0, 0, 422, 
		    423, 5, 17, 0, 0, 423, 91, 1, 0, 0, 0, 424, 429, 3, 62, 31, 0, 425, 
		    426, 5, 14, 0, 0, 426, 428, 3, 62, 31, 0, 427, 425, 1, 0, 0, 0, 428, 
		    431, 1, 0, 0, 0, 429, 427, 1, 0, 0, 0, 429, 430, 1, 0, 0, 0, 430, 
		    93, 1, 0, 0, 0, 431, 429, 1, 0, 0, 0, 432, 437, 5, 55, 0, 0, 433, 
		    434, 5, 51, 0, 0, 434, 436, 5, 55, 0, 0, 435, 433, 1, 0, 0, 0, 436, 
		    439, 1, 0, 0, 0, 437, 435, 1, 0, 0, 0, 437, 438, 1, 0, 0, 0, 438, 
		    95, 1, 0, 0, 0, 439, 437, 1, 0, 0, 0, 440, 441, 7, 8, 0, 0, 441, 97, 
		    1, 0, 0, 0, 43, 101, 109, 114, 131, 148, 156, 160, 166, 170, 179, 
		    192, 197, 203, 221, 238, 245, 247, 255, 259, 269, 277, 290, 293, 297, 
		    301, 308, 316, 325, 333, 341, 349, 357, 365, 371, 382, 391, 398, 407, 
		    411, 415, 420, 429, 437];
		protected static $atn;
		protected static $decisionToDFA;
		protected static $sharedContextCache;

		public function __construct(TokenStream $input)
		{
			parent::__construct($input);

			self::initialize();

			$this->interp = new ParserATNSimulator($this, self::$atn, self::$decisionToDFA, self::$sharedContextCache);
		}

		private static function initialize(): void
		{
			if (self::$atn !== null) {
				return;
			}

			RuntimeMetaData::checkVersion('4.13.1', RuntimeMetaData::VERSION);

			$atn = (new ATNDeserializer())->deserialize(self::SERIALIZED_ATN);

			$decisionToDFA = [];
			for ($i = 0, $count = $atn->getNumberOfDecisions(); $i < $count; $i++) {
				$decisionToDFA[] = new DFA($atn->getDecisionState($i), $i);
			}

			self::$atn = $atn;
			self::$decisionToDFA = $decisionToDFA;
			self::$sharedContextCache = new PredictionContextCache();
		}

		public function getGrammarFileName(): string
		{
			return "Golampi.g4";
		}

		public function getRuleNames(): array
		{
			return self::RULE_NAMES;
		}

		public function getSerializedATN(): array
		{
			return self::SERIALIZED_ATN;
		}

		public function getATN(): ATN
		{
			return self::$atn;
		}

		public function getVocabulary(): Vocabulary
        {
            static $vocabulary;

			return $vocabulary = $vocabulary ?? new VocabularyImpl(self::LITERAL_NAMES, self::SYMBOLIC_NAMES);
        }

		/**
		 * @throws RecognitionException
		 */
		public function program(): Context\ProgramContext
		{
		    $localContext = new Context\ProgramContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 0, self::RULE_program);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(101);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 41984) !== 0)) {
		        	$this->setState(98);
		        	$this->topLevelDecl();
		        	$this->setState(103);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		        $this->setState(104);
		        $this->match(self::EOF);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function topLevelDecl(): Context\TopLevelDeclContext
		{
		    $localContext = new Context\TopLevelDeclContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 2, self::RULE_topLevelDecl);

		    try {
		        $this->setState(109);
		        $this->errorHandler->sync($this);

		        switch ($this->input->LA(1)) {
		            case self::T__9:
		            	$this->enterOuterAlt($localContext, 1);
		            	$this->setState(106);
		            	$this->varDecl();
		            	break;

		            case self::T__12:
		            	$this->enterOuterAlt($localContext, 2);
		            	$this->setState(107);
		            	$this->constDecl();
		            	break;

		            case self::T__14:
		            	$this->enterOuterAlt($localContext, 3);
		            	$this->setState(108);
		            	$this->functionDecl();
		            	break;

		        default:
		        	throw new NoViableAltException($this);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function type(): Context\TypeContext
		{
		    $localContext = new Context\TypeContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 4, self::RULE_type);

		    try {
		        $this->setState(114);
		        $this->errorHandler->sync($this);

		        switch ($this->input->LA(1)) {
		            case self::T__0:
		            case self::T__1:
		            case self::T__2:
		            case self::T__3:
		            case self::T__4:
		            case self::T__5:
		            	$this->enterOuterAlt($localContext, 1);
		            	$this->setState(111);
		            	$this->baseType();
		            	break;

		            case self::T__6:
		            	$this->enterOuterAlt($localContext, 2);
		            	$this->setState(112);
		            	$this->arrayType();
		            	break;

		            case self::T__8:
		            	$this->enterOuterAlt($localContext, 3);
		            	$this->setState(113);
		            	$this->pointerType();
		            	break;

		        default:
		        	throw new NoViableAltException($this);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function baseType(): Context\BaseTypeContext
		{
		    $localContext = new Context\BaseTypeContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 6, self::RULE_baseType);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(116);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 126) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function arrayType(): Context\ArrayTypeContext
		{
		    $localContext = new Context\ArrayTypeContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 8, self::RULE_arrayType);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(118);
		        $this->match(self::T__6);
		        $this->setState(119);
		        $this->expression();
		        $this->setState(120);
		        $this->match(self::T__7);
		        $this->setState(121);
		        $this->type();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function pointerType(): Context\PointerTypeContext
		{
		    $localContext = new Context\PointerTypeContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 10, self::RULE_pointerType);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(123);
		        $this->match(self::T__8);
		        $this->setState(124);
		        $this->type();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function varDecl(): Context\VarDeclContext
		{
		    $localContext = new Context\VarDeclContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 12, self::RULE_varDecl);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(126);
		        $this->match(self::T__9);
		        $this->setState(127);
		        $this->identifierList();
		        $this->setState(128);
		        $this->type();
		        $this->setState(131);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::T__10) {
		        	$this->setState(129);
		        	$this->match(self::T__10);
		        	$this->setState(130);
		        	$this->expressionList();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function shortVarDecl(): Context\ShortVarDeclContext
		{
		    $localContext = new Context\ShortVarDeclContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 14, self::RULE_shortVarDecl);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(133);
		        $this->identifierList();
		        $this->setState(134);
		        $this->match(self::T__11);
		        $this->setState(135);
		        $this->expressionList();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function constDecl(): Context\ConstDeclContext
		{
		    $localContext = new Context\ConstDeclContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 16, self::RULE_constDecl);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(137);
		        $this->match(self::T__12);
		        $this->setState(138);
		        $this->match(self::IDENTIFIER);
		        $this->setState(139);
		        $this->type();
		        $this->setState(140);
		        $this->match(self::T__10);
		        $this->setState(141);
		        $this->expression();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function identifierList(): Context\IdentifierListContext
		{
		    $localContext = new Context\IdentifierListContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 18, self::RULE_identifierList);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(143);
		        $this->match(self::IDENTIFIER);
		        $this->setState(148);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__13) {
		        	$this->setState(144);
		        	$this->match(self::T__13);
		        	$this->setState(145);
		        	$this->match(self::IDENTIFIER);
		        	$this->setState(150);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function expressionList(): Context\ExpressionListContext
		{
		    $localContext = new Context\ExpressionListContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 20, self::RULE_expressionList);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(151);
		        $this->expression();
		        $this->setState(156);
		        $this->errorHandler->sync($this);

		        $alt = $this->getInterpreter()->adaptivePredict($this->input, 5, $this->ctx);

		        while ($alt !== 2 && $alt !== ATN::INVALID_ALT_NUMBER) {
		        	if ($alt === 1) {
		        		$this->setState(152);
		        		$this->match(self::T__13);
		        		$this->setState(153);
		        		$this->expression(); 
		        	}

		        	$this->setState(158);
		        	$this->errorHandler->sync($this);

		        	$alt = $this->getInterpreter()->adaptivePredict($this->input, 5, $this->ctx);
		        }
		        $this->setState(160);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::T__13) {
		        	$this->setState(159);
		        	$this->match(self::T__13);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function functionDecl(): Context\FunctionDeclContext
		{
		    $localContext = new Context\FunctionDeclContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 22, self::RULE_functionDecl);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(162);
		        $this->match(self::T__14);
		        $this->setState(163);
		        $this->match(self::IDENTIFIER);
		        $this->setState(164);
		        $this->match(self::T__15);
		        $this->setState(166);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::IDENTIFIER) {
		        	$this->setState(165);
		        	$this->parameters();
		        }
		        $this->setState(168);
		        $this->match(self::T__16);
		        $this->setState(170);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 66302) !== 0)) {
		        	$this->setState(169);
		        	$this->returnType();
		        }
		        $this->setState(172);
		        $this->block();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function parameters(): Context\ParametersContext
		{
		    $localContext = new Context\ParametersContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 24, self::RULE_parameters);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(174);
		        $this->parameter();
		        $this->setState(179);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__13) {
		        	$this->setState(175);
		        	$this->match(self::T__13);
		        	$this->setState(176);
		        	$this->parameter();
		        	$this->setState(181);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function parameter(): Context\ParameterContext
		{
		    $localContext = new Context\ParameterContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 26, self::RULE_parameter);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(182);
		        $this->match(self::IDENTIFIER);
		        $this->setState(183);
		        $this->type();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function returnType(): Context\ReturnTypeContext
		{
		    $localContext = new Context\ReturnTypeContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 28, self::RULE_returnType);

		    try {
		        $this->setState(197);
		        $this->errorHandler->sync($this);

		        switch ($this->input->LA(1)) {
		            case self::T__0:
		            case self::T__1:
		            case self::T__2:
		            case self::T__3:
		            case self::T__4:
		            case self::T__5:
		            case self::T__6:
		            case self::T__8:
		            	$this->enterOuterAlt($localContext, 1);
		            	$this->setState(185);
		            	$this->type();
		            	break;

		            case self::T__15:
		            	$this->enterOuterAlt($localContext, 2);
		            	$this->setState(186);
		            	$this->match(self::T__15);
		            	$this->setState(187);
		            	$this->type();
		            	$this->setState(192);
		            	$this->errorHandler->sync($this);

		            	$_la = $this->input->LA(1);
		            	while ($_la === self::T__13) {
		            		$this->setState(188);
		            		$this->match(self::T__13);
		            		$this->setState(189);
		            		$this->type();
		            		$this->setState(194);
		            		$this->errorHandler->sync($this);
		            		$_la = $this->input->LA(1);
		            	}
		            	$this->setState(195);
		            	$this->match(self::T__16);
		            	break;

		        default:
		        	throw new NoViableAltException($this);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function block(): Context\BlockContext
		{
		    $localContext = new Context\BlockContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 30, self::RULE_block);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(199);
		        $this->match(self::T__17);
		        $this->setState(203);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177253037254272) !== 0)) {
		        	$this->setState(200);
		        	$this->statement();
		        	$this->setState(205);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		        $this->setState(206);
		        $this->match(self::T__18);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function statement(): Context\StatementContext
		{
		    $localContext = new Context\StatementContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 32, self::RULE_statement);

		    try {
		        $this->setState(221);
		        $this->errorHandler->sync($this);

		        switch ($this->getInterpreter()->adaptivePredict($this->input, 13, $this->ctx)) {
		        	case 1:
		        	    $this->enterOuterAlt($localContext, 1);
		        	    $this->setState(208);
		        	    $this->varDecl();
		        	break;

		        	case 2:
		        	    $this->enterOuterAlt($localContext, 2);
		        	    $this->setState(209);
		        	    $this->shortVarDecl();
		        	break;

		        	case 3:
		        	    $this->enterOuterAlt($localContext, 3);
		        	    $this->setState(210);
		        	    $this->constDecl();
		        	break;

		        	case 4:
		        	    $this->enterOuterAlt($localContext, 4);
		        	    $this->setState(211);
		        	    $this->assignment();
		        	break;

		        	case 5:
		        	    $this->enterOuterAlt($localContext, 5);
		        	    $this->setState(212);
		        	    $this->incDecStmt();
		        	break;

		        	case 6:
		        	    $this->enterOuterAlt($localContext, 6);
		        	    $this->setState(213);
		        	    $this->ifStmt();
		        	break;

		        	case 7:
		        	    $this->enterOuterAlt($localContext, 7);
		        	    $this->setState(214);
		        	    $this->switchStmt();
		        	break;

		        	case 8:
		        	    $this->enterOuterAlt($localContext, 8);
		        	    $this->setState(215);
		        	    $this->forStmt();
		        	break;

		        	case 9:
		        	    $this->enterOuterAlt($localContext, 9);
		        	    $this->setState(216);
		        	    $this->breakStmt();
		        	break;

		        	case 10:
		        	    $this->enterOuterAlt($localContext, 10);
		        	    $this->setState(217);
		        	    $this->continueStmt();
		        	break;

		        	case 11:
		        	    $this->enterOuterAlt($localContext, 11);
		        	    $this->setState(218);
		        	    $this->returnStmt();
		        	break;

		        	case 12:
		        	    $this->enterOuterAlt($localContext, 12);
		        	    $this->setState(219);
		        	    $this->expressionStmt();
		        	break;

		        	case 13:
		        	    $this->enterOuterAlt($localContext, 13);
		        	    $this->setState(220);
		        	    $this->block();
		        	break;
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function assignment(): Context\AssignmentContext
		{
		    $localContext = new Context\AssignmentContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 34, self::RULE_assignment);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(223);
		        $this->expression();
		        $this->setState(224);
		        $this->assignOp();
		        $this->setState(225);
		        $this->expression();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function expressionStmt(): Context\ExpressionStmtContext
		{
		    $localContext = new Context\ExpressionStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 36, self::RULE_expressionStmt);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(227);
		        $this->expression();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function assignOp(): Context\AssignOpContext
		{
		    $localContext = new Context\AssignOpContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 38, self::RULE_assignOp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(229);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 15730688) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function incDecStmt(): Context\IncDecStmtContext
		{
		    $localContext = new Context\IncDecStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 40, self::RULE_incDecStmt);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(231);
		        $this->expression();
		        $this->setState(232);

		        $_la = $this->input->LA(1);

		        if (!($_la === self::T__23 || $_la === self::T__24)) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function ifStmt(): Context\IfStmtContext
		{
		    $localContext = new Context\IfStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 42, self::RULE_ifStmt);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(234);
		        $this->match(self::T__25);
		        $this->setState(238);
		        $this->errorHandler->sync($this);

		        switch ($this->getInterpreter()->adaptivePredict($this->input, 14, $this->ctx)) {
		            case 1:
		        	    $this->setState(235);
		        	    $this->simpleStmt();
		        	    $this->setState(236);
		        	    $this->match(self::T__26);
		        	break;
		        }
		        $this->setState(240);
		        $this->expression();
		        $this->setState(241);
		        $this->block();
		        $this->setState(247);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::T__27) {
		        	$this->setState(242);
		        	$this->match(self::T__27);
		        	$this->setState(245);
		        	$this->errorHandler->sync($this);

		        	switch ($this->input->LA(1)) {
		        	    case self::T__25:
		        	    	$this->setState(243);
		        	    	$this->ifStmt();
		        	    	break;

		        	    case self::T__17:
		        	    	$this->setState(244);
		        	    	$this->block();
		        	    	break;

		        	default:
		        		throw new NoViableAltException($this);
		        	}
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function switchStmt(): Context\SwitchStmtContext
		{
		    $localContext = new Context\SwitchStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 44, self::RULE_switchStmt);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(249);
		        $this->match(self::T__28);
		        $this->setState(250);
		        $this->expression();
		        $this->setState(251);
		        $this->match(self::T__17);
		        $this->setState(255);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__29) {
		        	$this->setState(252);
		        	$this->caseClause();
		        	$this->setState(257);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		        $this->setState(259);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::T__31) {
		        	$this->setState(258);
		        	$this->defaultClause();
		        }
		        $this->setState(261);
		        $this->match(self::T__18);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function caseClause(): Context\CaseClauseContext
		{
		    $localContext = new Context\CaseClauseContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 46, self::RULE_caseClause);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(263);
		        $this->match(self::T__29);
		        $this->setState(264);
		        $this->expressionList();
		        $this->setState(265);
		        $this->match(self::T__30);
		        $this->setState(269);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177253037254272) !== 0)) {
		        	$this->setState(266);
		        	$this->statement();
		        	$this->setState(271);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function defaultClause(): Context\DefaultClauseContext
		{
		    $localContext = new Context\DefaultClauseContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 48, self::RULE_defaultClause);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(272);
		        $this->match(self::T__31);
		        $this->setState(273);
		        $this->match(self::T__30);
		        $this->setState(277);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177253037254272) !== 0)) {
		        	$this->setState(274);
		        	$this->statement();
		        	$this->setState(279);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function forStmt(): Context\ForStmtContext
		{
		    $localContext = new Context\ForStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 50, self::RULE_forStmt);

		    try {
		        $this->setState(290);
		        $this->errorHandler->sync($this);

		        switch ($this->getInterpreter()->adaptivePredict($this->input, 21, $this->ctx)) {
		        	case 1:
		        	    $this->enterOuterAlt($localContext, 1);
		        	    $this->setState(280);
		        	    $this->match(self::T__32);
		        	    $this->setState(281);
		        	    $this->forClause();
		        	    $this->setState(282);
		        	    $this->block();
		        	break;

		        	case 2:
		        	    $this->enterOuterAlt($localContext, 2);
		        	    $this->setState(284);
		        	    $this->match(self::T__32);
		        	    $this->setState(285);
		        	    $this->expression();
		        	    $this->setState(286);
		        	    $this->block();
		        	break;

		        	case 3:
		        	    $this->enterOuterAlt($localContext, 3);
		        	    $this->setState(288);
		        	    $this->match(self::T__32);
		        	    $this->setState(289);
		        	    $this->block();
		        	break;
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function forClause(): Context\ForClauseContext
		{
		    $localContext = new Context\ForClauseContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 52, self::RULE_forClause);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(293);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177123583985280) !== 0)) {
		        	$this->setState(292);
		        	$this->simpleStmt();
		        }
		        $this->setState(295);
		        $this->match(self::T__26);
		        $this->setState(297);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177123583984256) !== 0)) {
		        	$this->setState(296);
		        	$this->expression();
		        }
		        $this->setState(299);
		        $this->match(self::T__26);
		        $this->setState(301);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177123583985280) !== 0)) {
		        	$this->setState(300);
		        	$this->simpleStmt();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function simpleStmt(): Context\SimpleStmtContext
		{
		    $localContext = new Context\SimpleStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 54, self::RULE_simpleStmt);

		    try {
		        $this->setState(308);
		        $this->errorHandler->sync($this);

		        switch ($this->getInterpreter()->adaptivePredict($this->input, 25, $this->ctx)) {
		        	case 1:
		        	    $this->enterOuterAlt($localContext, 1);
		        	    $this->setState(303);
		        	    $this->shortVarDecl();
		        	break;

		        	case 2:
		        	    $this->enterOuterAlt($localContext, 2);
		        	    $this->setState(304);
		        	    $this->varDecl();
		        	break;

		        	case 3:
		        	    $this->enterOuterAlt($localContext, 3);
		        	    $this->setState(305);
		        	    $this->assignment();
		        	break;

		        	case 4:
		        	    $this->enterOuterAlt($localContext, 4);
		        	    $this->setState(306);
		        	    $this->incDecStmt();
		        	break;

		        	case 5:
		        	    $this->enterOuterAlt($localContext, 5);
		        	    $this->setState(307);
		        	    $this->expressionStmt();
		        	break;
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function breakStmt(): Context\BreakStmtContext
		{
		    $localContext = new Context\BreakStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 56, self::RULE_breakStmt);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(310);
		        $this->match(self::T__33);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function continueStmt(): Context\ContinueStmtContext
		{
		    $localContext = new Context\ContinueStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 58, self::RULE_continueStmt);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(312);
		        $this->match(self::T__34);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function returnStmt(): Context\ReturnStmtContext
		{
		    $localContext = new Context\ReturnStmtContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 60, self::RULE_returnStmt);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(314);
		        $this->match(self::T__35);
		        $this->setState(316);
		        $this->errorHandler->sync($this);

		        switch ($this->getInterpreter()->adaptivePredict($this->input, 26, $this->ctx)) {
		            case 1:
		        	    $this->setState(315);
		        	    $this->expressionList();
		        	break;
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function expression(): Context\ExpressionContext
		{
		    $localContext = new Context\ExpressionContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 62, self::RULE_expression);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(318);
		        $this->logicalOr();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function logicalOr(): Context\LogicalOrContext
		{
		    $localContext = new Context\LogicalOrContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 64, self::RULE_logicalOr);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(320);
		        $this->logicalAnd();
		        $this->setState(325);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__36) {
		        	$this->setState(321);
		        	$this->match(self::T__36);
		        	$this->setState(322);
		        	$this->logicalAnd();
		        	$this->setState(327);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function logicalAnd(): Context\LogicalAndContext
		{
		    $localContext = new Context\LogicalAndContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 66, self::RULE_logicalAnd);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(328);
		        $this->equality();
		        $this->setState(333);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__37) {
		        	$this->setState(329);
		        	$this->match(self::T__37);
		        	$this->setState(330);
		        	$this->equality();
		        	$this->setState(335);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function equality(): Context\EqualityContext
		{
		    $localContext = new Context\EqualityContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 68, self::RULE_equality);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(336);
		        $this->comparison();
		        $this->setState(341);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__38 || $_la === self::T__39) {
		        	$this->setState(337);

		        	$_la = $this->input->LA(1);

		        	if (!($_la === self::T__38 || $_la === self::T__39)) {
		        	$this->errorHandler->recoverInline($this);
		        	} else {
		        		if ($this->input->LA(1) === Token::EOF) {
		        		    $this->matchedEOF = true;
		        	    }

		        		$this->errorHandler->reportMatch($this);
		        		$this->consume();
		        	}
		        	$this->setState(338);
		        	$this->comparison();
		        	$this->setState(343);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function comparison(): Context\ComparisonContext
		{
		    $localContext = new Context\ComparisonContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 70, self::RULE_comparison);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(344);
		        $this->addition();
		        $this->setState(349);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 32985348833280) !== 0)) {
		        	$this->setState(345);

		        	$_la = $this->input->LA(1);

		        	if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 32985348833280) !== 0))) {
		        	$this->errorHandler->recoverInline($this);
		        	} else {
		        		if ($this->input->LA(1) === Token::EOF) {
		        		    $this->matchedEOF = true;
		        	    }

		        		$this->errorHandler->reportMatch($this);
		        		$this->consume();
		        	}
		        	$this->setState(346);
		        	$this->addition();
		        	$this->setState(351);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function addition(): Context\AdditionContext
		{
		    $localContext = new Context\AdditionContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 72, self::RULE_addition);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(352);
		        $this->multiplication();
		        $this->setState(357);
		        $this->errorHandler->sync($this);

		        $alt = $this->getInterpreter()->adaptivePredict($this->input, 31, $this->ctx);

		        while ($alt !== 2 && $alt !== ATN::INVALID_ALT_NUMBER) {
		        	if ($alt === 1) {
		        		$this->setState(353);

		        		$_la = $this->input->LA(1);

		        		if (!($_la === self::T__44 || $_la === self::T__45)) {
		        		$this->errorHandler->recoverInline($this);
		        		} else {
		        			if ($this->input->LA(1) === Token::EOF) {
		        			    $this->matchedEOF = true;
		        		    }

		        			$this->errorHandler->reportMatch($this);
		        			$this->consume();
		        		}
		        		$this->setState(354);
		        		$this->multiplication(); 
		        	}

		        	$this->setState(359);
		        	$this->errorHandler->sync($this);

		        	$alt = $this->getInterpreter()->adaptivePredict($this->input, 31, $this->ctx);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function multiplication(): Context\MultiplicationContext
		{
		    $localContext = new Context\MultiplicationContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 74, self::RULE_multiplication);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(360);
		        $this->unary();
		        $this->setState(365);
		        $this->errorHandler->sync($this);

		        $alt = $this->getInterpreter()->adaptivePredict($this->input, 32, $this->ctx);

		        while ($alt !== 2 && $alt !== ATN::INVALID_ALT_NUMBER) {
		        	if ($alt === 1) {
		        		$this->setState(361);

		        		$_la = $this->input->LA(1);

		        		if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 422212465066496) !== 0))) {
		        		$this->errorHandler->recoverInline($this);
		        		} else {
		        			if ($this->input->LA(1) === Token::EOF) {
		        			    $this->matchedEOF = true;
		        		    }

		        			$this->errorHandler->reportMatch($this);
		        			$this->consume();
		        		}
		        		$this->setState(362);
		        		$this->unary(); 
		        	}

		        	$this->setState(367);
		        	$this->errorHandler->sync($this);

		        	$alt = $this->getInterpreter()->adaptivePredict($this->input, 32, $this->ctx);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function unary(): Context\UnaryContext
		{
		    $localContext = new Context\UnaryContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 76, self::RULE_unary);

		    try {
		        $this->setState(371);
		        $this->errorHandler->sync($this);

		        switch ($this->input->LA(1)) {
		            case self::T__8:
		            case self::T__45:
		            case self::T__48:
		            case self::T__49:
		            	$this->enterOuterAlt($localContext, 1);
		            	$this->setState(368);

		            	$_la = $this->input->LA(1);

		            	if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1759218604442112) !== 0))) {
		            	$this->errorHandler->recoverInline($this);
		            	} else {
		            		if ($this->input->LA(1) === Token::EOF) {
		            		    $this->matchedEOF = true;
		            	    }

		            		$this->errorHandler->reportMatch($this);
		            		$this->consume();
		            	}
		            	$this->setState(369);
		            	$this->unary();
		            	break;

		            case self::T__6:
		            case self::T__15:
		            case self::T__51:
		            case self::T__52:
		            case self::T__53:
		            case self::IDENTIFIER:
		            case self::INT_LITERAL:
		            case self::FLOAT_LITERAL:
		            case self::STRING_LITERAL:
		            case self::RUNE_LITERAL:
		            	$this->enterOuterAlt($localContext, 2);
		            	$this->setState(370);
		            	$this->primary();
		            	break;

		        default:
		        	throw new NoViableAltException($this);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function primary(): Context\PrimaryContext
		{
		    $localContext = new Context\PrimaryContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 78, self::RULE_primary);

		    try {
		        $this->setState(382);
		        $this->errorHandler->sync($this);

		        switch ($this->getInterpreter()->adaptivePredict($this->input, 34, $this->ctx)) {
		        	case 1:
		        	    $this->enterOuterAlt($localContext, 1);
		        	    $this->setState(373);
		        	    $this->literal();
		        	break;

		        	case 2:
		        	    $this->enterOuterAlt($localContext, 2);
		        	    $this->setState(374);
		        	    $this->arrayLiteral();
		        	break;

		        	case 3:
		        	    $this->enterOuterAlt($localContext, 3);
		        	    $this->setState(375);
		        	    $this->functionCall();
		        	break;

		        	case 4:
		        	    $this->enterOuterAlt($localContext, 4);
		        	    $this->setState(376);
		        	    $this->qualifiedIdentifier();
		        	break;

		        	case 5:
		        	    $this->enterOuterAlt($localContext, 5);
		        	    $this->setState(377);
		        	    $this->arrayAccess();
		        	break;

		        	case 6:
		        	    $this->enterOuterAlt($localContext, 6);
		        	    $this->setState(378);
		        	    $this->match(self::T__15);
		        	    $this->setState(379);
		        	    $this->expression();
		        	    $this->setState(380);
		        	    $this->match(self::T__16);
		        	break;
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function arrayAccess(): Context\ArrayAccessContext
		{
		    $localContext = new Context\ArrayAccessContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 80, self::RULE_arrayAccess);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(384);
		        $this->qualifiedIdentifier();
		        $this->setState(389); 
		        $this->errorHandler->sync($this);

		        $alt = 1;

		        do {
		        	switch ($alt) {
		        	case 1:
		        		$this->setState(385);
		        		$this->match(self::T__6);
		        		$this->setState(386);
		        		$this->expression();
		        		$this->setState(387);
		        		$this->match(self::T__7);
		        		break;
		        	default:
		        		throw new NoViableAltException($this);
		        	}

		        	$this->setState(391); 
		        	$this->errorHandler->sync($this);

		        	$alt = $this->getInterpreter()->adaptivePredict($this->input, 35, $this->ctx);
		        } while ($alt !== 2 && $alt !== ATN::INVALID_ALT_NUMBER);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function arrayLiteral(): Context\ArrayLiteralContext
		{
		    $localContext = new Context\ArrayLiteralContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 82, self::RULE_arrayLiteral);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(393);
		        $this->arrayType();
		        $this->setState(394);
		        $this->arrayLiteralBody();
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function arrayLiteralBody(): Context\ArrayLiteralBodyContext
		{
		    $localContext = new Context\ArrayLiteralBodyContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 84, self::RULE_arrayLiteralBody);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(396);
		        $this->match(self::T__17);
		        $this->setState(398);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177123584246400) !== 0)) {
		        	$this->setState(397);
		        	$this->arrayElementList();
		        }
		        $this->setState(400);
		        $this->match(self::T__18);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function arrayElementList(): Context\ArrayElementListContext
		{
		    $localContext = new Context\ArrayElementListContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 86, self::RULE_arrayElementList);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(402);
		        $this->arrayElement();
		        $this->setState(407);
		        $this->errorHandler->sync($this);

		        $alt = $this->getInterpreter()->adaptivePredict($this->input, 37, $this->ctx);

		        while ($alt !== 2 && $alt !== ATN::INVALID_ALT_NUMBER) {
		        	if ($alt === 1) {
		        		$this->setState(403);
		        		$this->match(self::T__13);
		        		$this->setState(404);
		        		$this->arrayElement(); 
		        	}

		        	$this->setState(409);
		        	$this->errorHandler->sync($this);

		        	$alt = $this->getInterpreter()->adaptivePredict($this->input, 37, $this->ctx);
		        }
		        $this->setState(411);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::T__13) {
		        	$this->setState(410);
		        	$this->match(self::T__13);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function arrayElement(): Context\ArrayElementContext
		{
		    $localContext = new Context\ArrayElementContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 88, self::RULE_arrayElement);

		    try {
		        $this->setState(415);
		        $this->errorHandler->sync($this);

		        switch ($this->input->LA(1)) {
		            case self::T__6:
		            case self::T__8:
		            case self::T__15:
		            case self::T__45:
		            case self::T__48:
		            case self::T__49:
		            case self::T__51:
		            case self::T__52:
		            case self::T__53:
		            case self::IDENTIFIER:
		            case self::INT_LITERAL:
		            case self::FLOAT_LITERAL:
		            case self::STRING_LITERAL:
		            case self::RUNE_LITERAL:
		            	$this->enterOuterAlt($localContext, 1);
		            	$this->setState(413);
		            	$this->expression();
		            	break;

		            case self::T__17:
		            	$this->enterOuterAlt($localContext, 2);
		            	$this->setState(414);
		            	$this->arrayLiteralBody();
		            	break;

		        default:
		        	throw new NoViableAltException($this);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function functionCall(): Context\FunctionCallContext
		{
		    $localContext = new Context\FunctionCallContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 90, self::RULE_functionCall);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(417);
		        $this->qualifiedIdentifier();
		        $this->setState(418);
		        $this->match(self::T__15);
		        $this->setState(420);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1150177123583984256) !== 0)) {
		        	$this->setState(419);
		        	$this->argumentList();
		        }
		        $this->setState(422);
		        $this->match(self::T__16);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function argumentList(): Context\ArgumentListContext
		{
		    $localContext = new Context\ArgumentListContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 92, self::RULE_argumentList);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(424);
		        $this->expression();
		        $this->setState(429);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__13) {
		        	$this->setState(425);
		        	$this->match(self::T__13);
		        	$this->setState(426);
		        	$this->expression();
		        	$this->setState(431);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function qualifiedIdentifier(): Context\QualifiedIdentifierContext
		{
		    $localContext = new Context\QualifiedIdentifierContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 94, self::RULE_qualifiedIdentifier);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(432);
		        $this->match(self::IDENTIFIER);
		        $this->setState(437);
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        while ($_la === self::T__50) {
		        	$this->setState(433);
		        	$this->match(self::T__50);
		        	$this->setState(434);
		        	$this->match(self::IDENTIFIER);
		        	$this->setState(439);
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function literal(): Context\LiteralContext
		{
		    $localContext = new Context\LiteralContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 96, self::RULE_literal);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(440);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1112389107960512512) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}
	}
}

namespace Context {
	use Antlr\Antlr4\Runtime\ParserRuleContext;
	use Antlr\Antlr4\Runtime\Token;
	use Antlr\Antlr4\Runtime\Tree\ParseTreeVisitor;
	use Antlr\Antlr4\Runtime\Tree\TerminalNode;
	use Antlr\Antlr4\Runtime\Tree\ParseTreeListener;
	use GolampiParser;
	use GolampiVisitor;
	use GolampiListener;

	class ProgramContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_program;
	    }

	    public function EOF(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::EOF, 0);
	    }

	    /**
	     * @return array<TopLevelDeclContext>|TopLevelDeclContext|null
	     */
	    public function topLevelDecl(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(TopLevelDeclContext::class);
	    	}

	        return $this->getTypedRuleContext(TopLevelDeclContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterProgram($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitProgram($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitProgram($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class TopLevelDeclContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_topLevelDecl;
	    }

	    public function varDecl(): ?VarDeclContext
	    {
	    	return $this->getTypedRuleContext(VarDeclContext::class, 0);
	    }

	    public function constDecl(): ?ConstDeclContext
	    {
	    	return $this->getTypedRuleContext(ConstDeclContext::class, 0);
	    }

	    public function functionDecl(): ?FunctionDeclContext
	    {
	    	return $this->getTypedRuleContext(FunctionDeclContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterTopLevelDecl($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitTopLevelDecl($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitTopLevelDecl($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class TypeContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_type;
	    }

	    public function baseType(): ?BaseTypeContext
	    {
	    	return $this->getTypedRuleContext(BaseTypeContext::class, 0);
	    }

	    public function arrayType(): ?ArrayTypeContext
	    {
	    	return $this->getTypedRuleContext(ArrayTypeContext::class, 0);
	    }

	    public function pointerType(): ?PointerTypeContext
	    {
	    	return $this->getTypedRuleContext(PointerTypeContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterType($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitType($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitType($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class BaseTypeContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_baseType;
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterBaseType($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitBaseType($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitBaseType($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ArrayTypeContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_arrayType;
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

	    public function type(): ?TypeContext
	    {
	    	return $this->getTypedRuleContext(TypeContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterArrayType($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitArrayType($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitArrayType($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class PointerTypeContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_pointerType;
	    }

	    public function type(): ?TypeContext
	    {
	    	return $this->getTypedRuleContext(TypeContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterPointerType($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitPointerType($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitPointerType($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class VarDeclContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_varDecl;
	    }

	    public function identifierList(): ?IdentifierListContext
	    {
	    	return $this->getTypedRuleContext(IdentifierListContext::class, 0);
	    }

	    public function type(): ?TypeContext
	    {
	    	return $this->getTypedRuleContext(TypeContext::class, 0);
	    }

	    public function expressionList(): ?ExpressionListContext
	    {
	    	return $this->getTypedRuleContext(ExpressionListContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterVarDecl($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitVarDecl($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitVarDecl($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ShortVarDeclContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_shortVarDecl;
	    }

	    public function identifierList(): ?IdentifierListContext
	    {
	    	return $this->getTypedRuleContext(IdentifierListContext::class, 0);
	    }

	    public function expressionList(): ?ExpressionListContext
	    {
	    	return $this->getTypedRuleContext(ExpressionListContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterShortVarDecl($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitShortVarDecl($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitShortVarDecl($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ConstDeclContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_constDecl;
	    }

	    public function IDENTIFIER(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::IDENTIFIER, 0);
	    }

	    public function type(): ?TypeContext
	    {
	    	return $this->getTypedRuleContext(TypeContext::class, 0);
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterConstDecl($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitConstDecl($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitConstDecl($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class IdentifierListContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_identifierList;
	    }

	    /**
	     * @return array<TerminalNode>|TerminalNode|null
	     */
	    public function IDENTIFIER(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTokens(GolampiParser::IDENTIFIER);
	    	}

	        return $this->getToken(GolampiParser::IDENTIFIER, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterIdentifierList($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitIdentifierList($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitIdentifierList($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ExpressionListContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_expressionList;
	    }

	    /**
	     * @return array<ExpressionContext>|ExpressionContext|null
	     */
	    public function expression(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(ExpressionContext::class);
	    	}

	        return $this->getTypedRuleContext(ExpressionContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterExpressionList($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitExpressionList($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitExpressionList($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class FunctionDeclContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_functionDecl;
	    }

	    public function IDENTIFIER(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::IDENTIFIER, 0);
	    }

	    public function block(): ?BlockContext
	    {
	    	return $this->getTypedRuleContext(BlockContext::class, 0);
	    }

	    public function parameters(): ?ParametersContext
	    {
	    	return $this->getTypedRuleContext(ParametersContext::class, 0);
	    }

	    public function returnType(): ?ReturnTypeContext
	    {
	    	return $this->getTypedRuleContext(ReturnTypeContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterFunctionDecl($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitFunctionDecl($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitFunctionDecl($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ParametersContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_parameters;
	    }

	    /**
	     * @return array<ParameterContext>|ParameterContext|null
	     */
	    public function parameter(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(ParameterContext::class);
	    	}

	        return $this->getTypedRuleContext(ParameterContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterParameters($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitParameters($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitParameters($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ParameterContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_parameter;
	    }

	    public function IDENTIFIER(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::IDENTIFIER, 0);
	    }

	    public function type(): ?TypeContext
	    {
	    	return $this->getTypedRuleContext(TypeContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterParameter($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitParameter($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitParameter($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ReturnTypeContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_returnType;
	    }

	    /**
	     * @return array<TypeContext>|TypeContext|null
	     */
	    public function type(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(TypeContext::class);
	    	}

	        return $this->getTypedRuleContext(TypeContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterReturnType($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitReturnType($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitReturnType($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class BlockContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_block;
	    }

	    /**
	     * @return array<StatementContext>|StatementContext|null
	     */
	    public function statement(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(StatementContext::class);
	    	}

	        return $this->getTypedRuleContext(StatementContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterBlock($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitBlock($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitBlock($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class StatementContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_statement;
	    }

	    public function varDecl(): ?VarDeclContext
	    {
	    	return $this->getTypedRuleContext(VarDeclContext::class, 0);
	    }

	    public function shortVarDecl(): ?ShortVarDeclContext
	    {
	    	return $this->getTypedRuleContext(ShortVarDeclContext::class, 0);
	    }

	    public function constDecl(): ?ConstDeclContext
	    {
	    	return $this->getTypedRuleContext(ConstDeclContext::class, 0);
	    }

	    public function assignment(): ?AssignmentContext
	    {
	    	return $this->getTypedRuleContext(AssignmentContext::class, 0);
	    }

	    public function incDecStmt(): ?IncDecStmtContext
	    {
	    	return $this->getTypedRuleContext(IncDecStmtContext::class, 0);
	    }

	    public function ifStmt(): ?IfStmtContext
	    {
	    	return $this->getTypedRuleContext(IfStmtContext::class, 0);
	    }

	    public function switchStmt(): ?SwitchStmtContext
	    {
	    	return $this->getTypedRuleContext(SwitchStmtContext::class, 0);
	    }

	    public function forStmt(): ?ForStmtContext
	    {
	    	return $this->getTypedRuleContext(ForStmtContext::class, 0);
	    }

	    public function breakStmt(): ?BreakStmtContext
	    {
	    	return $this->getTypedRuleContext(BreakStmtContext::class, 0);
	    }

	    public function continueStmt(): ?ContinueStmtContext
	    {
	    	return $this->getTypedRuleContext(ContinueStmtContext::class, 0);
	    }

	    public function returnStmt(): ?ReturnStmtContext
	    {
	    	return $this->getTypedRuleContext(ReturnStmtContext::class, 0);
	    }

	    public function expressionStmt(): ?ExpressionStmtContext
	    {
	    	return $this->getTypedRuleContext(ExpressionStmtContext::class, 0);
	    }

	    public function block(): ?BlockContext
	    {
	    	return $this->getTypedRuleContext(BlockContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterStatement($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitStatement($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitStatement($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AssignmentContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_assignment;
	    }

	    /**
	     * @return array<ExpressionContext>|ExpressionContext|null
	     */
	    public function expression(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(ExpressionContext::class);
	    	}

	        return $this->getTypedRuleContext(ExpressionContext::class, $index);
	    }

	    public function assignOp(): ?AssignOpContext
	    {
	    	return $this->getTypedRuleContext(AssignOpContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterAssignment($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitAssignment($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitAssignment($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ExpressionStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_expressionStmt;
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterExpressionStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitExpressionStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitExpressionStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AssignOpContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_assignOp;
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterAssignOp($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitAssignOp($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitAssignOp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class IncDecStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_incDecStmt;
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterIncDecStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitIncDecStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitIncDecStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class IfStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_ifStmt;
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

	    /**
	     * @return array<BlockContext>|BlockContext|null
	     */
	    public function block(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(BlockContext::class);
	    	}

	        return $this->getTypedRuleContext(BlockContext::class, $index);
	    }

	    public function simpleStmt(): ?SimpleStmtContext
	    {
	    	return $this->getTypedRuleContext(SimpleStmtContext::class, 0);
	    }

	    public function ifStmt(): ?IfStmtContext
	    {
	    	return $this->getTypedRuleContext(IfStmtContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterIfStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitIfStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitIfStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class SwitchStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_switchStmt;
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

	    /**
	     * @return array<CaseClauseContext>|CaseClauseContext|null
	     */
	    public function caseClause(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(CaseClauseContext::class);
	    	}

	        return $this->getTypedRuleContext(CaseClauseContext::class, $index);
	    }

	    public function defaultClause(): ?DefaultClauseContext
	    {
	    	return $this->getTypedRuleContext(DefaultClauseContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterSwitchStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitSwitchStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitSwitchStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class CaseClauseContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_caseClause;
	    }

	    public function expressionList(): ?ExpressionListContext
	    {
	    	return $this->getTypedRuleContext(ExpressionListContext::class, 0);
	    }

	    /**
	     * @return array<StatementContext>|StatementContext|null
	     */
	    public function statement(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(StatementContext::class);
	    	}

	        return $this->getTypedRuleContext(StatementContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterCaseClause($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitCaseClause($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitCaseClause($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class DefaultClauseContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_defaultClause;
	    }

	    /**
	     * @return array<StatementContext>|StatementContext|null
	     */
	    public function statement(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(StatementContext::class);
	    	}

	        return $this->getTypedRuleContext(StatementContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterDefaultClause($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitDefaultClause($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitDefaultClause($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ForStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_forStmt;
	    }

	    public function forClause(): ?ForClauseContext
	    {
	    	return $this->getTypedRuleContext(ForClauseContext::class, 0);
	    }

	    public function block(): ?BlockContext
	    {
	    	return $this->getTypedRuleContext(BlockContext::class, 0);
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterForStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitForStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitForStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ForClauseContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_forClause;
	    }

	    /**
	     * @return array<SimpleStmtContext>|SimpleStmtContext|null
	     */
	    public function simpleStmt(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(SimpleStmtContext::class);
	    	}

	        return $this->getTypedRuleContext(SimpleStmtContext::class, $index);
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterForClause($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitForClause($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitForClause($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class SimpleStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_simpleStmt;
	    }

	    public function shortVarDecl(): ?ShortVarDeclContext
	    {
	    	return $this->getTypedRuleContext(ShortVarDeclContext::class, 0);
	    }

	    public function varDecl(): ?VarDeclContext
	    {
	    	return $this->getTypedRuleContext(VarDeclContext::class, 0);
	    }

	    public function assignment(): ?AssignmentContext
	    {
	    	return $this->getTypedRuleContext(AssignmentContext::class, 0);
	    }

	    public function incDecStmt(): ?IncDecStmtContext
	    {
	    	return $this->getTypedRuleContext(IncDecStmtContext::class, 0);
	    }

	    public function expressionStmt(): ?ExpressionStmtContext
	    {
	    	return $this->getTypedRuleContext(ExpressionStmtContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterSimpleStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitSimpleStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitSimpleStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class BreakStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_breakStmt;
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterBreakStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitBreakStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitBreakStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ContinueStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_continueStmt;
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterContinueStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitContinueStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitContinueStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ReturnStmtContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_returnStmt;
	    }

	    public function expressionList(): ?ExpressionListContext
	    {
	    	return $this->getTypedRuleContext(ExpressionListContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterReturnStmt($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitReturnStmt($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitReturnStmt($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ExpressionContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_expression;
	    }

	    public function logicalOr(): ?LogicalOrContext
	    {
	    	return $this->getTypedRuleContext(LogicalOrContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterExpression($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitExpression($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitExpression($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class LogicalOrContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_logicalOr;
	    }

	    /**
	     * @return array<LogicalAndContext>|LogicalAndContext|null
	     */
	    public function logicalAnd(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(LogicalAndContext::class);
	    	}

	        return $this->getTypedRuleContext(LogicalAndContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterLogicalOr($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitLogicalOr($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitLogicalOr($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class LogicalAndContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_logicalAnd;
	    }

	    /**
	     * @return array<EqualityContext>|EqualityContext|null
	     */
	    public function equality(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(EqualityContext::class);
	    	}

	        return $this->getTypedRuleContext(EqualityContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterLogicalAnd($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitLogicalAnd($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitLogicalAnd($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class EqualityContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_equality;
	    }

	    /**
	     * @return array<ComparisonContext>|ComparisonContext|null
	     */
	    public function comparison(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(ComparisonContext::class);
	    	}

	        return $this->getTypedRuleContext(ComparisonContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterEquality($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitEquality($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitEquality($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ComparisonContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_comparison;
	    }

	    /**
	     * @return array<AdditionContext>|AdditionContext|null
	     */
	    public function addition(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(AdditionContext::class);
	    	}

	        return $this->getTypedRuleContext(AdditionContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterComparison($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitComparison($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitComparison($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AdditionContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_addition;
	    }

	    /**
	     * @return array<MultiplicationContext>|MultiplicationContext|null
	     */
	    public function multiplication(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(MultiplicationContext::class);
	    	}

	        return $this->getTypedRuleContext(MultiplicationContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterAddition($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitAddition($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitAddition($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class MultiplicationContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_multiplication;
	    }

	    /**
	     * @return array<UnaryContext>|UnaryContext|null
	     */
	    public function unary(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(UnaryContext::class);
	    	}

	        return $this->getTypedRuleContext(UnaryContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterMultiplication($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitMultiplication($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitMultiplication($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class UnaryContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_unary;
	    }

	    public function unary(): ?UnaryContext
	    {
	    	return $this->getTypedRuleContext(UnaryContext::class, 0);
	    }

	    public function primary(): ?PrimaryContext
	    {
	    	return $this->getTypedRuleContext(PrimaryContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterUnary($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitUnary($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitUnary($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class PrimaryContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_primary;
	    }

	    public function literal(): ?LiteralContext
	    {
	    	return $this->getTypedRuleContext(LiteralContext::class, 0);
	    }

	    public function arrayLiteral(): ?ArrayLiteralContext
	    {
	    	return $this->getTypedRuleContext(ArrayLiteralContext::class, 0);
	    }

	    public function functionCall(): ?FunctionCallContext
	    {
	    	return $this->getTypedRuleContext(FunctionCallContext::class, 0);
	    }

	    public function qualifiedIdentifier(): ?QualifiedIdentifierContext
	    {
	    	return $this->getTypedRuleContext(QualifiedIdentifierContext::class, 0);
	    }

	    public function arrayAccess(): ?ArrayAccessContext
	    {
	    	return $this->getTypedRuleContext(ArrayAccessContext::class, 0);
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterPrimary($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitPrimary($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitPrimary($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ArrayAccessContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_arrayAccess;
	    }

	    public function qualifiedIdentifier(): ?QualifiedIdentifierContext
	    {
	    	return $this->getTypedRuleContext(QualifiedIdentifierContext::class, 0);
	    }

	    /**
	     * @return array<ExpressionContext>|ExpressionContext|null
	     */
	    public function expression(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(ExpressionContext::class);
	    	}

	        return $this->getTypedRuleContext(ExpressionContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterArrayAccess($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitArrayAccess($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitArrayAccess($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ArrayLiteralContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_arrayLiteral;
	    }

	    public function arrayType(): ?ArrayTypeContext
	    {
	    	return $this->getTypedRuleContext(ArrayTypeContext::class, 0);
	    }

	    public function arrayLiteralBody(): ?ArrayLiteralBodyContext
	    {
	    	return $this->getTypedRuleContext(ArrayLiteralBodyContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterArrayLiteral($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitArrayLiteral($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitArrayLiteral($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ArrayLiteralBodyContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_arrayLiteralBody;
	    }

	    public function arrayElementList(): ?ArrayElementListContext
	    {
	    	return $this->getTypedRuleContext(ArrayElementListContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterArrayLiteralBody($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitArrayLiteralBody($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitArrayLiteralBody($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ArrayElementListContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_arrayElementList;
	    }

	    /**
	     * @return array<ArrayElementContext>|ArrayElementContext|null
	     */
	    public function arrayElement(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(ArrayElementContext::class);
	    	}

	        return $this->getTypedRuleContext(ArrayElementContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterArrayElementList($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitArrayElementList($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitArrayElementList($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ArrayElementContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_arrayElement;
	    }

	    public function expression(): ?ExpressionContext
	    {
	    	return $this->getTypedRuleContext(ExpressionContext::class, 0);
	    }

	    public function arrayLiteralBody(): ?ArrayLiteralBodyContext
	    {
	    	return $this->getTypedRuleContext(ArrayLiteralBodyContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterArrayElement($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitArrayElement($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitArrayElement($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class FunctionCallContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_functionCall;
	    }

	    public function qualifiedIdentifier(): ?QualifiedIdentifierContext
	    {
	    	return $this->getTypedRuleContext(QualifiedIdentifierContext::class, 0);
	    }

	    public function argumentList(): ?ArgumentListContext
	    {
	    	return $this->getTypedRuleContext(ArgumentListContext::class, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterFunctionCall($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitFunctionCall($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitFunctionCall($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ArgumentListContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_argumentList;
	    }

	    /**
	     * @return array<ExpressionContext>|ExpressionContext|null
	     */
	    public function expression(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(ExpressionContext::class);
	    	}

	        return $this->getTypedRuleContext(ExpressionContext::class, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterArgumentList($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitArgumentList($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitArgumentList($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class QualifiedIdentifierContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_qualifiedIdentifier;
	    }

	    /**
	     * @return array<TerminalNode>|TerminalNode|null
	     */
	    public function IDENTIFIER(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTokens(GolampiParser::IDENTIFIER);
	    	}

	        return $this->getToken(GolampiParser::IDENTIFIER, $index);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterQualifiedIdentifier($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitQualifiedIdentifier($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitQualifiedIdentifier($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class LiteralContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return GolampiParser::RULE_literal;
	    }

	    public function INT_LITERAL(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::INT_LITERAL, 0);
	    }

	    public function FLOAT_LITERAL(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::FLOAT_LITERAL, 0);
	    }

	    public function STRING_LITERAL(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::STRING_LITERAL, 0);
	    }

	    public function RUNE_LITERAL(): ?TerminalNode
	    {
	        return $this->getToken(GolampiParser::RUNE_LITERAL, 0);
	    }

		public function enterRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->enterLiteral($this);
		    }
		}

		public function exitRule(ParseTreeListener $listener): void
		{
			if ($listener instanceof GolampiListener) {
			    $listener->exitLiteral($this);
		    }
		}

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof GolampiVisitor) {
			    return $visitor->visitLiteral($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 
}