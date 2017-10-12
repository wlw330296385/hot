<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\ScheduleService;
/**
* 课时表类
*/
class Schedule extends Base
{
	
	protected $ScheduleService;

	function _initialize()
	{
		parent::_initialize();
		$this->ScheduleService = new ScheduleService;
	}

	public function index(){
		echo  "11";

	}



	//判断录课冲突,规则:同一个训练营课程班级,在某个时间点左右2个小时之内只允许一条数据;
	public function recordScheduleClashApi(){
		try{
			$lesson_id = input('param.lesson_id');
			$lesson_time = input('param.lesson_time');
			$grade_id = input('param.grade_id');
			$camp_id = input('param.camp_id');
			$lesson_time = strtotime($lesson_time);
			//前后2个小时
			$start_time = $lesson_time-7200;
			$end_time = $lesson_time+7200;
			$scheduleList = db('schedule')->where([
									'camp_id'=>$camp_id,
									'grade_id'=>$grade_id,
									'lesson_id'=>$lesson_id,
									'lesson_time'=>['BETWEEN',[$start_time,$end_time]]
									])->select();
			$result = 1;
			if(!$scheduleList){
				$result = 0;
			}else{
				foreach ($scheduleList as $key => $value) {
					if($value['lesson_time']>$start_time && $value['lesson_time']<$end_time){
						$result = 0;
					}
				}
			}

			return $result;
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}
	
	// 判断是否有录课权限|审核
	public function recordSchedulePowerApi(){
		try{
			// 只要是训练营的教练都可以跨训练营录课
			$camp_id = input('param.camp_id');
			$member_id = $this->memberInfo['id'];
			$result = $this->ScheduleService->isPower($camp_id,$member_id);
			return $result;
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}


	//课时审核
	public function recordScheduleCheckApi(){
		try{
			$camp_id = input('param.camp_id');
			$isPower = $this->recordSchedulePowerApi();
			if($isPower <3){
				return json(['code'=>100,'msg'=>__lang('MSG_403')]);
			}
			$schedule_id = input('param.schedule_id');
			$result = db('schedule')->save(['status'=>1],$schedule_id);
			if($result){
				return json(['code'=>200,'msg'=>'审核成功']);
			}else{
				return json(['code'=>100,'msg'=>'审核失败']);
			}
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}


	// 录课Api
	public function recordScheduleApi(){
		try{
			$data = input('post.');
			$data['member_id'] = $this->memberInfo['id'];
			$data['member'] = $this->memberInfo['member'];
			$data['lesson_time'] = strtotime($data['lesson_time_date']);
			$result = $this->ScheduleService->createSchedule($data);
			return json($result);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}

	// 课时评分
	public function starScheduleApi(){
		try{
			$camp_id = input('param.camp_id');
			$is_power = $this->recordSchedulePowerApi();
			if($is_power >1){
				return json(['code'=>100,'msg'=>__lang('MSG_403')]);
			}
			$data = input('post.');
			$data['member_id'] = $this->memberInfo['id'];
			$data['member'] = $this->memberInfo['member'];
			$data['star'] = $data['attitude']+$data['profession']+$data['teaching_attitude']+$data['teaching_quality'];
			$result = $this->ScheduleService->starSchedule($data);
			if($result){
				return json(['code'=>200,'msg'=>'审核成功']);
			}else{
				return json(['code'=>100,'msg'=>'审核失败']);
			}
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
	}


	//获取列表有page
	public function getScheduleListByPageApi(){
		try{
			$map = input('post.');
			$result = $this->ScheduleService->getScheduleListByPage($map);
			return json($result);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
	}


	//获取开始时间和结束时间的列表带page
	public function getScheduleListBetweenTimeByPageApi(){
		try{
			$begin = input('param.begin');
			$end = input('param.end');
			$map = input('post.');
			$beginINT = strtotime($begin);
			$endINT = strtotime($end);
			$map['lesson_time'] = ['BETWEEN',[$beginINT,$endINT]];
			$result = $this->ScheduleService->getScheduleListByPage($map);
			return json($result);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
	}
}