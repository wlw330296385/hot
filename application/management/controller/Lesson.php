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
                $this->success('操作成功');
            }else{
                $this->error('操作失败');
            }
        }else{

            // 课程分类
            $GradeCategoryService = new \app\service\GradeCategoryService;
            $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();

            
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


        $this->assign('lessonInfo',$lessonInfo);
        return view('Lesson/lessonInfo');
}

	public function updateLesson(){
		$lesson_id = input('param.lesson_id');
        $LessonService = new \app\service\LessonService;
        if(request()->isPost()){
            $data = input('post.');
            $result = $LessonService->updateLesson($data,$lesson_id);
            if ($result['code'] == 200) {
                // $this->success('成功','lesson/index');
                echo "<script>alert('操作成功');window.location.href='".url('lesson/index')."';</script>";
            }else{
                // $this->error('失败');
                echo "<script>alert('操作失败')</script>";
            }
        }else{

            $lessonInfo = $LessonService->getLessonInfo(['id'=>$lesson_id]);

            // 课程分类
            $GradeCategoryService = new \app\service\GradeCategoryService;
            $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();

            $this->assign('lessonInfo',$lessonInfo);
            $this->assign('gradeCategoryList',$gradeCategoryList);
            return view('Lesson/updateLesson');
        }
	}
}