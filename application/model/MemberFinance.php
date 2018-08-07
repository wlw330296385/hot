<?php
// 训练营财务支出收入model
namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class MemberFinance extends Model {
    protected $autoWriteTimestamp = true;

    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // public function getTypeAttr($value){
    // 	$list = [-2=>'余额转热币',-1=>'提现支出',1=>'工资收入(包括人头提成)',2=>'充值'];
    // 	return $list[$value];
    // }
}