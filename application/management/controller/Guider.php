<?php 
namespace app\management\controller;
use app\management\controller\Base;


/**
* 引导页
*/
class Guider extends Base
{
	
	function _initialize()
	{
		parent::_initialize();
	}



	public function choose(){
		$campList = db('camp_member')->where(['member_id'=>$this->memberInfo['id'],'status'=>1,'type'=>['egt',2]])->select();
		
		if(request()->isPost()){
			$key = input('post.key');
			$camp = $campList[$key];
			cache('camp',$camp['camp']);
			cache('camp_id',$camp['camp_id']);

			if($camp['type'] == '4'){
				//权限和菜单
				cache("power_{$this->memberInfo['id']}",4);
				$powerList = db('member_menu')->where(['status'=>1,'power_type'=>1,'power'=>['elt',4],'module'=>'management'])->order(['sort asc','id asc'])->select();
				$menuList = getTree($powerList,0);
				cache("powerList_".$this->memberInfo['id'],$powerList);
				cache("menuList_".$this->memberInfo['id'],$menuList);
				// 训练营信息
				session('camp_member',$camp);
			}elseif($camp['type'] == '3'){
				//权限和菜单
				$powerList = db('member_menu')->where(['status'=>1,'power_type'=>1,'power'=>['elt',3],'module'=>'management'])->order(['sort asc','id asc'])->select();
				$menuList = getTree($powerList,0);
				cache("powerList_".$this->memberInfo['id'],$powerList);
				cache("menuList_".$this->memberInfo['id'],$menuList);
				cache("power_{$this->memberInfo['id']}",3);
				// 训练营信息
				session('camp_member',$camp);
			}elseif($camp['type'] == '2'){
				//权限和菜单
				$powerList = db('member_menu')->where(['status'=>1,'power_type'=>2,'power'=>['elt',2],'module'=>'management'])->order(['sort asc','id asc'])->select();
				$menuList = getTree($powerList,0);
				cache("powerList_".$this->memberInfo['id'],$powerList);
				cache("menuList_".$this->memberInfo['id'],$menuList);
				cache("power_{$this->memberInfo['id']}",2);
				// 训练营信息
				session('camp_member',$camp);
				// dump($powerList);die;
			}
			header("Location:".url('Index/index'));
		}
		
		$this->assign('campList',$campList);
		return view('Guider/choose');	
	}
}