<?php

namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\WechatService;
//use wechatsdk\TPwechat;

class Weixin extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    public function menu() {
        if (request()->isPost()) {
            // 参考dev/wexin/setmenu
            $WechatS = new WechatService();
            /**
             * 菜单设置：
             * 链接页面 type=>view, url=>url('frontend/index/index', '', '', true)
             * 可参考：extend/wechatsdk/wechatapi.php 第1525行至1577行 function createMenu()注释
             */
            $menuData = [
                'button' => [
                    // 第一栏
                    [
                        'name' => '篮球管家',
                        'sub_button' => [
                            [
                                'type' => 'view',
                                'name' => '培训管家/学员',
                                'url' => $WechatS->oauthRedirect(url('frontend/index/wxindex', '', '', true))
                            ],
                            [
                                'type' => 'view',
                                'name' => '球队管家/球员',
                                'url' => $WechatS->oauthRedirect(url('keeper/index/wxindex', '', '', true))
                            ]
                        ]
                    ],
                    // 第一栏 end
                    // 第二栏
                    /*[
                        'name' => 'about us',
                        'sub_button' => [
                            [
                                'type' => 'view',
                                'name' => '公司简介',
                                'url' =>
                            ],
                            [
                                'type' => 'view',
                                'name' => '合作加盟',
                                'url' =>
                            ],
                            [
                                'type' => 'view',
                                'name' => '业务承接',
                                'url' =>
                            ]
                        ]
                    ]*/
                    // 第二栏 end
                ]
            ];
            //dump($menuData);
            $res = $WechatS->setmenu($menuData);

            if ( $res ) {
                $this->success(__lang('MSG_200'), 'weixin/menu');
            } else {
                $this->error(__lang('MSG_400'));
            }

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