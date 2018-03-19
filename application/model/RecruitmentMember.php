<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class RecruitmentMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'status',
                            ];


    public function getStatusAttr($value){
        $status = [1=>'申请中',2=>'正常',3=>'被拒绝'];
        return $status[$value];
    }

    public function member(){
        return $this->hasOne('member','id','member_id');
    }
}