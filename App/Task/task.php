<?php

// go 函数是 swoole 的开启协程函数，用于开启一个协程
$pid1 = go('task1');
$pid2 = go('task2');
$pid3 = go('task3');

function task1()
{
    for ($i = 0; $i <= 300; $i++) {
        // 写入文件，大概要 3000 微秒
        usleep(3000);
        echo "写入文件{$i}\n";

        // 挂起当前协程，0.001 秒后恢复 // 相当于切换协程
        Co::sleep(0.001);
    }
}

function task2()
{
    for ($i = 0; $i <= 500; $i++) {
        // 发送邮件给 500 名会员，大概 3000 微秒
        usleep(3000);
        echo "发送邮件{$i}\n";

        // 挂起当前协程，0.001 秒后恢复 // 相当于切换协程
        Co::sleep(0.001);
    }
}

function task3()
{
    for ($i = 0; $i <= 100; $i++) {
        // 模拟插入 100 条数据，大概 3000 微秒
        usleep(3000);
        echo "插入数据{$i}\n";

        // 挂起当前协程，0.001 秒后恢复 // 相当于切换协程
        Co::sleep(0.001);
    }
}