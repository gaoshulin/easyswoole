<?php

namespace App\Crontab;

use EasySwoole\Crontab\JobInterface;

/**
 * 定时任务类
 */
class CustomCrontab implements JobInterface
{
    public function jobName(): string
    {
        // 定时任务的名称
        return 'CustomCrontab';
    }

    public function crontabRule(): string
    {
        // 定义执行规则 根据 Crontab 来定义
        // 这里是每分钟执行 1 次
        return '*/1 * * * *';
    }

    public function run()
    {
        // 定义定时任务执行的逻辑

        var_dump(time());
        return time();
    }

    public function onException(\Throwable $throwable)
    {
        // 捕获run方法内所抛出的异常
        throw $throwable;
    }
}