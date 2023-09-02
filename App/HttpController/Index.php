<?php

namespace App\HttpController;

class Index extends Base
{
    public function index()
    {
        $file = EASYSWOOLE_ROOT . '/vendor/easyswoole/easyswoole/src/Resource/Http/welcome.html';
        if (!is_file($file)) {
            $file = EASYSWOOLE_ROOT . '/src/Resource/Http/welcome.html';
        }
        $this->response()->write(file_get_contents($file));
    }

    function test()
    {
        $this->response()->write('this is Index/test');
    }

    public function demo()
    {
        // 获取参数
        $name = $this->request()->getQueryParam('name');
        // 返回给客户端
        $this->response()->write($name . PHP_EOL);

        // return 返回的值会让框架在此进行控制器方法调度，将继续执行 requestTotal 方法 
        return '/Index/requestTotal';
    }

    public function requestTotal()
    {
        $this->response()->write('request counts +1' . PHP_EOL);

        // 还可以 return，但不要两个方法互相调用，会导致死循环
    }


    // request 和 response
    public function getParams()
    {
        // ========= Request 请求对象 ===============
        // 在控制器中 可以通过 $this->request() 获取到 Request 对象
        $request = $this->request();

        // 获取头部
        $header = $request->getHeaders();

        // 获取server
        $server = $request->getServerParams();

        // 获得 get 内容
        $get = $request->getQueryParams();

        // 获取 post 内容
        $post = $request->getParsedBody();

        // 获得 raw 内容 Content-Type 为 application/json, 获取json请求体内容
        $content = $request->getBody()->__toString();
        $rawArray = json_decode($content, true);


        // 获取 `POST` 或者 `GET` 提交的所有参数
        $data = $request->getRequestParam();
        // 获取 `POST` 或者 `GET` 提交的单个参数
        $name = $request->getRequestParam('name');
        // 获取 `POST` 或者 `GET` 提交的多个参数
        $mixData = $request->getRequestParam('name', 'age', 'gander');


        // 获取所有 cookie 信息
        $cookies = $request->getCookieParams();
        // 获取单个 cookie 信息
        $cookName = $request->getCookieParams('name');


        // 获取一个上传文件，返回的是一个 \EasySwoole\Http\Message\UploadFile 的对象
        $image = $request->getUploadedFile('img');

        // 获取全部上传文件返回包含 \EasySwoole\Http\Message\UploadFile 对象的数组
        $images = $request->getUploadedFiles();

        // 将数据挂载到当前请求对象 $request 上
        $this->request()->withAttribute('customKey', 'customVal');

        // 获取当前请求对象 $request 上的挂载数据
        $array = $this->request()->getAttributes();

        // 删除某个挂载的数据
        $this->request()->withoutAttribute('customKey');


        // ======== Response 对象 ===============
        $response = $this->response();

        // 向客户端响应字符串，需要指定编码
        $response->withHeader('Content-Type', 'text/html;charset=utf-8');
        $response->write('向客户端响应字符串');

        // 向客户端响应 json
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        $response->write(json_encode(['name' => 'easyswoole']));

        // 向客户端设置cookie
        $response->setCookie('customKey', 'customVal');

        // 向客户端发送 HTTP 状态码
        $this->response()->withStatus(200);

        // 将请求重定向到指定的 URL
        $response->redirect('/test');

        // 结束对该次 HTTP 请求响应，结束之后，无法再次向客户端响应数据。
        $response->end();
    }

    // 向客户端响应文件流，实现文件下载
    public function download()
    {
        // 要下载 excel 文件的指定路径，例如这里是项目根目录下的 test.xlsx 文件
        $this->response()->sendFile(EASYSWOOLE_ROOT . '/test.xlsx');

        // 设置文件流内容类型，这里以 xlsx 为例
        $this->response()->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        // 设置要下载的文件名称，一定要带文件类型后缀
        $this->response()->withHeader('Content-Disposition', 'attachment;filename=' . 'download_test.xlsx');
        $this->response()->withHeader('Cache-Control', 'max-age=0');
        $this->response()->end();
    }
}