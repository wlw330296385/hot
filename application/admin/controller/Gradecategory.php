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


        return view('gradeCategory/updateGradeCategory');
    }
}