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

	
    public function bank(){
        return $this->hasOne('camp_bankcard','id','bank_id',[],'left join');                 
    }

    public function getStatusAttr($status){
        $list = [-2=>'个人取消(解冻)',-1=>'拒绝(解冻)',1=>'申请中(冻结)',2=>'已同意(并解冻)',3=>'已打款'];
        return $list[$status];
    }

}