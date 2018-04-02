<?php

namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\WechatService;

class Wechat extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    public function menu() {
        $WechatS = new WechatService();
        if (request()->isPut()) {
            // 参考dev/wexin/setmenu
        }
        $menu = $WechatS->getmenu();
        dump($menu);
        return view();
    }
}