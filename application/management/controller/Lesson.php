<?php 
namespace app\management\controller;
use app\management\controller\Backend;
// 按课时结算的训练营财务页面
class Lesson extends Backend{
	public function _initialize(){
		
		parent::_initialize();
		$campInfo = db('camp')->where(['id'=>$this->camp_member['camp_id']])->find();
        $this->campInfo = $campInfo;
        $this->assign('campInfo',$campInfo);
        
	}


	public function index(){
		
	}

    public function createLesson(){

        if(request()->isPost()){
            $data = input('post.');
            $LessonService = new \app\service\LessonService;
            $result = $LessonService->createLesson($data);
            if ($result['code'] == 200) {
                if ($data['isprivate'] == 1) {
                    $dataLessonAssign['lesson_id'] = $result['data'];
                    $dataLessonAssign['lesson'] = $data['lesson'];
                    $dataLessonAssign['memberData'] = $data['memberData'];
                    $resultSaveLessonAssign = $LessonService->saveLessonAssign($dataLessonAssign);
                    if (!$resultSaveLessonAssign) {
                        $this->error("私密课程须选择指定会员");
                    }
                }
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

            
            $courtList = db('court_camp')
                ->field('court_camp.id,court_camp.court_id,court_camp.court,court_camp.camp_id,court_camp.camp,court.location,court.id as c_id,court.province,court.city,court.area')
                ->join('court','court.id=court_camp.court_id')
                ->where(['court_camp.camp_id' => $camp_id])
                ->order('court_camp.id desc')
                ->select();
            
            $this->assign('fansList',$fansList);
            $this->assign('coachList',$coachList);  
            
            $this->assign('courtList',$courtList); 
            $this->assign('gradeCategoryList',$gradeCategoryList);
            return view('Lesson/createLesson');
        }  
    }

	//课程列表
	public function lessonList(){
		$LessonService = new \app\service\LessonService;
		$lessonList = $LessonService->getLessonListByPage(['camp_id'=>$this->campInfo['id']]);
 

        $this->assign('lessonList',$lessonList);
        return view('Lesson/lessonList');
	}


    //课程列表
    public function lessonInfo(){
        $lesson_id = input('param.lesson_id');
        $LessonService = new \app\service\LessonService;
        $lessonInfo = $LessonService->getLessonInfo(['id'=>$lesson_id]);
        $assignList = [];
        if($lessonInfo['isprivate'] == 1){
            $assignList = db('lesson_assign_member')->where(['lesson_id'=>$lesson_id])->select();
        }
        
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('assignList',$assignList);
        return view('Lesson/lessonInfo');
}

	public function updateLesson(){
		$lesson_id = input('param.lesson_id');
        $LessonService = new \app\service\LessonService;
        if(request()->isPost()){
            $data = input('post.');
            $result = $LessonService->updateLesson($data,$lesson_id);
            if ($result['code'] == 200) {
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $camp_id = $this->campInfo['id'];
            $lessonInfo = $LessonService->getLessonInfo(['id'=>$lesson_id]);

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
            $assignList = [];
            if($lessonInfo['isprivate'] == 1){
                $assignList = db('lesson_assign_member')->where(['lesson_id'=>$lesson_id])->select();
            }
            
            
            $courtList = db('court_camp')
                ->field('court_camp.id,court_camp.court_id,court_camp.court,court_camp.camp_id,court_camp.camp,court.location,court.id as c_id,court.province,court.city,court.area')
                ->join('court','court.id=court_camp.court_id')
                ->where(['court_camp.camp_id' => $camp_id])
                ->order('court_camp.id desc')
                ->select();
                
            $this->assign('lessonInfo',$lessonInfo);
            $this->assign('gradeCategoryList',$gradeCategoryList);
            $this->assign('coachList',$coachList);
            $this->assign('courtList',$courtList);
            $this->assign('assignList',$assignList);
            $this->assign('fansList',$fansList);
            return view('Lesson/updateLesson');
        }
	}
}