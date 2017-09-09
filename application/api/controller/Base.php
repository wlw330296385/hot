<?php

namespace app\api\controller;

use app\service\Wechat;
use think\Controller;
use app\service\TokenService;

class Base extends Controller{

 

 	public $memberInfo;


  public function _initialize() {  	

      $this->gettoken();
  }
  public function gettoken(){

     $TokenService = new TokenService;

     $visits = $TokenService->visitTimes();

     if(!$visits){
         $this->checklogin();
     }       

 }

  public function checklogin(){ 

    // return json(['code'=>200,'msg'=>'请先登录']);die;
    $this->redirect('index/noLogin');die;
  }

}