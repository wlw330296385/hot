<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\GradeService;
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
    	$students = db('grade_member')->where(['grade_id'=>$id,'type'=>1,'status'=>1])->field('student')->select();
    	dump($students);
    	dump($gradeInfo);die;
    	$this->assign('gradeInfo',$gradeInfo);
        return view();
    }


    public function createGrade(){
    	
    	return view();
    }


    public function updateGrade(){
    	$grade_id = input('grade_id');
        $gradeInfo = $this->GradeService->getGradeInfo(['id'=>$grade_id]);
    	// 获取班级学生
    	$students = db('grade_member')->where(['grade_id'=>$id,'type'=>1,'status'=>1])->field('student')->select();
    	return view();
    }



    public function gradeInfo(){
        $grade_id = input('grade_id');
        $gradeInfo = $this->GradeService->getGradeInfo(['id'=>$grade_id]);
        // 班级同学
        $studentList = $this->GradeService->getStudentList($grade_id);
        $this->assign('studentList',$studentList);
        $this->assign('gradeInfo',$gradeInfo);
        return view();
    }

    public function gradeInfoOfCamp(){
        $grade_id = input('grade_id');
        $gradeInfo = $this->GradeService->getGradeInfo(['id'=>$grade_id]);
        // 班级同学
        $studentList = $this->GradeService->getStudentList($grade_id);
        $this->assign('studentList',$studentList);
        $this->assign('gradeInfo',$gradeInfo);
        return view();
    }


    public function gradeList(){
        $member_id = $this->memberInfo['id'];
        $camp_id = input('camp_id');
        $map1 = ['camp_id'=>$camp_id,'status'=>1];
        $map0 = ['camp_id'=>$camp_id,'status'=>0];
        $actGradeList = $this->GradeService->getGradeList($map1);
        $readyGradeList = $this->GradeService->getGradeList($map0);
        $gradeList = $this->GradeService->getGradeList(['camp_id'=>$camp_id]);
        $count1 = count($actGradeList);
        $count0 = count($readyGradeList);
        // 我的班级
        $myGradeList = $this->GradeService->getGradeList(['camp_id'=>$camp_id,'status'=>1,'coach_id'=>$member_id]);
        $myCount = count($myGradeList);
        $gradeListCount = count($gradeList);
        $this->assign('gradeList',$gradeList);
        $this->assign('gradeListCount',$gradeListCount);
        $this->assign('myGradeList',$myGradeList);
        $this->assign('myCount',$myCount);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('actGradeList',$actGradeList);
        return view();
    }
}