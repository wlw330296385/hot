<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Grade extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            ];


    public function getStatusAttr($value){
    	$status = [-1=>'预排班级',1=>'当前班级', 2 => '下架班级'];
    	return $status[$value];
    }


    public function member(){
    	return $this->hasOne('member','id','member_id',[],'left join');
    }

    public function student(){
        return $this->hasMany('student','grade_id','member_id',[],'left join');
    }


    
    public function gradeMember(){
        return $this->hasMany('grade_member','grade_id');
    }
}