<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CampService;
use app\service\ScheduleService;
use think\Db;
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
		$campS = new CampService();
		$camp_id = input('camp_id', 0);
		$camp = $campS->getCampInfo($camp_id);
		$this->assign('campInfo', $camp);
		$this->assign('camp_id', $camp_id);
	}

	public function index(){
		return view('Schedule/index');

	}

	// 课时列表
    public function scheduleList(){
    	$map = input();
    	// $map = $map?$map:[];
    	$camp_id = input('camp_id');
    	// $scheduleList = $this->ScheduleService->getscheduleList($map);

        // 课时统计
        $scheduleCount = $this->ScheduleService->countSchedules(['camp_id' => $camp_id]);
    	$this->assign('scheduleCount',$scheduleCount);
  		// $this->assign('scheduleList',$scheduleList);
  		$this->assign('camp_id', $camp_id);
		return view('Schedule/scheduleList');
    }


    // 课时列表
    public function scheduleListOfStudent(){
    	$student_id = input('param.student_id');
<<<<<<< HEAD
    	$studentList = db('student')->where(['member_id'=>$this->memberInfo['id']])->where('delete_time',null)->select();
=======
    	$camp_id = input('param.camp_id');
    	$studentList = db('lesson_member')->distinct(true)->field("student_id,student")->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>$camp_id])->where('delete_time',null)->select();
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    	if(!$studentList){
    		$this->error('您还没有创建学生');
    	}
    	if(!$student_id){
<<<<<<< HEAD
    		$student_id = $studentList[0]['id'];
    	}
    	$camp_id = input('param.camp_id');
=======
    		$student_id = $studentList[0]['student_id'];
    	}
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    	// 学生的班级
    	$gradeList = db('grade_member')->where(['student_id'=>$student_id,'camp_id'=>$camp_id])->where('delete_time',null)->select();
    	$gradeIDS = db('grade_member')->where(['student_id'=>$student_id,'camp_id'=>$camp_id])->where('delete_time',null)->column('grade_id');
    	// 剩余课量
    	$restSchedule = db('lesson_member')->where(['student_id'=>$student_id,'camp_id'=>$camp_id,'status'=>1])->where('delete_time',null)->sum('rest_schedule');
        // 课时统计
        $scheuldeIDS = db('schedule')->where(['grade_id'=>['in',$gradeIDS],'camp_id'=>$camp_id])->where('delete_time',null)->column('id');
        $scheduleCount = $this->ScheduleService->countScheduleMembers(['camp_id' => $camp_id,'schedule_id'=>['in',$scheuldeIDS],'user_id'=>$student_id]);
        $this->assign('gradeIDS',json_encode($gradeIDS));
        $this->assign('restSchedule',$restSchedule);
    	$this->assign('scheduleCount',$scheduleCount);
  		$this->assign('gradeList',$gradeList);
  		$this->assign('studentList',$studentList);
  		$this->assign('student_id',$student_id);
  		$this->assign('camp_id', $camp_id);
		return view('Schedule/scheduleListOfStudent');
    }



	// 课时详情
	public function scheduleInfo(){
		$schedule_id = input('param.schedule_id');
		$scheduleInfo = $this->ScheduleService->getScheduleInfo(['id'=>$schedule_id]);
//		$studentList = $this->ScheduleService->getStudentList($schedule_id);
        // 正式学员名单
        $studentList = [];
        if ($scheduleInfo['student_str']) {
            $studentList = unserialize($scheduleInfo['student_str']);
        }
        // 体验生名单
        $expstudentList = [];
        if ($scheduleInfo['expstudent_str']) {
            $expstudentList = unserialize($scheduleInfo['expstudent_str']);
        }
		$commentList = $this->ScheduleService->getCommentList($schedule_id);
		foreach ($commentList as $key => $value) {
			if($value['anonymous'] == 0){
				$commentList[$key]['member'] = '匿名用户';
			}
		}
		$updateSchedule = 0;
<<<<<<< HEAD
		// 是否已被审核通过
		if($scheduleInfo['status'] == 0){
			// 判断权限
			$isPower = $this->ScheduleService->isPower($scheduleInfo['camp_id'],$this->memberInfo['id']);
			if($isPower>=2){
				$updateSchedule = 1;
			}
		}
        //dump($scheduleInfo);
=======

		// 已结算课时不能编辑
        if ($scheduleInfo['is_settle'] != 1) {
            // 判断权限
            $isPower = $this->ScheduleService->isPower($scheduleInfo['camp_id'],$this->memberInfo['id']);
            if($isPower>=2){
                $updateSchedule = 1;
            }
        }


        //课时指定的训练项目
		if($scheduleInfo['exercise']){
		    $scheduleInfo['exerciseList'] = json_decode($scheduleInfo['exercise'],true);
		}else{
		    $scheduleInfo['exerciseList'] = [];
		}
        
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
		$this->assign('updateSchedule',$updateSchedule);
		$this->assign('studentList',$studentList);
        $this->assign('expstudentList',$expstudentList);
		$this->assign('scheduleInfo',$scheduleInfo);
		$this->assign('commentList',$commentList);
		return view('Schedule/scheduleInfo');
	}


	// 录课界面
	public function recordSchedule(){
		$camp_id = input('param.camp_id');
		$lesson_id = input('param.lesson_id');
		$grade_id = input('param.grade_id');
		$is_power = $this->ScheduleService->isPower($camp_id,$this->memberInfo['id']);
		if($is_power <2){
			$this->error('您没有权限录课');die;
		}

		// 教练列表
		$map['camp_id'] = $camp_id;
        $map['camp_member.status'] = 1;
        $map['camp_member.type'] = ['egt', 2];
		$coachListOfCamp = Db::view('camp_member',['id' => 'campmemberid','camp_id'])
                ->view('coach','*','coach.member_id=camp_member.member_id')
                ->where($map)
                ->order('camp_member.id desc')
                ->select();
        // 粉丝列表
        $fanListOfCamp = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1,'type'=>-1])->select();

		// 班级信息
		$GradeService = new \app\service\GradeService;		
		$gradeInfo = $GradeService->getGradeInfo(['id'=>$grade_id]);

		// 教案
		$PlanService = new \app\service\PlanService;
		$planInfo = $PlanService->getPlanInfo(['id'=>$gradeInfo['plan_id']]);
