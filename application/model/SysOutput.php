<?php 
namespace app\model;
use think\Model;
class SysOutput extends Model {
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function getTypeAttr($value){
		$list = [0=>'未知',1=>'课时教练支出',2=>'训练营课时支出',3=>'退款支出',4=>'训练营提现支出'];
		return $list[$value];
	}
}