<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class GradeMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'status',
                            'type',
                            ];


    // 关联训练营
    public function camp(){
    	return $this->hasOne('camp','id','camp_id',[],'left join');
    }


    // 关联member
    public function member(){
    	return $this->hasOne('member','id','member_id',[],'left join');
    }


    // 关联班级
    public function grade(){
    	return $this->hasOne('grade','id','grade_id',[],'left join');
    }


    // 关联??多对多???
    public function coach(){
    	return $this->belongsToMany('coach','grade_member','coach_id','');
    }

    // 关联学生
    public function student(){
    	return $this->hasOne('student','id','student_id',[],'left join');
    }
}