<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
class Frontend extends Base{
	public $memberInfo;
	public function _initialize(){
		parent::_initialize();
		$this->memberInfo = session('memberInfo','','think');
		if(!$this->memberInfo['avatar']){
			$this->nologin();
		}else{
			$re = session('memberInfo',$this->memberInfo);
			$this->assign('memberInfo',$this->memberInfo);
		}	
	}

	protected function wxlogin($id){
		$member =new \app\service\MemberService;
    	$memberInfo = $member->getMemberInfo(['id'=>$id]);
    	unset($memberInfo['password']);
    	$this->memberInfo = $memberInfo;
    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
    	cookie('member',md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'));  	
        $result = session('memberInfo',$memberInfo,'think');
        if($result){
        	return true;
        }else{
        	return false;
        }      
	}


	protected function nologin(){
		$this->redirect('login/login');
	}

	
}
