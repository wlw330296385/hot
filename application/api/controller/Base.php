<?php

namespace app\api\controller;


use think\Controller;
class Base extends Controller{

    public $defend = 0;
    public $memberInfo;


    public function _initialize() {
        $this->memberInfo = session('memberInfo','','think');
        // $this->gettoken();
    }

    // public function gettoken(){

    //     $TokenService = new TokenService;

    //     $visits = $TokenService->visitTimes();
    //     if(!$visits){
    //         $this->defend++;
    //     }

    //     // if($this->defend>1 && $this->defend<10){
    //     //     $this->checklogin();
    //     // }elseif ($this->defend > 10) {
    //     //     $this->redirect('index/defendActivated');
    //     // }

    // }

<<<<<<< HEAD
    public function checklogin(){
        return json(['code'=>100,'msg'=>'请重新登录']);
        redirect('frontend/login/login');
    }
=======
    // public function checklogin(){
    //     return json(['code'=>100,'msg'=>'请重新登录']);
    //     redirect('frontend/login/login');
    // }
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4

}