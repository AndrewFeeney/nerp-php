<?php

namespace Nerp;

use Nerp\SyntaxNodeTypes\Message;

interface Messageable
{
    public function sendMessage(System $system, Message $message): mixed;
}