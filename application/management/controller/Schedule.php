<?php 
namespace app\management\controller;
use app\management\controller\Backend;
// 按课时结算的训练营财务页面
class Schedule extends Backend{
	public function _initialize(){
		
		parent::_initialize();
		$campInfo = db('camp')->where(['id'=>$this->camp_member['camp_id']])->find();
        $this->campInfo = $campInfo;
        $this->assign('campInfo',$campInfo);
        
	}


	public function index(){
		
	}

    public function createSchedule(){
        $camp_id = $this->campInfo['id'];
        if(request()->isPost()){
            $data = input('post.');
            $ScheduleService = new \app\service\ScheduleService;
            $result = $ScheduleService->createSchedule($data);
            if ($result['code'] == 200) {
                if ($data['isprivate'] == 1) {
                    $dataScheduleAssign['schedule_id'] = $result['data'];
                    $dataScheduleAssign['schedule'] = $data['schedule'];
                    $dataScheduleAssign['memberData'] = $data['memberData'];
                    $resultSaveScheduleAssign = $ScheduleService->saveScheduleAssign($dataScheduleAssign);
                    if (!$resultSaveScheduleAssign) {
                        $this->error("私密课程须选择指定会员");
                    }
                }
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            //粉丝列表
            $fansList = db('follow')->where(['follow_id'=>$camp_id,'status'=>1,'type'=>2])->select();
            //教练列表
            $coachList = db('coach c')
                ->field('c.coach,c.id,c.member_id,cm.type,c.portraits')
                ->join('camp_member cm','c.member_id = cm.member_id')
                ->where(['cm.camp_id'=>$camp_id,'cm.type'=>['>',1],'cm.status'=>1])
                ->order('cm.id desc')
                ->select();
            $grade_id = input('param.g_id');
            if($grade_id){
                $map = ['id'=>$grade_id];
            }else{
                $this->error('请先选择班级');
            }
            $gradeInfo = db('grade')->where($map)->where('delete_time',null)->find();
            if(!$gradeInfo){
                $this->error('班级错误');
            }
            $courtList = db('court_camp')
                ->field('court_camp.id,court_camp.court_id,court_camp.court,court_camp.camp_id,court_camp.camp,court.location,court.id as c_id,court.province,court.city,court.area')
                ->join('court','court.id=court_camp.court_id')
                ->where(['court_camp.camp_id' => $camp_id])
                ->order('court_camp.id desc')
                ->select();
            $studentList = db('lesson_member')
                    ->field('lesson_member.*,grade_member.student_id as gs_id,grade_member.lesson_id as gl_id,grade_member.grade_id as g_id')
                    ->join('grade_member','grade_member.student_id = lesson_member.student_id and grade_member.lesson_id = lesson_member.lesson_id','left')
                    ->where(['lesson_member.lesson_id'=>$gradeInfo['lesson_id'],'lesson_member.status'=>1])
                    ->order('lesson_member.id desc')
                    ->select();
            $this->assign('fansList',$fansList);
            $this->assign('gradeInfo',$gradeInfo);  
            $this->assign('coachList',$coachList);  
            $this->assign('courtList',$courtList);
            $this->assign('studentList',$studentList);    
            return view('Schedule/createSchedule');
        }  
    }

	//课程列表
	public function scheduleList(){
		$ScheduleService = new \app\service\ScheduleService;
		$scheduleList = $ScheduleService->getScheduleListByPage(['camp_id'=>$this->campInfo['id']],'lesson_time desc',20);
        $gradeList = db('grade')->where(['camp_id'=>$this->campInfo['id'],'status'=>1])->select();


        $this->assign('gradeList',$gradeList);
        $this->assign('scheduleList',$scheduleList);
        return view('Schedule/scheduleList');
	}


    //课程列表
    public function scheduleInfo(){
        $schedule_id = input('param.schedule_id');
        $ScheduleService = new \app\service\ScheduleService;
        $scheduleInfo = $ScheduleService->getScheduleInfo(['id'=>$schedule_id]);
        
        $this->assign('scheduleInfo',$scheduleInfo);
        return view('Schedule/scheduleInfo');
}

	public function updateSchedule(){
		$schedule_id = input('param.schedule_id');
        $ScheduleService = new \app\service\ScheduleService;
        if(request()->isPost()){
            $data = input('post.');
            $result = $ScheduleService->updateSchedule($data,$schedule_id);
            if ($result['code'] == 200) {
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $camp_id = $this->campInfo['id'];
            $scheduleInfo = $ScheduleService->getScheduleInfo(['id'=>$schedule_id]);
            //教练列表
            $coachList = db('coach c')
                ->field('c.coach,c.id,c.member_id,cm.type,c.portraits')
                ->join('camp_member cm','c.member_id = cm.member_id')
                ->where(['cm.camp_id'=>$camp_id,'cm.type'=>['>',1],'cm.status'=>1])
                ->order('cm.id desc')
                ->select();
            

            $this->assign('scheduleInfo',$scheduleInfo);
            $this->assign('coachList',$coachList);
            return view('Schedule/updateSchedule');
        }
	}



    //审核课时
    public function check(){
        $schedule_id = input('param.schedule_id');
        if (!$schedule_id) {
           $this->error('参数错误');
        }
        $schedule = db('schedule')->where(['id' => $schedule_id])->find();   
        if ($schedule['status'] != -1) {
            return ['code' => 100, 'msg' => '该课时记录已审核，不能操作了'];
        }
        // 课时学员名单
        $students = unserialize($schedule['student_str']);
        if($schedule['is_school'] == -1){
            // 课时结算方式的训练营 教练、训练营课时所得工资金额与平台抽取金额的总和不能大于课时收入金额（课时学员*课程单价）
            if ($schedule['rebate_type'] == 1) {
                // 课时工资
                $numScheduleStudent = count($students);
                $lessonCost = $schedule['cost'];
                $scheduleIncome = $lessonCost * $numScheduleStudent;
                // 平台抽取金额：课时工资*抽取比例（注意训练营有单独的比例）
                if (!empty($schedule['schedule_rebate'])) {
                    // 以训练营独有平台抽取比例
                    $scheduleRebate = ($schedule['schedule_rebate'] == 0) ? 0 : $schedule['schedule_rebate'];
                } else {
                    $SystemS = new SystemService();
                    $setting = $SystemS::getSite();
                    $scheduleRebate = $setting['sysrebate'];
                }
                // 平台抽取金额
                $systemExtractionAmount = $scheduleIncome * $scheduleRebate;
                // 助教练（多个）底薪总
                $assistantIncomeSum = 0;
                $assistantCount = 0;
                if (!empty($schedule['assistant'])) {
                    $assistantCount = count(unserialize($schedule['assistant']));
                    $assistantIncomeSum = $schedule['assistant_salary'] * $assistantCount;
                }
                // 课时工资提成
                $pushSalary = $schedule['salary_base'] * $numScheduleStudent;
                // 金额总和 = 主教练工资+副教练工资+平台抽成+教练提成;
                $salaryInSum = $schedule['coach_salary'] + $assistantIncomeSum + $systemExtractionAmount + ($pushSalary*(1+$assistantCount));
                if ( $salaryInSum > $scheduleIncome ) {
                    return $this->error('课时支出给教练的工资超过课时收入，请修改信息');
                }
            }
            // 检查课时相关学员剩余课时
            $ScheduleService = new \app\service\ScheduleService;
            $checkStudentRestscheduleResult = $ScheduleService->checkstudentRestschedule($schedule, $students);
            if ($checkStudentRestscheduleResult['code'] == 100) {
                return json($checkStudentRestscheduleResult);
            }
        }
        //写入学生课时数据
        $res = $ScheduleService->saveScheduleMember($schedule,$students);
        if($res['code'] ==200){
            $this->success('操作成功');
        }else{
            $this->error($res['msg']);
        }
   
    }
}