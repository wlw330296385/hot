<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\LessonService;
use app\service\GradeService;
class Lesson extends Base{
	protected $LessonService;
	protected $GradeService;
	public function _initialize(){
		$this->LessonService = new LessonService;
		$this->GradeService = new GradeService;
		parent::_initialize();
	}
    public function test(){
        $is_power = $this->LessonService->isPower(9,1);
    }
    // 可购买
    public function index() {
    	$lesson_id = input('param.lesson_id');
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
     
        $lessonInfo['doms'] =  unserialize($lessonInfo['dom']);
        unset($lessonInfo['dom']);
        $this->assign('lessonInfoJson',json_encode($lessonInfo));
        $this->assign('lessonInfo',$lessonInfo);
        return view('Lesson/index');

    }

    // 可编辑
    public function lessonInfo(){
    	$lesson_id = input('param.lesson_id');
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        $this->assign('lessonInfoJson',json_encode($lessonInfo));
        $this->assign('lessonInfo',$lessonInfo);
        return view('Lesson/lessonInfo');
    }

    //
    public function lessonList(){
        $camp_id = input('param.camp_id');
        $map = [];
        if($camp_id){
            $map['camp_id'] = $camp_id;
        }
        $lessonList = $this->LessonService->getLessonPage($map);
        // 课程类型
        $GradeService = new \app\service\GradeService;
        $gradecateList = $GradeService->getGradeCategory();

        $this->assign('gradecateList',$gradecateList);
        $this->assign('lessonList',$lessonList);
        return view('Lesson/lessonList');
    }

    //编辑课程
    public function updateLesson(){
    	//训练营主教练
    	$camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        if(!$is_power){
            $this->error('您没有权限');
        }
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        $lessonInfo['doms'] = unserialize($lessonInfo['dom']);

    	$coachList = db('grade_member')->where(['type'=>4,'camp_id'=>$camp_id,'status'=>1])->select();
    	$assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
    	$gradeCategoryList = $this->GradeService->getGradeCategory(1);
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['status'=>$camp_id]);
        $this->assign('lessonInfo',$lessonInfo);
    	$this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
    	$this->assign('coachList',$coachList);
    	$this->assign('assitantList',$assitantList);
    	return view('Lesson/updateLesson');
    }

    // 添加课程
    public function createLesson(){
        //训练营主教练
        $camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $coachList = db('grade_member')->where(['type'=>4,'camp_id'=>$camp_id,'status'=>1])->select();
        $assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
        $gradeCategoryList = $this->GradeService->getGradeCategory(1);
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['status'=>$camp_id]);
        // dump($assitantList);die;
        $this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
        $this->assign('coachList',$coachList);
        $this->assign('assitantList',$assitantList);
        return view('Lesson/createLesson');
    }



    // 购买课程
    public function buyLesson(){
        $studentInfo = db('student')->where(['member_id'=>$this->memberInfo['id']])->select();        
        $this->assign('studentInfo',$studentInfo); 
    	return view('Lesson/buyLesson');
    }

    //课程订单支付
    public function comfirmBill(){
        // 生成订单号
        $billOrder = '1'.date('YmrHis',time()).rand(0000,9999);
        // 生成微信参数

        $this->assign('billOrder',$billOrder);
        return view('Lesson/comfirmBill');
    }

    public function bookBill(){
        // 生成订单号
        $billOrder = '1'.date('YmrHis',time()).rand(0000,9999);
        // 生成微信参数

        $this->assign('billOrder',$billOrder);
        return view('Lesson/bookBill');
    }
    // 邀请体验课程
    public function inviteStudent(){
        
        return view('Lesson/inviteStudent');
    }

    public function LessonInfoOfCamp(){
        
    }


    public function lessonListOfCamp(){
        $camp_id = input('param.camp_id');
        // 上架课程
        $onlineLessonList = $this->LessonService->getLessonList(['camp_id'=>$camp_id,'status'=>1]);


        // 下架课程
        $offlineLessonList = $this->LessonService->getLessonList(['camp_id'=>$camp_id,'status'=>-1]);

        $this->assign('onlineLessonList',$onlineLessonList);
        $this->assign('offlineLessonList',$offlineLessonList);
        return view('Lesson/lessonListOfCamp');
    }
}