<?php

use Nerp\SyntaxNode;
use Nerp\NodeTypes\Integer;
use Nerp\NodeTypes\AddOperation;
use Nerp\NodeTypes\FunctionCall;
use Nerp\Parser;
use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenType;

function expectLeafNodeMatches(SyntaxNode $expectedNode, SyntaxNode $actualNode) {
    expect($actualNode->evaluate())->toEqual($expectedNode->evaluate());
    expect(get_class($actualNode))->toEqual(get_class($expectedNode));
    expect($actualNode->hasChildren())->toEqual($expectedNode->hasChildren());
}
    
function expectTreeMatches(SyntaxNode $expectedNode, SyntaxNode $actualNode) {
    expect(get_class($actualNode))->toEqual(get_class($expectedNode));
    expect(count($actualNode->children()))->toEqual(count($expectedNode->children()));

    if (!$expectedNode->hasChildren()) {
        expectLeafNodeMatches($expectedNode, $actualNode);
        return;
    }

    foreach ($expectedNode->children() as $index => $node) {
        expectTreeMatches($node, $actualNode->children()[$index]);
    }
}

test('it_can_parse_a_single_integer', function () {
    $tokenList = new TokenList([
        new Token(
            type: TokenType::Integer,
            value: '123',
        )
    ]);

    $parser = new Parser();

    $ast = $parser->parse($tokenList);

    expectTreeMatches(
        new Integer(123),
        $ast
    );
});

test('it_can_parse_a_simple_add_statement', function () {
    $tokenList = new TokenList([
        new Token(type: TokenType::Integer, value: '1'),
        new Token(type: TokenType::Operator, value: '+'),
        new Token(type: TokenType::Integer, value: '1'),
    ]);

    $parser = new Parser();

    $ast = $parser->parse($tokenList);

    expectTreeMatches(
        new AddOperation(
            new Integer(1),
            new Integer(1),
        ),
        $ast
    );
});

test('it_can_parse_two_connected_add_statements', function () {
    $tokenList = new TokenList([
        new Token(type: TokenType::Integer, value: '1'),
        new Token(type: TokenType::Operator, value: '+'),
        new Token(type: TokenType::Integer, value: '2'),
        new Token(type: TokenType::Operator, value: '+'),
        new Token(type: TokenType::Integer, value: '3'),
    ]);

    $parser = new Parser();

    $ast = $parser->parse($tokenList);

    expectTreeMatches(
        new AddOperation(
            new Integer(1),
            new AddOperation(
                new Integer(2),
                new Integer(3)
            )
        ),
        $ast
    );
});

test('it_can_parse_a_print_call_on_an_integer', function () {
    $tokenList = new TokenList([
        new Token(type: TokenType::Integer, value: '1'),
        new Token(type: TokenType::Operator, value: '->'),
        new Token(type: TokenType::Keyword, value: 'print'),
    ]);

    $parser = new Parser();

    $ast = $parser->parse($tokenList);

    expectTreeMatches(
        new FunctionCall(
            name: 'print',
            argument: new Integer(1)
        ),
        $ast
    );
});
