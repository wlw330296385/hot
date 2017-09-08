<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\WechatService;
class Frontend extends Base{
	
	public function _initialize(){
		parent::_initialize();
		$this->memberInfo = session('memberInfo','','think');
		$param = input('param.');
		cache('param',$param);
		cookie('param', $param);
		if(!$this->memberInfo['member']){
			$this->nologin();
		}else{
			$re = session('memberInfo',$this->memberInfo);
			$this->assign('memberInfo',$this->memberInfo);
		}	
	}

	// protected function wxlogin($id){
	// 	$member =new \app\service\MemberService;
 //    	$memberInfo = $member->getMemberInfo(['id'=>$id]);
 //    	unset($memberInfo['password']);
 //    	$this->memberInfo = $memberInfo;
 //    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
 //    	cookie('member',md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'));  	
 //        $result = session('memberInfo',$memberInfo,'think');
 //        if($result){
 //        	return true;
 //        }else{
 //        	return false;
 //        }      
	// }


	protected function nologin(){
		$result = $this->is_weixin();
		
		if($result){
			$WechatService = new WechatService;
			$callback = url('login/wxlogin','','', true);
			$this->redirect($WechatService -> oauthredirect($callback));
		}else{
			$this->redirect('login/login');
		}
	}

	

	// 判断是否是微信浏览器
	function is_weixin() { 
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
	        return true; 
	    } return false; 
	}
}
