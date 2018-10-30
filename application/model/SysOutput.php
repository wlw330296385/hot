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
		$list = [0=>'未知',1=>'个人余额提现支出',2=>'课时版训练营余额提现支出',3=>'课时版训练营退费训练营支出',4=>'课时版训练营退费用户支出',5=>"课时版推荐提成"];
		return $list[$value];
	}
}