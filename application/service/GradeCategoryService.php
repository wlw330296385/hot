<?php
namespace app\service;
use app\model\GradeCategory;

class GradeCategoryService {
    protected $GradeCategory;
    
    public function __construct(){
        $this->GradeCategory = new GradeCategory;
    }
    // 获取班级|课程类型顶级分类
    public function getGradeCategoryP(){
        $res = $this->GradeCategory->where(['pid'=>0])->select();
        if(!$res){
            return $res;
        }else{
            $result = $res->toArray();
            return $result;
        }
    }    


    // 获取班级|课程类型
    public function getGradeCategoryInfo($map){
        $res = $this->GradeCategory->where($map)->find();
        if(!$res){
            return $res;
        }else{
            $result = $res->toArray();
            return $result;
        }
    }   

    public function getGradeCategoryList(){
        $res = $this->GradeCategory->select();
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

    public function updateGradeCategory($data,$GradeCategory_id){
        

        $result = $this->GradeCategory->save($data,['id'=>$GradeCategory_id]);
        if($result){
            $name = $data['name'];
            $pid = $data['pid'];
            if($pid==0){

            }else{
                db('lesson')->where(['gradecate_id'=>$GradeCategory_id])->update(['gradecate'=>$name]);
            }
            
            return ['code'=>200,'msg'=>'操作成功'];
        }else{
            return ['code'=>100,'msg'=>'操作失败'];
        }
    }

    public function createGradeCategory($data){
        $result = $this->GradeCategory->save($data);
        if($result){
            return ['code'=>200,'msg'=>'操作成功','data'=>$this->GradeCategory->id];
        }else{
            return ['code'=>100,'msg'=>'操作失败'];
        }
    }
}