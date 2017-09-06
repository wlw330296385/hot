<?php
namespace app\dev\controller;
use app\service\WechatService;
use think\Controller;

// 公众号接口 调用服务层service/wechat demo
class Weixin extends Controller {

    // 公众号绑定
    public function mpbind() {
        $WechatService = new WechatService();
        $WechatService->mpbind();
    }

    public function getmenu() {
        $WechatService = new WechatService();
        dump( $WechatService->getmenu() );
    }

    public function setmenu() {
        $WechatService = new WechatService();
        $menuData = [
            'button' => [
                [
                    'name' => '按钮1',
                    'type' => 'click',
                    'key' => 'this is a button'
                ],
                [
                    'name' => '菜单',
                    'sub_button' => [
                        [
                            'type' => 'view',
                            'name' => '会员登录',
                            'url' => $WechatService->oauthRedirect(url('Weixin/user', '', '', true))
                        ],
                        [
                            'type' => 'view',
                            'name' => '首页',
                            'url' => url('Weixin/index', '', '', true)
                        ],
                        [
                            'type' => 'view',
                            'name' => '分享',
                            'url' => url('Weixin/share', '', '', true)
                        ]
                    ]
                ]
            ]
        ];
        dump($menuData);
        dump( $WechatService->setmenu($menuData) );
    }

    public function user() {
        $WechatService = new WechatService();
        dump( $WechatService->oauthUserinfo() );
        //echo 'user';
    }

    public function index() {
        $WechatService = new WechatService();
        // 全局access_token
        dump ( $WechatService->authactoken() );
    }

    public function share() {
        $url = getdomain();
        $WechatService = new WechatService();
        $jsapi = $WechatService->jsapi($url);
        return $this->fetch('share', ['jsapi' => $jsapi, 'url' => $url]);
    }
}