<?php 
namespace app\management\model;
use think\Model;

class MemberMenu extends Model {


	// 获取权限菜单
	public function getMenu(){

	}


	public function checkPower(){
		
	}

	public function adminGroup(){
		return $this->hasOne('adminGroup','id','group_id');
	}
}