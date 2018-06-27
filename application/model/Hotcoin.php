<?php
// 私密课程可购买会员关系表model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class Hotcoin extends Model {
    protected $table="hotcoin_finance";
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    public function getTypeAttr($value){
		$list = [1=>'课程订单收入',2=>'活动订单收入',3=>'课时收入',4=>'充值',5=>'退款收入',6=>'剔除学生收入'];
		return $list[$value];
	}	
}