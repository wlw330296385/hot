<?php

namespace app\service;

use app\model\Schedule;
use think\Db;
use app\common\validate\ScheduleVal;
class ScheduleService {

	protected $scheduleModel;

	public function __construct(){
		$this->scheduleModel = new Schedule;
	}


    // 获取课时数据列表
	public function getscheduleList($map=[], $order='', $p='10'){
		$result = Schedule::where($map)->order($order)->paginate($p)->toArray();
		return $result?$result['data']:false;
	}

	// 发布课时
	public function pubSchedule($data){
		// 查询权限
		$is_power = $this->scheduleModel
                    ->where([
                        'camp_id'   =>$data['camp_id'],
                        'grade_id'	=>$data['geade_id'],
                        'lesson_id'	=>$data['lesson_id'],
                        'status'    =>1,
                        'member_id'  =>$data['member_id'],
                        'type'      =>['in','2,3,4,6,7']
                        ])
                    ->find()
                    ->toArray();
        if(!$is_power){
            return ['code'=>200,'msg'=>'权限不足'];
        }            
		$result = $this->scheduleModel->validate('scheduleVal')->data($data)->save();
		if($result ===false){
			return ['msg'=>$this->scheduleModel->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}
	}

	//查看一条课时信息
	public function getScheduleInfo($map){
		$result = $this->scheduleModel->where($map)->find();
		return $result?$result->toArray():false;
	}

	// 统计课时数量
	public function countSchedules($map){
		$result = $this->scheduleModel->where($map)->count();
		return $result?$result:0;
	}

	// 获得课时评论
	public function getCommentList($schedule_id){
		$result = db('schedule_comment')->where(['schedule_id'=>$schedule_id])->select();		
		return $result;
	}

	// 获取课时学生
	public function getStudentList($schedule_id){
		$result = db('schedule_member')->where(['schedule_id'=>$schedule_id,'type'=>0,'status'=>1])->select();
		return $result;
	}
}