<?php
namespace app\service;
use app\model\Exercise;

class ExerciseService {
    protected $exerciseModel;

    public function __construct(){
        $this->exerciseModel = new Exercise;
    }
    // 获取训练项目顶级分类
    public function getExerciseType() {
        $result = Exercise::where([ 'camp_id' => 0, 'pid' => 0, 'status' => 1 ])->field(['id', 'exercise'])->select();
        if($result){
            return $result->toArray();
        }else{
            return $result;
        }
    }


    public function getExerciseInfo($condi) {
        $result = Exercise::get($condi);
        if($result){
            return $result->toArray();
        }else{
            return $result;
        }
    }

    // 新增 训练项目数据
    public function addExercise($data) {
        $model = new Exercise();
        $res = $model->save($data);
        //dump($res);
        if (!$res)
            return ['msg' => __lang('MSG_200_ERROR'), 'code' => 200];

        return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $res];
    }

    // 更新 训练项目数据
    public function updateExercise($data, $condi) {
        $model = new Exercise();
        $res = $model->save($data, $condi);
        if (!$res)
            return ['msg' => __lang('MSG_200_ERROR'), 'code' => 200];

        return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $res];
    }

    public function createExercise($data){
        $result = $this->exerciseModel->save($data);
        if($result){
            return ['code'=>100,'msg'=>__lang('MSG_101_SUCCESS'),'data'=>$result];
        }else{
            return ['code'=>200,'msg'=>__lang('MSG_201_DBNOTFOUND')];
        }
    }

    public function getExerciseList($p = 10){
        $res = Exercise::all();
        if(!$res){
            return $res;
        }else{
            $result = channelLevel($res->toArray(),0,'id','pid');
            return $result;
        }
    }


    // 获取训练营下的训练项目
    public function getExerciseListOfCamp($camp_id){
        $res = $this->exerciseModel->where(function($query) use($camp_id){
            $query->where('camp_id','eq',0)->whereOr('camp_id','eq',$camp_id);
        })->select();

        if(!$res){
            return $res;
        }else{
            
            $result = channelLevel($res->toArray(),0,'id','pid');
            return $result;
        }
    }

    protected function getExerciseTree($arr = [],$pid = 0){
        $list = [];
         foreach ($arr as $key => $value) {
            if($value['pid'] == $pid){
                $value['daughter'] = $this->getExerciseTree($arr,$value['id']);
              
            } 
            $list[] = $value;
        }
        return $list;
    }



}