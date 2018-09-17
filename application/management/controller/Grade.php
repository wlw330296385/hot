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

            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $GradeService = new \app\service\GradeService;
            $result = $GradeService->createGrade($data);
            if ($result['code'] == 200) {
                $grade_id = $result['data'];
                if(!empty($data['studentData']) && $data['studentData'] != '[]'){
                    $studentData = json_decode($data['studentData'],true);
                    $StudentService = new \app\service\StudentService;
                    foreach ($studentData as $key => $value) {
                       $studentData[$key]['grade'] = $data['grade'];
                       $studentData[$key]['grade_id'] = $grade_id;
                    }
                    $res = $StudentService->saveAllStudent($studentData);
                }
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $camp_id = $this->campInfo['id'];
            //粉丝列表
            $fansList = db('follow')->where(['follow_id'=>$camp_id,'status'=>1,'type'=>2])->select();
            //教练列表
            $coachList = db('coach c')
                ->field('c.coach,c.id,c.member_id,cm.type,c.portraits')
                ->join('camp_member cm','c.member_id = cm.member_id')
                ->where(['cm.camp_id'=>$camp_id,'cm.type'=>['>',1],'cm.status'=>1])
                ->order('cm.id desc')
                ->select();
            $courtList = db('court_camp')
                ->field('court_camp.id,court_camp.court_id,court_camp.court,court_camp.camp_id,court_camp.camp,court.location,court.id as c_id,court.province,court.city,court.area')
                ->join('court','court.id=court_camp.court_id')
                ->where(['court_camp.camp_id' => $camp_id])
                ->order('court_camp.id desc')
                ->select();
            $planList = db('plan')->where(['camp_id'=>$camp_id])->where('delete_time',null)->select();
            $lessonList = db('lesson')->where(['camp_id'=>$camp_id])->where('delete_time',null)->select();
            $this->assign('fansList',$fansList);
            $this->assign('planList',$planList);
            $this->assign('courtList',$courtList);
            $this->assign('coachList',$coachList);  
            $this->assign('lessonList',$lessonList);  
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
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            if($data['address']){
                $address = explode(' ', $data['address']);
                $data['province'] = $address[0];
                $data['city'] = $address[1];
                if($address[2]){
                    $data['area'] = $address[2];
                }else{
                    $data['area'] = $address[1];
                }             
            }
            $result = $GradeService->updateGrade($data,$grade_id);
            if ($result['code'] == 200) {
                $studentData = json_decode($data['studentData'], true);
                $gradeInfo = $GradeService->getGradeInfo(['id' => $grade_id]);
                // 教练底薪，提成基数数值改变，更新班级现有的未审课时相关数据
                if ( $data['coach_salary'] != $gradeInfo['coach_salary']
                    || $data['assistant_salary'] != $gradeInfo['assistant_salary']
                    || $data['salary_base'] != $gradeInfo['salary_base']
                ) {
                    db('schedule')
                        ->where([
                        'grade_id' => $gradeInfo['id'],
                        'status' => -1,
                        'is_settle' => 0
                        ])
                        ->whereNull('delete_time')
                        ->update([
                            'coach_salary' => $data['coach_salary'],
                            'assistant_salary' => $data['assistant_salary'],
                            'salary_base' => $data['salary_base']
                        ]);
                }
                db('grade_member')->where(['grade_id'=>$grade_id])->delete();
                if ( !empty($studentData)) {
                    $resSaveGradeMember = $GradeService->saveAllGradeMember($studentData,$grade_id);
                    if ($resSaveGradeMember['code'] == 100) {
                        return json($resSaveGradeMember);
                    }
                }
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $camp_id = $this->campInfo['id'];
            $gradeInfo = $GradeService->getGradeInfo(['id'=>$grade_id]);

            //粉丝列表
            $fansList = db('follow')->where(['follow_id'=>$camp_id,'status'=>1,'type'=>2])->select();
            //教练列表
            $coachList = db('coach c')
                ->field('c.coach,c.id,c.member_id,cm.type,c.portraits')
                ->join('camp_member cm','c.member_id = cm.member_id')
                ->where(['cm.camp_id'=>$camp_id,'cm.type'=>['>',1],'cm.status'=>1])
                ->order('cm.id desc')
                ->select();
            $courtList = db('court_camp')
                ->field('court_camp.id,court_camp.court_id,court_camp.court,court_camp.camp_id,court_camp.camp,court.location,court.id as c_id,court.province,court.city,court.area')
                ->join('court','court.id=court_camp.court_id')
                ->where(['court_camp.camp_id' => $camp_id])
                ->order('court_camp.id desc')
                ->select();
            $assignList = db('lesson_member')
                    ->field('lesson_member.*,grade_member.student_id as g_id,grade_member.lesson_id as gl_id')
                    ->join('grade_member','grade_member.student_id = lesson_member.student_id and grade_member.lesson_id = lesson_member.lesson_id','left')
                    ->where(['lesson_member.lesson_id'=>$gradeInfo['lesson_id'],'lesson_member.status'=>1])
                    ->order('lesson_member.id desc')
                    ->select();
            $planList = db('plan')->where(['camp_id'=>$camp_id])->where('delete_time',null)->select();
            $this->assign('gradeInfo',$gradeInfo);
            $this->assign('courtList',$courtList);
            $this->assign('planList',$planList);
            $this->assign('coachList',$coachList);
            $this->assign('assignList',$assignList);
            $this->assign('fansList',$fansList);
            return view('Grade/updateGrade');
        }
	}
}