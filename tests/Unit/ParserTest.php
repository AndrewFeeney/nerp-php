<?php

use Nerp\SyntaxNode;
use Nerp\SyntaxNodeTypes\Integer;
use Nerp\SyntaxNodeTypes\AddOperation;
use Nerp\SyntaxNodeTypes\FunctionCall;
use Nerp\SyntaxNodeTypes\Message;
use Nerp\SyntaxNodeTypes\Variable;
use Nerp\Parser;
use Nerp\System;
use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenTypes\EndOfFile;
use Nerp\TokenTypes\Identifier;
use Nerp\TokenTypes\Operator;
use Nerp\TokenTypes\Integer as IntegerTokenType;
use Nerp\TokenTypes\ParenthesesOpen;
use Nerp\TokenTypes\ParenthesesClose;

function expectLeafNodeMatches(SyntaxNode $expectedNode, SyntaxNode $actualNode) {
    $system = new System();

    expect($actualNode->evaluate($system))->toEqual($expectedNode->evaluate($system));
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
        new Token(type: new IntegerTokenType(), value: '123'),
        new Token(type: new EndOfFile()),
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
        new Token(type: new IntegerTokenType(), value: '1'),
        new Token(type: new Operator(), value: '+'),
        new Token(type: new IntegerTokenType(), value: '1'),
        new Token(type: new EndOfFile()),
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
        new Token(type: new IntegerTokenType(), value: '1'),
        new Token(type: new Operator(), value: '+'),
        new Token(type: new IntegerTokenType(), value: '2'),
        new Token(type: new Operator(), value: '+'),
        new Token(type: new IntegerTokenType(), value: '3'),
        new Token(type: new EndOfFile()),
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

test('it_can_parse_a_system_print_call_with_an_integer_as_a_parameter', function () {
    $tokenList = new TokenList([
        new Token(type: new Identifier(), value: '$system'),
        new Token(type: new Operator(), value: '.'),
        new Token(type: new Identifier(), value: 'print'),
        new Token(type: new ParenthesesOpen(), value: '('),
        new Token(type: new IntegerTokenType(), value: '1'),
        new Token(type: new ParenthesesClose(), value: ')'),
        new Token(type: new EndOfFile()),
    ]);

    $parser = new Parser();

    $ast = $parser->parse($tokenList);

    expectTreeMatches(
        new Message(
            name: 'print',
            target: new Variable('$system'),
            argument: new Integer(1),
        ),
        $ast
    );
});
