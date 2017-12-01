<?php

namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\WechatService;
//use wechatsdk\TPwechat;

class Weixin extends Backend {

    public function menu() {
        if (request()->isPost()) {
            // 参考dev/wexin/setmenu
            $WechatS = new WechatService();
            $menuData = [
                'button' => [
                    [
                        'name' => '篮球管家',
                        'type' => 'view',
                        'url' => $WechatS->oauthRedirect(url('frontend/index/wxindex', '', '', true))
                    ]
                ]
            ];
            //dump($menuData);
            $res = $WechatS->setmenu($menuData);
            //dump($res);
            if ( $res ) {
                $this->success(__lang('MSG_200'), 'weixin/menu');
            } else {
                $this->error(__lang('MSG_400'));
            }
            exit();
        }
//        $WechatS = new WechatService();
//        $menu = $WechatS->getmenu();
        //dump($menu);

        /*$options = getMpOptions();
        $weObj = new TPwechat($options);
        $menu = $weObj->getMenu();
        dump($menu);*/

        $breadcrumb = ['title' => '菜单管理', 'ptitle' => '微信管理'];
        $this->assign('breadcrumb', $breadcrumb);
        return view('weixin/menu');
    }
}