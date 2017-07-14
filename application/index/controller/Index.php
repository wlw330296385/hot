<?php
namespace app\index\controller;
use app\service\Weixin;

class Index
{
    public function index()
    {

    }

    public function wxbind() {
        $WeixinService = new Weixin();
        $WeixinService->mpbind();
    }
}
