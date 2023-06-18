<?php

namespace Nerp;

enum TokenType
{
    case BadToken;
    case EndOfFile;
    case Integer;
    case Operator;
    case Whitespace;
}
