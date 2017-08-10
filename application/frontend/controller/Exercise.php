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
    	$id = input('id');
    	$result = $this->ExerciseService->ExerciseOneById(['id'=>$id]);
    	return view();
    }


    //编辑项目
    public function updateExercise(){
    	
    	$id = input('id');
		$ExerciseInfo = $this->ExerciseService->ExerciseOneById(['id'=>$id]);
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