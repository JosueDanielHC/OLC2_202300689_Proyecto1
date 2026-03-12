<?php

/*
 * Generated from Golampi.g4 by ANTLR 4.13.1
 */

use Antlr\Antlr4\Runtime\Tree\ParseTreeVisitor;

/**
 * This interface defines a complete generic visitor for a parse tree produced by {@see GolampiParser}.
 */
interface GolampiVisitor extends ParseTreeVisitor
{
	/**
	 * Visit a parse tree produced by {@see GolampiParser::program()}.
	 *
	 * @param Context\ProgramContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitProgram(Context\ProgramContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::topLevelDecl()}.
	 *
	 * @param Context\TopLevelDeclContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitTopLevelDecl(Context\TopLevelDeclContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::type()}.
	 *
	 * @param Context\TypeContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitType(Context\TypeContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::baseType()}.
	 *
	 * @param Context\BaseTypeContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitBaseType(Context\BaseTypeContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::arrayType()}.
	 *
	 * @param Context\ArrayTypeContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitArrayType(Context\ArrayTypeContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::pointerType()}.
	 *
	 * @param Context\PointerTypeContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPointerType(Context\PointerTypeContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::varDecl()}.
	 *
	 * @param Context\VarDeclContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitVarDecl(Context\VarDeclContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::shortVarDecl()}.
	 *
	 * @param Context\ShortVarDeclContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitShortVarDecl(Context\ShortVarDeclContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::constDecl()}.
	 *
	 * @param Context\ConstDeclContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitConstDecl(Context\ConstDeclContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::identifierList()}.
	 *
	 * @param Context\IdentifierListContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitIdentifierList(Context\IdentifierListContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::expressionList()}.
	 *
	 * @param Context\ExpressionListContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitExpressionList(Context\ExpressionListContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::functionDecl()}.
	 *
	 * @param Context\FunctionDeclContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitFunctionDecl(Context\FunctionDeclContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::parameters()}.
	 *
	 * @param Context\ParametersContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitParameters(Context\ParametersContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::parameter()}.
	 *
	 * @param Context\ParameterContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitParameter(Context\ParameterContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::returnType()}.
	 *
	 * @param Context\ReturnTypeContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitReturnType(Context\ReturnTypeContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::block()}.
	 *
	 * @param Context\BlockContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitBlock(Context\BlockContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::statement()}.
	 *
	 * @param Context\StatementContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitStatement(Context\StatementContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::assignment()}.
	 *
	 * @param Context\AssignmentContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAssignment(Context\AssignmentContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::expressionStmt()}.
	 *
	 * @param Context\ExpressionStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitExpressionStmt(Context\ExpressionStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::assignOp()}.
	 *
	 * @param Context\AssignOpContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAssignOp(Context\AssignOpContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::incDecStmt()}.
	 *
	 * @param Context\IncDecStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitIncDecStmt(Context\IncDecStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::ifStmt()}.
	 *
	 * @param Context\IfStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitIfStmt(Context\IfStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::switchStmt()}.
	 *
	 * @param Context\SwitchStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitSwitchStmt(Context\SwitchStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::caseClause()}.
	 *
	 * @param Context\CaseClauseContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitCaseClause(Context\CaseClauseContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::defaultClause()}.
	 *
	 * @param Context\DefaultClauseContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDefaultClause(Context\DefaultClauseContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::forStmt()}.
	 *
	 * @param Context\ForStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitForStmt(Context\ForStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::forClause()}.
	 *
	 * @param Context\ForClauseContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitForClause(Context\ForClauseContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::simpleStmt()}.
	 *
	 * @param Context\SimpleStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitSimpleStmt(Context\SimpleStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::breakStmt()}.
	 *
	 * @param Context\BreakStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitBreakStmt(Context\BreakStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::continueStmt()}.
	 *
	 * @param Context\ContinueStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitContinueStmt(Context\ContinueStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::returnStmt()}.
	 *
	 * @param Context\ReturnStmtContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitReturnStmt(Context\ReturnStmtContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::expression()}.
	 *
	 * @param Context\ExpressionContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitExpression(Context\ExpressionContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::logicalOr()}.
	 *
	 * @param Context\LogicalOrContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitLogicalOr(Context\LogicalOrContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::logicalAnd()}.
	 *
	 * @param Context\LogicalAndContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitLogicalAnd(Context\LogicalAndContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::equality()}.
	 *
	 * @param Context\EqualityContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitEquality(Context\EqualityContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::comparison()}.
	 *
	 * @param Context\ComparisonContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitComparison(Context\ComparisonContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::addition()}.
	 *
	 * @param Context\AdditionContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAddition(Context\AdditionContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::multiplication()}.
	 *
	 * @param Context\MultiplicationContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitMultiplication(Context\MultiplicationContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::unary()}.
	 *
	 * @param Context\UnaryContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitUnary(Context\UnaryContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::primary()}.
	 *
	 * @param Context\PrimaryContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPrimary(Context\PrimaryContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::arrayAccess()}.
	 *
	 * @param Context\ArrayAccessContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitArrayAccess(Context\ArrayAccessContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::arrayLiteral()}.
	 *
	 * @param Context\ArrayLiteralContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitArrayLiteral(Context\ArrayLiteralContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::arrayLiteralBody()}.
	 *
	 * @param Context\ArrayLiteralBodyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitArrayLiteralBody(Context\ArrayLiteralBodyContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::arrayElementList()}.
	 *
	 * @param Context\ArrayElementListContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitArrayElementList(Context\ArrayElementListContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::arrayElement()}.
	 *
	 * @param Context\ArrayElementContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitArrayElement(Context\ArrayElementContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::functionCall()}.
	 *
	 * @param Context\FunctionCallContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitFunctionCall(Context\FunctionCallContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::argumentList()}.
	 *
	 * @param Context\ArgumentListContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitArgumentList(Context\ArgumentListContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::qualifiedIdentifier()}.
	 *
	 * @param Context\QualifiedIdentifierContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitQualifiedIdentifier(Context\QualifiedIdentifierContext $context);

	/**
	 * Visit a parse tree produced by {@see GolampiParser::literal()}.
	 *
	 * @param Context\LiteralContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitLiteral(Context\LiteralContext $context);
}