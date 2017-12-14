<?php
namespace app\service;
use app\model\Exercise;
use app\common\validate\ExerciseVal;
class ExerciseService {
    protected $exerciseModel;

    public function __construct(){
        $this->exerciseModel = new Exercise;
    }
    // 获取训练项目顶级分类
    public function getExerciseType() {
        $result = Exercise::where([ 'camp_id' => 0, 'pid' => 0, 'status' => 1 ])->field(['id', 'exercise'])->order('id asc')->select();
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
        $validate = validate('ExerciseVal');
        $exercise = $data['exercise'];
        $camp_id = $data['camp_id'];
        $validate->extend([
            'exercise'=> function ($exercise,$camp_id) {
                $isUnique = $this->exerciseModel->where(['camp_id'=>$data['camp_id'],'exercise'=>$data['exercise'],'status'=>1])->find();
                return $isUnique?'项目名称已存在':true;
            }
        ]);
        $result = $validate->check($data);
        if(!$result){
            return ['msg'=>$validate->getError(),'code'=>100];
        }
        $res = $this->exerciseModel->save($data);
        if (!$res)
            return ['msg' => __lang('MSG_400'), 'code' => 100];

        return ['msg' => __lang('MSG_200'), 'code' => 100, 'data' => $res];
    }

    // 更新 训练项目数据
    public function updateExercise($data, $condi) {
        $validate = validate('ExerciseVal');
        $exercise = $data['exercise'];
        $camp_id = $data['camp_id'];
        $isUnique = $this->exerciseModel->where(['camp_id'=>$camp_id,'exercise'=>$exercise,'status'=>1])->find();
        if($isUnique){
            return ['msg'=>'项目名已存在','code'=>100];
        }
        $result = $validate->check($data);
        if(!$result){
            return ['msg'=>$validate->getError(),'code'=>100];
        }
        $res = $this->exerciseModel->save($data, $condi);
        if (!$res)
            return ['msg' => __lang('MSG_400'), 'code' => 100];

        return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $res];
    }

    public function createExercise($data){
        $validate = validate('ExerciseVal');
        $exercise = $data['exercise'];
        $camp_id = $data['camp_id'];
        $isUnique = $this->exerciseModel->where(['camp_id'=>$camp_id,'exercise'=>$exercise,'status'=>1])->find();
        if($isUnique){
            return ['msg'=>'项目名已存在','code'=>100];
        }
        $res = $validate->check($data);
        if(!$res){
            return ['msg'=>$validate->getError(),'code'=>100];
        }
        $result = $this->exerciseModel->save($data);
        if($result){
            return ['code'=>200,'msg'=>__lang('MSG_200'),'data'=>$this->exerciseModel->id];
        }else{
            return ['code'=>100,'msg'=>__lang('MSG_400')];
        }
    }

    public function getExerciseList($map = []){
        $res = $this->exerciseModel->where($map)->order('id asc')->select();
        if(!$res){
            return $res;
        }else{
            $result = $this->getExerciseTree($res->toArray(),0);
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
         foreach ($arr as $key => &$value) {
            if($value['pid'] == $pid){
                $value['daughter'] = $this->getExerciseTree($arr,$value['id']);
                $list[] = $value;
            }
        }
        return $list;
    }


    /**
     * 返回权限
     */
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
                    // ->where(function ($query) {
                            // $query->where('type', 2)->whereor('type', 3)->whereor('type',4);})
                    ->value('type');
        return $is_power?$is_power:0;
    }
}