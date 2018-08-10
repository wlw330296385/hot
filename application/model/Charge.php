<?php
namespace app\model;
use think\Model;

class Charge extends Model {


	public function getTypeAttr($value){
		$list = [1=>'余额充值',2=>'热币充值',3=>'训练营余额充值'];
		return $list[$value];
	}


	public function getStatusAttr($value){
		$list = [-1=>'充值失败',1=>'充值成功'];
		return $list[$value];
	}
}