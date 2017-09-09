<?php

namespace app\api\controller;

use app\service\Wechat;
use app\api\controller\Base;
use app\service\TokenService;

class Frontend extends Base{




  public function _initialize() {  	

      parent::_initialize();
      $is_login = cookie('member');
      $this->memberInfo = session('memberInfo','','think');
  	   if(($is_login!=md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'))||!$is_login||!$this->memberInfo){

    		  $this->checklogin();
    	}
  }
 

  public function checklogin(){ 

    // return json(['code'=>200,'msg'=>'请先登录']);die;
    $this->redirect('index/noLogin');die;
  }

}