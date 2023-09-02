<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\AbstractRouter;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use FastRoute\RouteCollector;

class Router extends AbstractRouter
{
    function initialize(RouteCollector $routeCollector)
    {
        // 路由规则：
        // 将匹配 App\HttpController\Index 类的 index 方法
        $routeCollector->get('/', '/index');
        // 将匹配 App\HttpController\Index 类的 test 方法
        $routeCollector->get('/test', '/Index/test');
        $routeCollector->get('/demo', '/Index/demo');
        $routeCollector->get('/param', '/Index/getParams');
        $routeCollector->get('/download', '/Index/download');


        // 将匹配 App\HttpController\Test 类的 index 方法
        $routeCollector->get('/test-index', '/Test/index');
         // 将匹配 App\HttpController\Test 类的 test 方法
        $routeCollector->get('/test-test', '/Test/test');


        /*
         * eg path : /closure/index.html  ; /closure/ ;  /closure
         */
        $routeCollector->get('/closure',function (Request $request,Response $response){
            $response->write('this is closure router');
            //不再进入控制器解析
            return false;
        });
    }
}