<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\ExerciseService;
class Exercise extends Base{
	protected $ExerciseService;
    
	public function _initialize(){
		parent::_initialize();
		$this->ExerciseService = new ExerciseService;
	}


    // 获取列表
    public function getExerciseListApi(){
        try{
            $map= input('post.');
            $result = $this->ExerciseService->getExerciseList($map);
            if($result){
                return json(['data'=>$result,'code'=>200,'msg'=>'OK']);
            }else{
                return json(['code'=>100,'msg'=>'未获取到数据']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
        
    }

    // 编辑项目
    public function updateExerciseApi(){
        try{
            $data = input('post.');
            $exercise_id = input('param.exercise_id');
            if($exercise_id){
                $result = $this->ExerciseService->updateExercise($data,['id'=>$exercise_id]);
            }else{
                $result = $this->ExerciseService->createExercise($data);
            }
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //获取列表带分页
    public function getExerciseListByPageApi(){
        try{
            $map= input('post.');
            $result = $this->ExerciseService->getExerciseListByPage($map);
            if($result){
                return json(['data'=>$result,'code'=>200,'msg'=>'OK']);
            }else{
                return json(['code'=>100,'msg'=>'未获取到数据']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}