<<<<<<< HEAD
		if($planInfo){
			$planInfo['exerciseList'] = [
										'exercise'=> unserialize($planInfo['exercise']),
										'exercise_id'=>unserialize($planInfo['exercise_id'])
									];
		}else{
			$planInfo['exerciseList'] = [
										'exercise'=>[],
										'exercise_id'=>[]
									];
		}
=======
		if($planInfo['exercise_str']){
		    $planInfo['exerciseList'] = json_decode($planInfo['exercise_str'],true);
		}else{
		    $planInfo['exerciseList'] = [];
		}

		//dump($planInfo['exerciseList']);die;

>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
		
		// 班级学生
		$studentList = db('grade_member')->where(['grade_id'=>$grade_id,'status'=>1,'type'=>1])->select();
		$expstudentList = db('grade_member')->where(['grade_id' => $grade_id, 'status' => 1, 'type' => 2])->select();
//		dump($studentList);
		$countStudentList = count($studentList);

		$this->assign('fanListOfCamp',$fanListOfCamp);
		$this->assign('countStudentList',$countStudentList);
		$this->assign('planInfo',$planInfo);
		$this->assign('gradeInfo',$gradeInfo);
		$this->assign('coachListOfCamp',$coachListOfCamp);
		$this->assign('campid', $camp_id);
		$this->assign('studentList', $studentList);
		$this->assign('expstudentList', $expstudentList);
		return view('Schedule/recordSchedule');
	}


	// 编辑课时
	public function updateSchedule(){
		$schedule_id = input('param.schedule_id');
		$scheduleInfo = $this->ScheduleService->getScheduleInfo(['id'=>$schedule_id]);
<<<<<<< HEAD
		// 是否已被审核通过
		if($scheduleInfo['status'] != 0){
			// 判断权限
			$this->error('已审核的课时不允许修改');
			
		}else{
			$isPower = $this->ScheduleService->isPower($scheduleInfo['camp_id'],$this->memberInfo['id']);
			if($isPower<2){
				$this->error('你没有权限修改课时');
			}
		}
 		$studentList = [];
        if ($scheduleInfo['student_str']) {
            $studentList = unserialize($scheduleInfo['student_str']);
        }
        // 体验生名单
        $expstudentList = [];
        if ($scheduleInfo['expstudent_str']) {
            $expstudentList = unserialize($scheduleInfo['expstudent_str']);
        }
=======

		if(!$scheduleInfo){
			$this->error('无此课时数据');
		}

        // 已结算课时不能编辑
        if ($scheduleInfo['is_settle'] == 1) {
            $this->error('课时已结算，不能修改了');
        }

        $isPower = $this->ScheduleService->isPower($scheduleInfo['camp_id'],$this->memberInfo['id']);
        if($isPower<2){
            $this->error('你没有权限修改课时');
        }

 		$studentList = [];
        if ($scheduleInfo['student_str']) {
            $studentList = unserialize($scheduleInfo['student_str']);
        }
        // 体验生名单
        $expstudentList = [];
        if ($scheduleInfo['expstudent_str']) {
            $expstudentList = unserialize($scheduleInfo['expstudent_str']);
        }


        //课时指定的训练项目
		if($scheduleInfo['exercise']){
		    $scheduleInfo['exerciseList'] = json_decode($scheduleInfo['exercise'],true);
		}else{
		    $scheduleInfo['exerciseList'] = [];
		}

		// 教案
		$PlanService = new \app\service\PlanService;
		$planInfo = $PlanService->getPlanInfo(['id'=>$scheduleInfo['plan_id']]);
		if($planInfo['exercise_str']){
		    $planInfo['exerciseList'] = json_decode($planInfo['exercise_str'],true);
		}else{
		    $planInfo['exerciseList'] = [];
		}

		$this->assign('planInfo',$planInfo);
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
		$this->assign('studentList',$studentList);
        $this->assign('expstudentList',$expstudentList);
		$this->assign('scheduleInfo',$scheduleInfo);
		return view('Schedule/updateSchedule');
	}

	// 赠课管理
	public function giftlistofcamp() {
	    return view('Schedule/giftlistOfCamp');
    }
