<?php

namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\WechatService;

class Wechat extends Backend {

    public function menu() {
        $WechatS = new WechatService();
        if (request()->isPut()) {
            // 参考dev/wexin/setmenu
        }
        $menu = $WechatS->getmenu();
        //dump($menu);

        $breadcrumb = ['title' => '菜单管理', 'ptitle' => '微信管理'];
        $this->assign('breadcrumb', $breadcrumb);
        return view();
    }
}