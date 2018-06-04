<?php 
namespace app\api\controller;
use app\api\controller\Base;
class Charge extends Frontend{
	public function _initialize(){
		parent::_initialize();
	}

    //充值Api
    public function ChargeApi(){
        $member = $this->memberInfo['member'];
        $member_id = $this->memberInfo['id'];

    }
    
    
    
}