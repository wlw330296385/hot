<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\LessonService;
class Index extends Base{
	protected $LessonService;
	public function _initialize(){
		parent::_initialize();
		$this->LessonService = new LessonService;
	}

	public function noLogin(){
		return json(['code'=>100,'msg'=>'请重新登录']);die;
	}

	public function defendActivated(){
	 
	     return json('非法操作,请5分钟后重试');die;
	  }


	public function getSesson(){
		if(6!= session('memberInfo.id','','think')){
            return json(['code'=>100,'msg'=>'不是您的订单不能申请退款,谢谢']);
        }else{
        	dump(session('memberInfo.id','','think'));
        }
	}
}
