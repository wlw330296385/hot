<?php
namespace app\service;
use app\model\GradeCategory;

class GradeCategoryService {
    protected $GradeCategoryList;
    
    public function __construct(){
        // $this->GradeCategoryList = [];
    }
    // 获取训练项目顶级分类



    public function getGradeCategoryList(){
        $res = GradeCategory::all();
        if(!$res){
            return $res;
        }else{
            $result = $this->getGradeCategoryTree($res->toArray());
            return $result;
        }
    }

    protected function getGradeCategoryTree($arr = [],$pid = 0){
        $list = [];
         foreach ($arr as $key => $value) {
            if($value['pid'] == $pid){
                $value['daughter'] = $this->getGradeCategoryTree($arr,$value['id']);
               $list[] = $value;
            }
        }
        return $list;
    }


}