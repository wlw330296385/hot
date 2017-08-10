<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ScheduleService;
/**
* 课时表类
*/
class Schedule extends Base
{
	
	protected $scheduleService;

	function __construct()
	{
		$this->scheduleService = new ScheduleService;
	}

	public function index(){
		$this->recordSchedulePower();

	}

	// 课时列表
    public function lessonList(){
    	$map = input();
    	$map = $map?$map:[];
    	$result = $this->scheduleService->getLessonPage($map,10);
    	if($result['code'] == 100){
			$list = $result['data'];
	  //   	//在线课程
	  //   	$dateNow = date('Y-m-d',time());
	  //   	$onlineList = [];

	  //   	//离线课程
	  //   	$offlineList = [];
			// foreach ($list as $key => $value) {
			// 	if($value['end']<$dateNow || $value['start']>$dateNow){
			// 		$offlineList[] = $value;
			// 	}else{
			// 		$onlineList[] = $value;
			// 	}
				
			// }
	    		 	
    	}else{
    		$list = []; 
    	}
    	
  		$this->assign('lessonList',$list);
		return view();
    }

	// 课时详情
	public function scheduleInfo(){
		$id = input('id');
		$scheduleInfo = $this->scheduleService->getScheduleInfo(['id'=>$id]);
		$this->view();
	}


	// 录课界面
	public function recordSchedule(){
		$camp_id = input('camp_id');
		$lesson_id = input('lesson_id');
		$grade_id = input('grade_id');
		$is_power = $this->recordSchedulePower();
		if($is_power == 0){
			$this->error('您没有权限录课');die;
		}
		// 教练列表
		$memberOfAllList = db('grade_member')->where([
										'camp_id'	=>$camp_id,
										'type'		=>['or',[2,3,4,6,8]],
										'grade_id'	=>$grade_id,
										// 'type'		=>4,
										'status'	=>1
										])
										->field('member,member_id,coach,coach_id')
										->select();
		// $assistantList = db('grade_member')->where([
		// 								'camp_id'	=>$camp_id,
		// 								'type'		=>['or',[2,3,4,8]],
		// 								'status'	=>1
		// 								])
		// 								->field('member,member_id,coach,coach_id')
		// 								->select();
		$this->assign('memberOfAllList',$memberOfAllList);
		// $this->assign('coachList',$coachtList);
		// $this->assign('assistantList',$assistantList);
		return view();
	}

	//判断录课冲突,规则:同一个训练营课程班级,在某个时间点左右2个小时之内只允许一条数据;
	public function recordScheduleClashApi(){
		$lesson_id = input('lesson_id');
		$lesson_time = input('lesson_time');
		$grade_id = input('grade_id');
		$camp_id = input('camp_id');
		//前后2个小时
		$start_time = time()-7200;
		$end_time = time()+7200;
		$scheduleList = db('schedule')->where([
								'camp_id'=>$camp_id,
								'grade_id'=>$grade_id,
								'lesson_id'=>$lesson_id,
								// 'lesson_time'=>['BETWEEN',[$start_time,$end_time]]
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

		return $result;die;
	}
	
	// 判断是否有录课权限|审核
	public function recordSchedulePowerApi(){
		// 只要是训练营的教练都可以跨训练营录课
		$camp_id = input('camp_id');
		$member_id = $this->memberInfo['id'];
		$result = 1;
		$is_power = db('grade_member')->where([
											'member_id'	=>$member_id,
											'camp_id'	=>$camp_id,
											'type'		=>['or',['2,3,4,8']],
											'status'	=>1
									])->find();
		if(!$is_power){
			$result = 0;
		}

		return $result;
	}


	//课时审核
	public function recordScheduleCheckApi(){
		$camp_id = input('camp_id');
		$is_power = $this->recordSchedulePowerApi();
		if($is_power == 0){
			return json(['code'=>200,'msg'=>'权限不足']);die;
		}
		$schedule_id = input('schedule_id');
		$result = db('schedule')->save(['status'=>1],$schedule_id);
		if($result){
			return json(['code'=>100,'msg'=>'审核成功']);die;
		}else{
			return json(['code'=>200,'msg'=>'审核失败']);die;
		}
	}


	// 录课Api
	public function recordScheduleApi(){
		$data = input('post.');
		$result = $this->scheduleService->pubSchedule($data);
		return json($result);
	}
}