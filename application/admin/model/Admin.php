<?php
namespace app\admin\model;
use think\Model;

class Admin extends Model {




	public function adminGroup(){
		return $this->hasOne('adminGroup','id','group_id');
	}
}