<?php

go(function () {
    $ret = [];

    $wait = new \Swoole\Coroutine\WaitGroup();

    $wait->add();
    // 启动第 1 个协程
    go(function () use ($wait, &$ret) {
        // 模拟耗时任务 1
        \co::sleep(0.1);
        $ret[] = time();
        $wait->done();
    });

    $wait->add();
    // 启动第 2 个协程
    go(function () use ($wait, &$ret) {
        // 模拟耗时任务 2
        \co::sleep(2);
        $ret[] = time();
        $wait->done();
    });

    // 挂起当前协程，等待所有任务完成后恢复
    $wait->wait();

    // 这里 $ret 包含了 2 个任务执行结果
    var_dump($ret);
});