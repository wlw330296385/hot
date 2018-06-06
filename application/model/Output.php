<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Output extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];



	public function getTypeAttr($value){
		$list = [1=>'赠课',2=>'课时退费',-1=>'提现',3=>'课时教练支出',4=>'平台分成',-2=>'其他支出'];
		return $list[$value];
	}	
}