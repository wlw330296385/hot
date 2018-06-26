<?php
// 训练营财务支出收入model
namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class CampFinance extends Model {
    protected $autoWriteTimestamp = true;

    use SoftDelete;
    protected $deleteTime = 'delete_time';

    public function getTypeAttr($value){
    	$list = [-4=>'提现',-3=>'订单退费',-2=>'赠课支出',-1=>'教练工资支出',1=>'课程订单收入',2=>'活动订单收入',3=>'课时收入',4=>'提现退回',5=>'退款收入',6=>'剔除学生收入'];
    	return $list[$value];
    }
}