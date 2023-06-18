<?php

namespace Nerp;

enum TokenType: string
{
    case BadToken = 'BAD_TOKEN';
    case EndOfFile = 'END_OF_FILE';
    case Integer = 'INTEGER';
    case Keyword = 'KEYWORD';
    case Operator = 'OPERATOR';
    case Whitespace = 'WHITESPACE';
}
