<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Plan extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'students',
                            ];


    public function getStatusAttr($value){
    	$status = [0=>'未审核',1=>'正常',2=>'拒绝'];
    	return $status[$value];
    }


    public function member(){
    	return $this->hasOne('member','id','member_id',[],'left join');
    }

    
}