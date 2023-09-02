<?php

namespace App\Crontab;

use EasySwoole\Component\Process\AbstractProcess;

/**
 * 秒级定时任务类
 */
class SecondCrontab extends AbstractProcess
{
    protected function run($arg)
    {
        while (1) {
            // to do something

            var_dump(date('Y-m-d H:i:s'));

            \Co::sleep(1);
        }
    }
}