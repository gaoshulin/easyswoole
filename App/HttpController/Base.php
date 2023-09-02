<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;

/**
 * 控制器基类
 */
class Base extends Controller
{
    /**
     * 所有控制器请求都会先经过该方法，如果此方法返回 false 则请求不继续往下执行
     *
     * @param string|null $action
     * @return bool|null
     */
    public function onRequest(?string $action): ?bool
    {
         // TODO: Change the autogenerated stub
        return parent::onRequest($action);
    }

    /**
     * 当控制器方法执行结束之后将调用该方法，可自行覆盖该方法实现数据回收等逻辑
     *
     * @param string|null $actionName
     */
    public function afterAction(?string $actionName): void
    {
         // TODO: Change the autogenerated stub
        parent::afterAction($actionName);
    }

    /**
     * 当请求方法未找到时，自动调用该方法
     *
     * @param string|null $action
     * @return void
     */
    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }

    /**
     * 此控制器抛异常时会执行此方法
     *
     * @param \Throwable $throwable
     * @throws \Throwable
     */
    public function onException(\Throwable $throwable): void
    {
         // TODO: Change the autogenerated stub
        $this->response()->withStatus(500);
        parent::onException($throwable);
    }    
}