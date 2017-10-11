<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\GradeService;
use think\Db;
class Grade extends Base{
	public function _initialize(){
		parent::_initialize();
		$this->GradeService = new GradeService;
	}
	// 班级详情
    public function index() {
    	$grade_id = input('grade_id');
        $gradeInfo = $this->GradeService->getGradeInfo(['id'=>$grade_id]);
    	// 获取班级学生
    	$students = db('grade_member')->where(['grade_id'=>$grade_id,'type'=>1,'status'=>1])->field('student')->select();

    	$this->assign('gradeInfo',$gradeInfo);
        return view('Grade/index');
    }


    public function createGrade(){
    	$camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
         // 判读权限
        $CampService = new \app\service\CampService;
        $is_power = $CampService->isPower($camp_id,$this->memberInfo['id']);
        if($is_power < 2){
            $this->error('您没有权限');
        }

        // 课程列表
        $lessonList = db('lesson')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        //获取班级类型
        $gradecateList = $this->GradeService->getGradeCategory();
        //获取员工列表
        $staffList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        // 教练列表
        $coachlist = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1, 'type' => 2])->select();
        //场地列表
        $courtService = new \app\service\CourtService;
        //$courtList = $courtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        $courtList = $courtService->getCourtListOfCamp(['camp_id'=>$camp_id]);
        // 获取课程学生
        $studentList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        // 教案列表
        $PlanService = new \app\service\PlanService;
        $planList = $PlanService->getPlanList(['camp_id'=>$camp_id,'type'=>1]);

        $this->assign('lessonList',$lessonList);
        $this->assign('planList',$planList);
        $this->assign('courtList',$courtList);
        $this->assign('courtListJson',json_encode($courtList));
        $this->assign('staffList',$staffList);
        $this->assign('coachlist', $coachlist);
        $this->assign('gradecateList',$gradecateList);
        $this->assign('studentList',$studentList);
        $this->assign('campInfo',$campInfo);
    	return view('Grade/createGrade');
    }


    public function updateGrade(){
    	$grade_id = input('param.grade_id');
        $gradeInfo = $this->GradeService->getGradeInfo(['id'=>$grade_id]);
        
        // 判读权限
        $CampService = new \app\service\CampService;
        $is_power = $CampService->isPower($gradeInfo['camp_id'],$this->memberInfo['id']);
        if($is_power < 2){
            $this->error('您没有权限');
        }
        //获取班级类型
        $gradecateList = $this->GradeService->getGradeCategory();
        //获取员工列表
        $staffList = db('camp_member')->where(['camp_id'=>$gradeInfo['camp_id'],'status'=>1])->select();
        //场地列表
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['camp_id'=>$gradeInfo['camp_id'],'status'=>1]);
    	// 获取班级学生
    	$studentList = $this->GradeService->getStudentList($grade_id);
        // 教案列表
        $PlanService = new \app\service\PlanService;
        $planList = $PlanService->getPlanList(['camp_id'=>$gradeInfo['camp_id'],'type'=>1]);

        $this->assign('planList',$planList);
        $this->assign('courtList',$courtList);
        $this->assign('courtListJson',json_encode($courtList));
        $this->assign('staffList',$staffList);
        $this->assign('gradecateList',$gradecateList);
        $this->assign('gradeInfo',$gradeInfo);
        $this->assign('studentList',$studentList);
    	return view('Grade/updateGrade');
    }



    public function gradeInfo(){
        $grade_id = input('grade_id');
        $gradeInfo = $this->GradeService->getGradeInfo(['id'=>$grade_id]);      
        // 班级同学
        $studentList = $this->GradeService->getStudentList($grade_id);
        $this->assign('studentList',$studentList);
        $this->assign('gradeInfo',$gradeInfo);
        return view('Grade/gradeInfo');
    }

    public function gradeInfoOfCamp(){
        $grade_id = input('grade_id');
        $gradeInfo = $this->GradeService->getGradeInfo(['id'=>$grade_id]);
        // 班级同学
        $studentList = $this->GradeService->getStudentList($grade_id);
        $this->assign('studentList',$studentList);
        $this->assign('gradeInfo',$gradeInfo);
        $this->assign('updateGrade', 1);
        return view('Grade/gradeInfoOfCamp');
    }

    // 普通班级列表
    public function gradeList(){
        $member_id = $this->memberInfo['id'];
        $camp_id = input('param.camp_id');
        $gradeList = Db::view('grade','grade,id,students,gradecate,status')
                    ->view('grade_member','grade_id,camp_id,member_id','grade_member.grade_id=grade.id')
                    ->where(['grade_member.status'=>1])
                    ->where(['grade_member.camp_id'=>$camp_id])
                    ->where(['grade.camp_id'=>$camp_id])
                    ->where('grade.delete_time',null)
                    ->order('grade_member.id desc')
                    ->select();
        $countMyGrade = 0;
        foreach ($gradeList as $key => $value) {
                       if($value['member_id'] == $member_id){
                        $countMyGrade++;
                       }
                    }            
        $count = count($gradeList);
        $this->assign('countMyGrade',$countMyGrade);
        $this->assign('gradeList',$gradeList);
        $this->assign('count',$count);
        return view('Grade/gradeList');
    }


    // 有权限的班级列表
    public function gradeListOfCamp(){
        $member_id = $this->memberInfo['id'];
        $camp_id = input('param.camp_id');
        $map1 = ['camp_id'=>$camp_id,'status'=>1];
        $map0 = ['camp_id'=>$camp_id,'status'=>0]; 
        // 我的班级
        $gradeList = $this->GradeService->getGradeList(['camp_id'=>$camp_id]);

        $myGradeList = $this->GradeService->getGradeList(['camp_id'=>$camp_id,'coach_id'=>$member_id]);
        $myCount = count($myGradeList);
        $gradeListCount = count($gradeList);
        $this->assign('camp_id',$camp_id);
        $this->assign('gradeList',$gradeList);
        $this->assign('gradeListCount',$gradeListCount);
        $this->assign('myGradeList',$myGradeList);
        $this->assign('myCount',$myCount);
        return view('Grade/gradeListOfCamp');
    }


        public function gradeListWeek(){
        $coach_id = input('param.coach_id');
        $camp_id = input('param.camp_id');
        if(!$coach_id){
            $coach_id = db('coach')->where(['member_id'=>$this->memberInfo['id'],'status'=>1])->value('id');
        }
        $week = input('param.week');
        
        $myGradeList = db('grade')->where(['coach_id'=>$coach_id,'camp_id'=>$camp_id])->where('week','like',"%$week%")->select();
        $campGradeList = db('grade')->where(['camp_id'=>$camp_id])->where('week','like',"%$week%")->select();

        $this->assign('camp_id',$camp_id);
        $this->assign('myGradeList',$myGradeList);    
        $this->assign('campGradeList',$campGradeList);
        return view('Grade/gradeListWeek');
    }

    // 课时日历
    public function gradeCalendar(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $gradeList = Db::view('grade_member','grade_id')
                    ->view('grade','location,camp,grade,week,lesson_time','grade_member.grade_id=grade.id')
                    ->where(['grade_member.type'=>1,'grade_member.member_id'=>$member_id,'grade_member.status'=>1])
                    ->order('grade_member.id desc')
                    ->select();
        $this->assign('gradeList',$gradeList);  
        return view('Grade/gradeCalendar');
    }
}