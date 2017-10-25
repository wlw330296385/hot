<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
    	return view('Index/index');
    }

    public function wxbind() {
        $WeixinService = new Weixin();
        $WeixinService->mpbind();
    }

    public function test(){
    	return view('Index/test');
    }
}
