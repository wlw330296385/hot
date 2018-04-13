<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Refund extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];



    public function getRefundTypeAttr($value){
        $list = [1=>'平台原路退回',2=>'银行转账',3=>'现金退回',4=>'支付宝退款',5=>'微信退款',6=>'其他'];
        return $list[$value];
    }

    public function getStatusAttr($value){
        $list = [-2=>'已撤销',-1=>'已拒绝',1=>'申请中',2=>'已同意',3=>'已打款'];
        return $list[$value];
    }


    public function bill() {
        return $this->hasOne('bill','id','bill_id');
    }

    public function student() {
        return $this->hasOne('student','id','student_id');
    }
}