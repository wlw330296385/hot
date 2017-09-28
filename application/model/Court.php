<?php
namespace app\model;
use think\Model;

class Court extends Model {


	public function getOutdoorsAttr($value){
		$outdoor = [0=>'室内',1=>'室外',2=>'室内|室外'];
		return $outdoor[$value];
	}
    public function getStatusAttr($value){
		$status = [-1=>'已拒绝',0=>'待审核',1=>'审核通过'];
		return $status[$value];
    }

    public function court_camp(){
        return $this->hasOne('court_camp','id','camp_id');
    }
}