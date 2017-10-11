<?php

namespace app\service;

use app\model\Schedule;
use think\Db;
use app\common\validate\ScheduleVal;
use app\common\validate\ScheduleCommentVal;
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

    public function getScheduleListByPage($map = [],$paginate = 10,$order = ''){
        $result = $this->scheduleModel->where($map)->order($order)->paginate($paginate);
        if($result){
            return $result->toArray();
        }else{
            return $result;
        }
    }

	// 发布课时
	public function createSchedule($data){
		 // 查询权限
        $is_power = $this->isPower($data['camp_id'],$data['member_id']);
        
        if($is_power<2){
            return ['code'=>100,'msg'=>__lang('MSG_403')];
        }
        $validate = validate('ScheduleVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }            
		$result = $this->scheduleModel->save($data);
		if($result ===false){
            db('camp')->where(['id'=>$data['camp_id']])->setInc('total_schedule');
			return ['msg'=>$this->scheduleModel->getError(),'code'=>100];
		}else{
			return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$result];
		}
	}

    // 修改课时
    public function updateSchedule($data,$id){
        // 查询权限
        $is_power = $this->isPower($data['camp_id'],$data['member_id']);
        
        if($is_power<2){
            return ['code'=>100,'msg'=>__lang('MSG_403')];
        }
        $validate = validate('ScheduleVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }            
        $result = $this->scheduleModel->save($data,['id'=>$id]);
        if($result ===false){
            return ['msg'=>$this->scheduleModel->getError(),'code'=>100];
        }else{
            return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$result];
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



    // 课程权限
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where([
                        'camp_id'   =>$camp_id,
                        'status'    =>1,
                        'member_id'  =>$member_id,
                        ])
                    ->value('type');

        return $is_power?$is_power:0;
    
    }


    // 可是评分
    public function starSchedule($data){
        $ScheduleComment = new \app\model\ScheduleComment;
        $validate = validate('ScheduleCommentVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $isSchedule = $ScheduleComment->where(['member_id'=>$data['member_id'],'schedule_id'=>$data['schedule_id']])->find();
        if($isSchedule){
            return ['code'=>100,'msg'=>'一个人只能评论一次'];
        }else{
            $result = $ScheduleComment->save($data);
            if($result){
                // 计算总评分
                
                return ['code'=>200,'msg'=>'评论成功'];
            }else{
                return ['code'=>100,'msg'=>'评论失败'];
            }
        }

    }
}