<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Coach extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'student_flow',
                            'kps',
                            'lesson_flow',
                            'coach_rank',
                            'coach_level'
                            ];


    public function getStatusAttr($value){
    	$status = [-1=>'禁用',0=>'待审核',1=>'审核通过',2=>'审核不通过'];
    	return $status[$value];
    }


    public function member(){
    	return $this->hasOne('member','id','member_id',[],'left join');
    }

    
}