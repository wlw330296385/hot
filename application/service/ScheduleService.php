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



	public function getscheduleList($map){
		$result = $this->scheduleModel->where($map)->select()->toArray();
		if($result ===false){
			return ['msg'=>__lang('MSG_201_DBNOTFOUND'),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}
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
	public function getScheduleInfo(){
		$result = $this->scheduleModel->where($map)->find();
		if($result ===false){
			return ['msg'=>__lang('MSG_201_DBNOTFOUND'),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}
	}
}