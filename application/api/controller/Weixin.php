<?php
namespace app\api\controller;
use app\service\WechatService;
use think\Controller;

// 公众号接口 调用服务层service/wechat
class Weixin extends Controller {

    // 公众号绑定
    public function mpbind() {
        $WechatService = new WechatService();
        $WechatService->mpbind();
    }
}