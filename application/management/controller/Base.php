<?php 
namespace app\management\controller;
use think\Controller;


/**
* 基本层
*/
class ClassName extends AnotherClass
{
	public $memberInfo;
	function _initialize()
	{
		$member_id = cookie('member_id');
		$memberInfo = cache('memberInfo');
		if(!$member_id ||!$memberInfo){
			$this->error('登陆过期,请先登录','Login/login');
		}else{
			if($member_id <> $memberInfo['id']){
				cookie('member_id',null);
				$this->error('登陆账号与服务器不一致,请重新登录','Login/login');
			}
			$this->memberInfo = $memberInfo;
		}
	}
}