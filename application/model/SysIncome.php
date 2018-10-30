<?php 
namespace app\model;
use think\Model;
class SysIncome extends Model {
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];


	public function getTypeAttr($value){
		$list = [0=>'未知',1=>'课时版订单收入',2=>'营业额版训练营提现收入',3=>"课时版赠课收入",4=>"个人平台充值收入"];
		return $list[$value];
	}

}