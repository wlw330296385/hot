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



}