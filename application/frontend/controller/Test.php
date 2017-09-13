<?php 
namespace app\frontend\controller;

class Test {

    public function index(){

        // $this->redirect('/frontend/index/index/pid/1');
        dump($url = $_SERVER["REQUEST_URI"]);
        // cookie(null);
        // session(null,'think');
        // $param = input('param.');
        // cache('param',$param);
        // cookie('param', $param);
        // dump($param);
        // dump($this->memberInfo);
        // session('memberInfo',['id'=>'0','openid'=>'o83291CzkRqonKdTVSJLGhYoU98Q','member'=>'woo'],'think');
        dump(session('memberInfo','','think'));
        // dump(cache('param'));
        // dump(cookie('param'));

        // $WechatService = new WechatService;
        // $callback1 = url('login/wxlogin','','', true);
        // $callback2 = url('login/wxlogin');
        // dump( $WechatService -> oauthredirect($callback1) );
        // dump( $WechatService -> oauthredirect($callback2) );

    }



}