<?php

namespace EasySwoole\EasySwoole;

use App\Crontab\CustomCrontab;
use EasySwoole\Component\Process\Manager;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\Component\Di;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use App\Crontab\SecondCrontab;
use EasySwoole\EasySwoole\Crontab\Crontab;

class EasySwooleEvent implements Event
{
    public static function initialize()
    {
        // ================ 框架初始化事件 =================

//        开发者可以在 initialize 事件可以进行如下修改：
//        1、修改框架默认使用的 error_report 级别，使用自定义的 error_report 级别
//        2、修改框架默认使用的 Logger 处理器，使用自定义的 Logger 处理器
//        3、修改框架默认使用的 Trigger 处理器，使用自定义的 Trigger 处理器
//        4、修改框架默认使用的 Error 处理器，使用自定义的 Error 处理器
//        5、修改框架默认使用的 Shutdown 处理器，使用自定义的 Shutdown 处理器
//        6、修改框架默认使用的 HttpException 全局处理器，使用自定义的 HttpException 全局处理器
//        7、设置 Http 全局 OnRequest 及 AfterRequest 事件
//        8、注册数据库、Redis 连接池

        // 实现 onRequest 事件
        Di::getInstance()->set(SysConst::HTTP_GLOBAL_ON_REQUEST, function (Request $request, Response $response): bool {
                ###### 处理请求的跨域问题 ######
                $response->withHeader('Access-Control-Allow-Origin', '*');
                $response->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
                $response->withHeader('Access-Control-Allow-Credentials', 'true');
                $response->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
                if ($request->getMethod() === 'OPTIONS') {
                    $response->withStatus(\EasySwoole\Http\Message\Status::CODE_OK);
                    return false;
                }

                return true;
            });

    }

    public static function mainServerCreate(EventRegister $register)
    {
        ###### 注册一个定时任务 ######
        // 配置定时任务
        $crontabConfig = new \EasySwoole\Crontab\Config();

        // 1.设置执行定时任务的 socket 服务的 socket 文件存放的位置，默认值为 当前文件所在目录
        // 这里设置为框架的 Temp 目录
        $crontabConfig->setTempDir(EASYSWOOLE_TEMP_DIR);

        // 2.设置执行定时任务的 socket 服务的名称，默认值为 'EasySwoole'
        $crontabConfig->setServerName('EasySwoole');

        // 3.设置用来执行定时任务的 worker 进程数，默认值为 3
        $crontabConfig->setWorkerNum(3);

        // 4.设置定时任务执行出现异常的异常捕获回调
        $crontabConfig->setOnException(function (\Throwable $throwable) {
            // 定时任务执行发生异常时触发（如果未在定时任务类的 onException 中进行捕获异常则会触发此异常回调）
        });

        // 5、创建定时任务实例
        $crontab = Crontab::getInstance($crontabConfig);

        // 6、注册定时任务
        $crontab->register(new CustomCrontab());


        ###### 注册秒级定时任务 ######
        $process = new SecondCrontab(new \EasySwoole\Component\Process\Config([
            'enableCoroutine' => true
        ]));
        Manager::getInstance()->addProcess($process);

    }

}