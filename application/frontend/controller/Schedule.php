<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ScheduleService;
use think\Db;
/**
* 课时表类
*/
class Schedule extends Base
{
	
	protected $scheduleService;

	function _initialize()
	{
		parent::_initialize();
		$this->scheduleService = new ScheduleService;
	}

	public function index(){
		return view('Schedule/index');

	}

	// 课时列表
    public function scheduleList(){
    	$map = input();
    	$map = $map?$map:[];
    	$scheduleList = $this->scheduleService->getscheduleList($map);
    	$start_time = mktime(0,0,0,date('m',time()),1,date('Y',time()));
    	$end_time = time();
    	// 本年课量

    	// 本月课量
    	$scheduleOfMonth = $this->scheduleService->countSchedules([]);
    	//总课量
    	$myCount = 1;
    	$scheduleListCount = count('$scheduleList');
    	$this->assign('myCount',$myCount);
  		$this->assign('scheduleList',$scheduleList);
  		$this->assign('scheduleListCount',$scheduleListCount);
		return view('Schedule/scheduleList');
    }

	// 课时详情
	public function scheduleInfo(){
		$schedule_id = input('param.schedule_id');
		$scheduleInfo = $this->scheduleService->getScheduleInfo(['id'=>$schedule_id]);
		$studentList = $this->scheduleService->getStudentList($schedule_id);
		$commentList = $this->scheduleService->getCommentList($schedule_id);
		foreach ($commentList as $key => $value) {
			if($value['anonymous'] == 0){
				$commentList[$key]['member'] = '匿名用户';
			}
		}
		$updateSchedule = 0;
		// 是否已被审核通过
		if($scheduleInfo['status'] == 0){
			// 判断权限
			$isPower = $this->scheduleService->isPower($scheduleInfo['camp_id'],$this->memberInfo['id']);
			if($isPower>=2){
				$updateSchedule = 1;
			}
		}

		$this->assign('updateSchedule',$updateSchedule);
		$this->assign('studentList',$studentList);
		$this->assign('scheduleInfo',$scheduleInfo);
		$this->assign('commentList',$commentList);
		return view('Schedule/scheduleInfo');
	}


	// 录课界面
	public function recordSchedule(){
		$camp_id = input('param.camp_id');
		$lesson_id = input('param.lesson_id');
		$grade_id = input('param.grade_id');
		$is_power = $this->scheduleService->isPower($camp_id,$this->memberInfo['id']);
		if($is_power <2){
			$this->error('您没有权限录课');die;
		}

		// 教练列表
		$memberListOfCamp = db('camp_member')
						->where([
						'camp_id'	=>$camp_id,
						'status'	=>1,
						])
						->field('member,member_id')
						->select();
		// 班级信息
		$GradeService = new \app\service\GradeService;		
		$gradeInfo = $GradeService->getGradeInfo(['id'=>$grade_id]);

		// 训练项目
		$ExerciseService = new \app\service\ExerciseService;
		$exerciseList = $ExerciseService->getExerciseListOfCamp($camp_id);

		// 班级学生
		$studentList = db('grade_member')->where(['grade_id'=>$grade_id,'status'=>1,'type'=>1])->select();
		$countStudentList = count($studentList);
		$this->assign('countStudentList',$countStudentList);
		$this->assign('studentList',$studentList);
		$this->assign('exerciseList',$exerciseList);
		$this->assign('gradeInfo',$gradeInfo);
		$this->assign('memberListOfCamp',$memberListOfCamp);
		$this->assign('campid', $camp_id);
		return view('Schedule/recordSchedule');
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

	// 编辑课时
	public function updateSchedule(){
		$schedule_id = input('param.schedule_id');
		$scheduleInfo = $this->scheduleService->getScheduleInfo(['id'=>$schedule_id]);
		$updateSchedule = 0;
		// 是否已被审核通过
		if($scheduleInfo['status'] == 0){
			// 判断权限
			$isPower = $this->scheduleService->isPower($scheduleInfo['camp_id'],$this->memberInfo['id']);
			if($isPower>=2){
				$updateSchedule = 1;
			}
		}

		$this->assign('updateSchedule',$updateSchedule);
		$this->assign('scheduleInfo',$scheduleInfo);
		return view('Schedule/updateSchedule');
	}

}