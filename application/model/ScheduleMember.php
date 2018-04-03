<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class ScheduleMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
//    protected $readonly = [
//                            'create_time',
//                            'status',
//                            'type',
//                            ];

    public function getScheduleTimeAttr($value){
        return date('Y-m-d H:i',$value);
    }

    // 关联member
    public function member(){
    	return $this->hasOne('member','id','member_id',[],'left join');
    }


    // 关联班级
    public function grade(){
    	return $this->hasOne('grade','id','grade_id',[],'LEFT JOIN');
    }

    // 关联班级
    public function schedule(){
        return $this->hasOne('schedule','id','schedule_id',[],'LEFT JOIN');
    }
}