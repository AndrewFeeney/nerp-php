<?php

namespace Nerp;

use Nerp\NodeTypes\Message;

interface Messageable
{
    public function sendMessage(System $system, Message $message): mixed;
}