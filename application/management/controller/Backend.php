<?php 
namespace app\management\controller;
use app\management\controller\Base;

/**
* 基本层
*/
class Backend extends Base
{
	public $power;
	public $camp_member;
	function _initialize()
	{
		parent::_initialize();

        $this->camp_member = session('camp_member');
		// 获取权限和菜单
		$power = cache("power_{$this->memberInfo['id']}");
		if($power){
			$this->power = $power;
		}else{
			$this->error('权限不足','Login/login');
		}
		
		if(!$this->checkAuth($power)){
			$this->error('权限不足,不可访问此页面');
		}
		// 获取面包屑
		$_location = $this->getLocation();
		$menuList = cache("menuList_{$this->memberInfo['id']}");
		$this->assign('camp_member',$this->camp_member);
		$this->assign('_sidebar_menus',$menuList);
		$this->assign('_location',$_location);
	}



 	private	function checkAuth($power){
 		// return [0=>['title'=>'开发者1','url_value'=>111],0=>['title'=>'开发者2','url_value'=>111]];
 		$c = request()->controller();
 		$a = request()->action();
 		$url_value = strtolower("$c/$a");
 		$powerList = cache("powerList_{$this->memberInfo['id']}"); 
 		foreach ($powerList as $key => $value) {
 			if($url_value == strtolower($value['url_value'])){
 				
 				return true;
 			}
 		}
		return false;
	}



	//获取面包屑地址
	private function getLocation(){
		$powerList = cache("powerList_{$this->memberInfo['id']}"); 
		$c = request()->controller();
 		$a = request()->action();
 		$url_value = strtolower("$c/$a");
 		foreach ($powerList as $key => $value) {
	 		if($url_value == strtolower($value['url_value'])){
				//获取面包屑地址
				$_location = [];
				$_location[1] = $value;
				foreach ($powerList as $k => $val) {
					if($val['id'] == $value['pid']){
						$_location[0] = $val;
					}
				}
				return $_location;
			}
		}
	}
}