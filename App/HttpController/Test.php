<?php

namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;

class Test extends Controller
{
    public function index()
    {
        $this->response()->write('this is Test/index');

    }

    public function test()
    {
        $this->response()->write('this is Test/test');

    }
}