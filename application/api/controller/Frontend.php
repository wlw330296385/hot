<?php

namespace app\api\controller;

use app\service\Wechat;
use app\api\controller\Base;
use app\service\TokenService;

class Frontend extends Base{

    public function _initialize() {
          parent::_initialize();
          /*$is_login = cookie('member');
          $this->memberInfo = session('memberInfo','','think');
           if(($is_login!=md5($this->memberInfo['id'].$this->memberInfo['member'].'hot'))||!$is_login||!$this->memberInfo){
                  $this->checklogin();
            }*/
        // 检测会员登录
        $this->memberInfo = session('memberInfo', '', 'think');
        $member_cookie = cookie('member');
        if ( $member_cookie!= md5($this->memberInfo['id'].$this->memberInfo['member'].config('salekey')) || !cookie('mid') || !$this->memberInfo ) {
            $this->checklogin();
        }

    }
}