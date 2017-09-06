<?php
namespace app\model;
use think\Model;

class Court extends Model {


	public function getOutdoorAttr($value){
		$outdoor = [0=>'室内',1=>'室外',2=>'室内|室外'];
	}
    public function getStatusAttr($value){
		$status = [-1=>'已拒绝',0=>'待审核',1=>'系统'];
		return $status[$value];
    }
}