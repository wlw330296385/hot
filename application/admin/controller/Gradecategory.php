<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use think\Db;
use app\service\GradeCategoryService;
class Gradecategory extends Backend {
    public $GradeCategoryService;
    public function _initialize(){
        parent::_initialize();
        $this->GradeCategoryService = new GradeCategoryService;
    }
    
    public function index() {

    }

    // 班级类型管理
    public function gradeCategoryList(){

        $gradeCategoryList = $this->GradeCategoryService->getGradeCategoryList();
        $this->assign('gradeCategoryList',$gradeCategoryList);
        return view('gradeCategory/gradeCategoryList');
    }


    // 班级类型详情
    public function gradeCategory(){


        return view('gradeCategory/gradeCategory');
    }

    // 更新班级类型
    public function updateGradeCategory(){
        $gradeCategory_id = input('param.gradeCategory_id');

        if(request()->isPost()){
            $data = input('post.');
            if($gradeCategory_id){
                $result = $this->GradeCategoryService->updateGradeCategory($data,$gradeCategory_id);
            }else{
                $result = $this->GradeCategoryService->createGradeCategory($data);
            }
            
            if ($result['code']==200) {
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $gradeCategoryP = $this->GradeCategoryService->getGradeCategoryP(['pid'=>0]);
            $this->assign('gradeCategoryP',$gradeCategoryP);
            if($gradeCategory_id){

                $gradeCategoryInfo = $this->GradeCategoryService->getGradeCategoryInfo(['id'=>$gradeCategory_id]);
                $this->assign('gradeCategoryInfo',$gradeCategoryInfo);
                return view('gradeCategory/updateGradeCategory');
            }else{
                return view('gradeCategory/createGradeCategory');
            }
        }       
    }

    // 更新班级类型
    public function updateGradeCategoryP(){
        $gradeCategory_id = input('param.gradeCategory_id');

        if(request()->isPost()){
            $data = input('post.');
            if($gradeCategory_id){
                $result = $this->GradeCategoryService->updateGradeCategory($data,$gradeCategory_id);
            }else{
                $result = $this->GradeCategoryService->createGradeCategory($data);
            }
            
            if ($result['code']==200) {
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            if($gradeCategory_id){

                $gradeCategoryInfo = $this->GradeCategoryService->getGradeCategoryInfo(['id'=>$gradeCategory_id]);
                $this->assign('gradeCategoryInfo',$gradeCategoryInfo);
                return view('gradeCategory/updateGradeCategoryP');
            }else{
                return view('gradeCategory/createGradeCategoryP');
            }
        }       
    }

    // 删除班级类型
    public function del(){
        $ids = input('post.');
        
    }
}