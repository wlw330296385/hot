<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class CampWithdraw extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	
    public function getTypeAttr($value){
        $status = [1=>'银行卡',2=>'支付宝',];
        return $status[$value];
    }
}