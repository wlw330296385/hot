<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Referee extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            ];


    public function getStatusAttr($value){
    	$a = [-1=>'被禁用',1=>'正常',0=>'未审核',2=>'不通过'];
    	return $a[$value];
    }

    public function member(){
        return $this->hasOne('member','id','member_id',[],'left join');
    }
}