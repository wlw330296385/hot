<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class LessonMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            ];


    public function getStatusAttr($value){
        $status = [0=>'待审核',1=>'正常',2=>'退出',3=>'被开除',4=>'已毕业','-1' => '离营'];
        return $status[$value];
    }

    public function getTypeAttr($value){
        $type = [1=>'正式生',2=>'体验生'];
         return $type[$value];
    }
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