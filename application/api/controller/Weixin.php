<?php
namespace app\api\controller;
use think\Controller;
use app\service\WechatService as wechat;
// 公众号接口 调用服务层service/wechat demo
class Weixin extends Controller {

    // 公众号绑定
    public function mpbind() {
        $WechatService = new wechat();
        $WechatService->mpbind();
        // $response = [
        //     'ToUserName'=>'尊敬的客户',
        //     'FromUserName'=>'woo',
        //     'CreateTime'=>time(),
        //     'MsgType'=>'text',
        //     'Content'=>'您的信息已收到,稍后将会回复您(骚扰信息除外)'
        // ];
        // return xml($response);
    }

    public function getmenu() {
        $WechatService = new wechat();
        dump( $WechatService->getmenu() );
    }




    public function share() {
        $url = getdomain();
        $WechatService = new wechat();
        $jsapi = $WechatService->jsapi($url);
        return $this->fetch('share', ['jsapi' => $jsapi, 'url' => $url]);
    }
}