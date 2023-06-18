<?php

use Nerp\SyntaxNode;
use Nerp\NodeTypes\Integer;
use Nerp\LiteralExpression;
use Nerp\BinaryExpression;
use Nerp\Parser;
use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenType;

function expectTreeMatches(SyntaxNode $expectedTree, $actualTree) {
    if ($expectedTree->hasChildren()) {
        foreach ($expectedTree->children() as $index => $node) {
            expectTreeMatches($node, $actualTree->children()[$index]);
        }
    } else {
        expect($actualTree->evaluate())->toEqual($expectedTree->evaluate());
    }
    
    expect(get_class($actualTree))->toEqual(get_class($expectedTree));
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
