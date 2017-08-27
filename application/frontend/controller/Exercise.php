<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ExerciseService;
class Exercise extends Base{
	protected $ExerciseService;
    
	public function _initialize(){
		parent::_initialize();
		$this->ExerciseService = new ExerciseService;
	}

    public function index() {

        return view();
    }


    public function exerciseInfo(){
    	$exercise_id = input('param.exercise_id');
    	$exerciseInfo = $this->ExerciseService->getExerciseInfo(['id'=>$exercise_id]);
        // 获取类型
        $exercisePInfo =  $this->ExerciseService->getExerciseInfo(['id'=>$exerciseInfo['pid']]);
        $this->assign('exercisePInfo',$exercisePInfo);
        $this->assign('exerciseInfo',$exerciseInfo);
    	return view();
    }


    //编辑项目
    public function updateExercise(){
    	   
    	$exercise_id = input('param.exercise_id');
		$ExerciseInfo = $this->ExerciseService->getExerciseInfo(['id'=>$exercise_id]);
        if($ExerciseInfo['pid']==0){
            $this->error('系统训练项目不允许编辑');
        }
        // 分类
        $ExerciseType = $this->ExerciseService->getExerciseType();

        $this->assign('ExerciseType',$ExerciseType);
		$this->assign('ExerciseInfo',$ExerciseInfo);
    	return view();
    }

    // 项目列表
    public function exerciseList(){

    	$result = $this->ExerciseService->getExerciseList();
        $this->assign('ecerciseList',$result);
    }


    public function exerciseListApi(){
        $result = $this->ExerciseService->getExerciseList();
        if($result){
            return json(['data'=>$result,'code'=>100,'msg'=>'OK']);
        }else{
            return json(['code'=>200,'msg'=>'未获取到数据']);
        }
        
    }


}