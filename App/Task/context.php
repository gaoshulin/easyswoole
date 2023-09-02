<?php

use EasySwoole\Component\Context\ContextManager;
use EasySwoole\Component\Context\ContextItemHandlerInterface;

class Handler implements ContextItemHandlerInterface
{
    function onContextCreate()
    {
        $class = new \stdClass();
        $class->time = time();
        return $class;
    }

    function onDestroy($context)
    {
        var_dump($context);
    }
}

ContextManager::getInstance()->registerItemHandler('key', new Handler());

go(function () {
    go(function () {
        ContextManager::getInstance()->get('key');
    });

    \co::sleep(1);
    ContextManager::getInstance()->get('key');
});