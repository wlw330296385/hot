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
		$list = [0=>'未知',1=>'订单收入',2=>'课时提成收入',3=>'退款收入',4=>'训练营提现收入'];
		return $list[$value];
	}

}