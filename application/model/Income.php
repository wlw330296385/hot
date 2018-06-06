<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Income extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function getTypeAttr($value){
		$list = [1=>'课程订单收入',2=>'活动订单收入',3=>'课时收入',4=>'充值',5=>'退款收入'];
		return $list[$value];
	}	
}