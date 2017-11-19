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
	public function getscheduleList($map=[],$page = 1,$p='10',$order='',$field = '*'){
		$res = Schedule::where($map)->field($field)->order($order)->page($page,$p)->select();
		if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
	}

	// 发布课时
	public function createSchedule($data){
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
        $validate = validate('ScheduleVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }            
		$result = $this->scheduleModel->save($data);
		if($result ===false){
			return ['msg'=>$this->scheduleModel->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}
	}

    // 修改课时
    public function updateSchedule($data,$id){
        // 查询权限
        $is_power = $this->scheduleModel
                    ->where([
                        'camp_id'   =>$data['camp_id'],
                        'grade_id'  =>$data['geade_id'],
                        'lesson_id' =>$data['lesson_id'],
                        'status'    =>1,
                        'member_id'  =>$data['member_id'],
                        'type'      =>['in','2,3,4,6,7']
                        ])
                    ->find()
                    ->toArray();
        if(!$is_power){
            return ['code'=>200,'msg'=>'权限不足'];
        }
        $validate = validate('ScheduleVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }            
        $result = $this->scheduleModel->save($data,$id);
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
	public function getCommentList($schedule_id,$page = 1,$paginate = 10){
		$result = db('schedule_comment')->where(['schedule_id'=>$schedule_id])->page($page,$paginate)->select();		
		return $result;
	}

	// 获取课时学生
	public function getStudentList($schedule_id,$page = 1,$paginate = 10){
		$result = db('schedule_member')->where(['schedule_id'=>$schedule_id,'type'=>0,'status'=>1])->page($page,$paginate)->select();
		return $result;
	}




	// 教练增加课流量并升级
	public function addScheduleLevel($coach_id){
		$result = db('coach')->where(['id'=>$coach_id])->setInc('lesson_flow');
		if($result){
			$System =  new SystemService();
        	$setting =$System->getSite();
        	$coachLevel = db('coach')->where(['id'=>$coach_id])->value('coach_level');
        	if($coachLevel>=$setting['coachlevel8']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}
        	if($coachLevel>=$setting['coachlevel7']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}
        	if($coachLevel>=$setting['coachlevel6']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}
        	if($coachLevel>=$setting['coachlevel5']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}
        	if($coachLevel>=$setting['coachlevel4']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}
        	if($coachLevel>=$setting['coachlevel3']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}
        	if($coachLevel>=$setting['coachlevel2']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}
        	if($coachLevel>=$setting['coachlevel1']){
        		db('coach')->save(['coach_level'=>8],$coach_id);
        		return true;
        	}

        	return false;
		}
		file_put_contents(ROOT_PATH.'/data/coachlevel/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>'未成功返回课流量,教练id为:'.$coach_id,'time'=>date('Y-m-d H:i:s',time())]));
		return false;
	}
}