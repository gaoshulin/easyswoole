<?php

// 全局bootstrap事件
date_default_timezone_set('Asia/Shanghai');

use Swoole\Coroutine\Scheduler;
$scheduler = new Scheduler();
$scheduler->add(function() {
    /* 调用协程 API */
});
$scheduler->start();

// 清除全部定时器
\Swoole\Timer::clearAll();