<<<<<<< HEAD

    // 购买赠送课时
    public function giftbuy() {
	    return view("Schedule/giftbuy");
    }

    public function giftbuyinfo() {
	    $id = input('id', 0);
	    if (!$id) {
	        $this->error(__lang('MSG_402'));
        }
        $scheduleS = new ScheduleService();
        $giftbuyinfo = $scheduleS->getbuygift(['id' => $id]);
//	    dump($giftbuyinfo);
        $this->assign('giftbuyInfo', $giftbuyinfo);
        return view("Schedule/giftbuyInfo");
    }

    // 赠送课时 分配给学员
    public function giftrecord() {
	    return view('Schedule/giftrecord');
    }

=======

    // 购买赠送课时
    public function giftbuy() {
	    return view("Schedule/giftbuy");
    }

    public function giftbuyinfo() {
	    $id = input('id', 0);
	    if (!$id) {
	        $this->error(__lang('MSG_402'));
        }
        $scheduleS = new ScheduleService();
        $giftbuyinfo = $scheduleS->getbuygift(['id' => $id]);
//	    dump($giftbuyinfo);
        $this->assign('giftbuyInfo', $giftbuyinfo);
        return view("Schedule/giftbuyInfo");
    }

    // 赠送课时 分配给学员
    public function giftrecord() {
	    return view('Schedule/giftrecord');
    }

>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    public function giftrecordinfo() {
        $id = input('id', 0);
        if (!$id) {
            $this->error(__lang('MSG_402'));
        }
        $scheduleS = new ScheduleService();
        $giftrecordInfo = $scheduleS->getGiftRecordInfo(['id' => $id]);
        $studentList = json_decode($giftrecordInfo['student_str'], true);
        
        $this->assign('giftrecordInfo', $giftrecordInfo);
        $this->assigN('studentList', $studentList);
        return view('Schedule/giftrecordInfo');
    }
}