<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $ress = db('student')->where(['id'=>1])->inc('total_lesson',1)->inc('total_schedule',2)->update();
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
