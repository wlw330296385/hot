<?php 
namespace app\management\controller;
use app\management\controller\Backend;
// 按课时结算的训练营财务页面
class Grade extends Backend{
	public function _initialize(){
		
		parent::_initialize();
		$campInfo = db('camp')->where(['id'=>$this->camp_member['camp_id']])->find();
        $this->campInfo = $campInfo;
        $this->assign('campInfo',$campInfo);
        
	}


	public function index(){
		
	}

    public function createGrade(){

        if(request()->isPost()){
            $data = input('post.');
            $GradeService = new \app\service\GradeService;
            $result = $GradeService->createGrade($data);
            if ($result['code'] == 200) {
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $camp_id = $this->campInfo['id'];
            // 课程分类
            $GradeCategoryService = new \app\service\GradeCategoryService;
            $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();
            //粉丝列表
            $fansList = db('follow')->where(['follow_id'=>$camp_id,'status'=>1,'type'=>2])->select();
            //教练列表
            $coachList = db('coach c')
                ->field('c.coach,c.id,c.member_id,cm.type,c.portraits')
                ->join('camp_member cm','c.member_id = cm.member_id')
                ->where(['cm.camp_id'=>$camp_id,'cm.type'=>['>',1],'cm.status'=>1])
                ->order('cm.id desc')
                ->select();

            $assignList = db('grade_member')->where(['grade_id'=>$grade_id])->select();
            
            
            $this->assign('assignList',$assignList);
            $this->assign('fansList',$fansList);
            $this->assign('coachList',$coachList);  
            $this->assign('gradeCategoryList',$gradeCategoryList);
            return view('Grade/createGrade');
        }  
    }

	//课程列表
	public function gradeList(){
		$GradeService = new \app\service\GradeService;
		$gradeList = $GradeService->getGradeListByPage(['camp_id'=>$this->campInfo['id']]);

        $this->assign('gradeList',$gradeList);
        return view('Grade/gradeList');
	}


    //课程列表
    public function gradeInfo(){
        $grade_id = input('param.grade_id');
        $GradeService = new \app\service\GradeService;
        $gradeInfo = $GradeService->getGradeInfo(['id'=>$grade_id]);
        $assignList = db('grade_member')->where(['grade_id'=>$grade_id])->select();
        
        
        $this->assign('gradeInfo',$gradeInfo);
        $this->assign('assignList',$assignList);
        return view('Grade/gradeInfo');
}

	public function updateGrade(){
		$grade_id = input('param.grade_id');
        $GradeService = new \app\service\GradeService;
        if(request()->isPost()){
            $data = input('post.');
            $result = $GradeService->updateGrade($data,$grade_id);
            if ($result['code'] == 200) {
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $camp_id = $this->campInfo['id'];
            $gradeInfo = $GradeService->getGradeInfo(['id'=>$grade_id]);

            // 课程分类
            $GradeCategoryService = new \app\service\GradeCategoryService;
            $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();
            //粉丝列表
            $fansList = db('follow')->where(['follow_id'=>$camp_id,'status'=>1,'type'=>2])->select();
            //教练列表
            $coachList = db('coach c')
                ->field('c.coach,c.id,c.member_id,cm.type,c.portraits')
                ->join('camp_member cm','c.member_id = cm.member_id')
                ->where(['cm.camp_id'=>$camp_id,'cm.type'=>['>',1],'cm.status'=>1])
                ->order('cm.id desc')
                ->select();
            $assignList = db('lesson_member')
                    ->field('lesson_member.*,grade_member.student_id as g_id,grade_member.lesson_id as gl_id')
                    ->join('grade_member','grade_member.student_id = lesson_member.student_id and grade_member.lesson_id = lesson_member.lesson_id','left')
                    ->where(['lesson_member.lesson_id'=>$gradeInfo['lesson_id'],'lesson_member.status'=>1])
                    ->order('lesson_member.id desc')
                    ->select();
            $this->assign('gradeInfo',$gradeInfo);
            $this->assign('gradeCategoryList',$gradeCategoryList);
            $this->assign('coachList',$coachList);
            $this->assign('assignList',$assignList);
            $this->assign('fansList',$fansList);
            return view('Grade/updateGrade');
        }
	}
}