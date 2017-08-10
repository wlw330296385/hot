<?php

namespace app\api\controller;

use app\service\Wechat;
use think\Controller;
use app\service\TokenService;

class Base extends Controller{

 

 	public $memberInfo;



  public function _initialize() {  	

      $this->gettoken();
      $is_login = cookie('member');
      $this->memberInfo = session('memberInfo','','think');
  	if(($is_login!=md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'))||!$is_login){

  		$this->checklogin();

  	}

  public function gettoken(){

 

     $TokenService = new TokenService;

     $visits = $TokenService->visitTimes();

     if(!$visits){
         $this->checklogin();

     }       

 }

  public function checklogin(){
    return json(['code'=>200,'msg'=>'请先登录']);die;
    // $this->redirect('frontend/index/index');
  }

}















  // token 闄愬埗

  public function gettoken(){



      $TokenService =new TokenService;

      $visits = $TokenService->visitTimes();

      // dump($visits);die;

      if(!$visits){

          // $this->error('闈炴硶鎿嶄綔');

          $this->checklogin();

      }       

  }





  public function checklogin(){



  	$this->redirect('api/index/index');

  }

}