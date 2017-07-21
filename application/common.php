<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 获取页面域名地址
function getdomain() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $url;
}

// 用户密码加密
function passwd($str) {
    return sha1(config('queue.salekey') . $str);
}


// 获取语言包
function __lang($name, $vars = [], $lang = '') {
    $Lang = new \think\Lang;
    $Lang::load(APP_PATH . '/lang/' . $Lang::detect() . '/msg.php');
    return $Lang::get($name, $vars, $lang);
}