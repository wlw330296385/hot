<?php
namespace app\service;
use app\model\Exercise;

class ExerciseService {
    protected $exerciseList;

    public function __construct(){
        // $this->exerciseList = [];
    }
    // 获取训练项目顶级分类
    public function getExeriseType() {
        $res = Exercise::where([ 'camp_id' => 0, 'pid' => 0, 'status' => 1 ])->field(['id', 'exercise'])->select();
        if (!$res)
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];
        if ($res->isEmpty())
            return ['msg' => __lang('MSG_000_NULL'), 'code' => '000', 'data' => ''];
        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }

    // 获取训练项目所有数据
    public function getExeriseAll() {
        $res = Exercise::all();
        //dump($res->toArray());
        if (!$res)
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];
        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }

    public function getExeriseOne($condi) {
        $res = Exercise::get($condi);
        //dump($res);
        if (!$res)
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];
        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }

    // 新增 训练项目数据
    public function addExerise($data) {
        $model = new Exercise();
        $res = $model->save($data);
        //dump($res);
        if (!$res)
            return ['msg' => __lang('MSG_200_ERROR'), 'code' => 200];

        return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $res];
    }

    // 更新 训练项目数据
    public function updateExerise($data, $condi) {
        $model = new Exercise();
        $res = $model->save($data, $condi);
        if (!$res)
            return ['msg' => __lang('MSG_200_ERROR'), 'code' => 200];

        return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $res];
    }


    public function getExerciseList(){
        $res = Exercise::all();
        if($result){
            return $result;
        }else{
            $result = $this->getExerciseTree($res->toArray());
            return $result;
        }
    }

    protected function getExerciseTree($arr = [],$pid = 0){
        $list = [];
         foreach ($arr as $key => $value) {
            if($value['pid'] == $pid){
                $value['daughter'] = $this->getExercise($arr,$value['id']);
               $list[] = $value;
            }
        }
        return $list;
    }



}