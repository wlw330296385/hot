<?php
namespace app\dev\controller;
use think\Controller;
use app\service\WechatService;

// 公众号接口 调用服务层service/wechat demo
class Weixin extends Controller {

    // 公众号绑定
    public function mpbind() {
        $WechatService = new wechat();
        $WechatService->mpbind();
    }

    public function getmenu() {
        $WechatService = new wechat();
        dump( $WechatService->getmenu() );
    }

    public function setmenu() {
        $WechatService = new wechat();
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
        $wechatS = new WechatService();
        $userinfo = $wechatS->oauthUserinfo();
        if ($userinfo) {
            dump($userinfo);

            $member = [
                'id' => 0,
                'openid' => $userinfo['openid'],
                'member' => $userinfo['nickname'],
                'nickname' => $userinfo['nickname'],
                //'avatar' => strtr($userinfo['headimgurl'], 'http://', 'https://'),
                'avatar' => str_replace("http://", "https://", $userinfo['headimgurl']),
                'hp' => 0,
                'level' => 0,
                'telephone' =>'',
                'email' =>'',
                'realname'  =>'',
                'province'  =>'',
                'city'  =>'',
                'area'  =>'',
                'location'  =>'',
                'sex'   =>0,
                'height'    =>0,
                'weight'    =>0,
                'charater'  =>'',
                'shoe_code' =>0,
                'birthday'  =>'0000-00-00',
                'create_time'=>0,
                'pid'   =>0,
                'hp'    =>0,
                'cert_id'   =>0,
                'score' =>0,
                'flow'  =>0,
                'balance'   =>0,
                'remarks'   =>0,

            ];
            dump($member);
        }
    }

    public function index() {
        $wechatS = new WechatService();
        $callback = url('dev/weixin/user', '', '', true);
        $url = $wechatS->oauthredirect($callback);
        dump($url);
    }

    public function share() {
        $url = getdomain();
        $WechatService = new wechat();
        $jsapi = $WechatService->jsapi($url);
        return $this->fetch('share', ['jsapi' => $jsapi, 'url' => $url]);
    }
}