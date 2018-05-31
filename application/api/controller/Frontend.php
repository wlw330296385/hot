<?php

namespace app\api\controller;

use app\service\Wechat;
use app\api\controller\Base;
use app\service\TokenService;
use think\Exception;

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

    // 刷新表单__token__
    public function reloadtoken() {
        try {
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => request()->token()]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    public function checklogin(){
        return json(['code' => 100, 'msg' => '请先登录']);
    }
}