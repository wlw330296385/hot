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
		$list = [-1=>'打卡支出',-2=>'转出成余额',-3=>'打赏支出',1=>'充值',2=>'余额转热币',3=>'获得打赏'];
		return $list[$value];
	}	
}