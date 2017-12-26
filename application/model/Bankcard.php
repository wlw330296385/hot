<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Bankcard extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	
    public function getBankTypeAttr($value){
        $status = [0=>'未知',1=>'银行卡',2=>'支付宝',];
        return $status[$value];
    }
}