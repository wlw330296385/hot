<?php
namespace app\index\controller;
use app\service\Weixin;

class Index
{
    public function index()
    {
    	echo 1;
    }

    public function wxbind() {
        $WeixinService = new Weixin();
        $WeixinService->mpbind();
    }
}
