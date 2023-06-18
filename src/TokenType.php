<?php

namespace Nerp;

enum TokenType
{
    case BadToken;
    case EndOfFile;
    case Integer;
    case Whitespace;
}
