<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ExerciseService;
use app\service\CampService;
class Exercise extends Base{
	protected $ExerciseService;
    
	public function _initialize(){
		parent::_initialize();
		$this->ExerciseService = new ExerciseService;
	}

    public function index() {

        return view('Exercise/index');
    }


    public function exerciseInfo(){
    	$exercise_id = input('param.exercise_id');
        $camp_id = input('param.camp_id',0);
    	$exerciseInfo = $this->ExerciseService->getExerciseInfo(['id'=>$exercise_id]);
        $power = $exerciseInfo['member_id'] == $this->memberInfo['id'] ? 1 : 0;
        $CampService = new CampService();
        $campInfo = $CampService->getCampInfo($camp_id);
        // 获取类型
        $exercisePInfo =  $this->ExerciseService->getExerciseInfo(['id'=>$exerciseInfo['pid']]);
        $this->assign('exercisePInfo',$exercisePInfo);
        $this->assign('exerciseInfo',$exerciseInfo);
        $this->assign('power', $power);
        $this->assign('campInfo',$campInfo);
    	return view('Exercise/exerciseInfo');
    }

    //创建项目
    public function createExercise(){
        $camp_id = input('param.camp_id',0);
        $CampService = new CampService();
        $campInfo = $CampService->getCampInfo(['id'=>$camp_id]);
        // 分类
        $exerciseType = $this->ExerciseService->getExerciseType();

        $this->assign('exerciseType',$exerciseType);
        $this->assign('campInfo',$campInfo);
    	return view('Exercise/createExercise');
    }

    //编辑项目
    public function updateExercise(){
    	$exercise_id = input('param.exercise_id');
		$exerciseInfo = $this->ExerciseService->getExerciseInfo(['id'=>$exercise_id]);
        if($exerciseInfo['camp_id']==0){
            $this->error('系统训练项目不允许编辑');
        }

        // 权限判断
        $power = $this->ExerciseService->isPower($exerciseInfo['camp_id'],$this->memberInfo['id']);
        if($power<2){
            $this->error('权限不足');
        }
        $CampService = new CampService();
        $campInfo = $CampService->getCampInfo(['id'=>$exerciseInfo['camp_id']]);
        // 分类
        $exerciseType = $this->ExerciseService->getExerciseType();
        $this->assign('power',$power);
        $this->assign('campInfo',$campInfo);
        $this->assign('exerciseType',$exerciseType);
		$this->assign('exerciseInfo',$exerciseInfo);
    	return view('Exercise/updateExercise');
    }

    // 项目列表
    public function exerciseList(){
        $camp_id = input('param.camp_id',0);
        $CampService = new CampService();
        $campInfo = $CampService->getCampInfo(['id'=>$camp_id]);

    	$myExerciseList = $this->ExerciseService->getExerciseList(['camp_id'=>$camp_id]);
        $sysExerciseList = $this->ExerciseService->getExerciseList(['camp_id'=>0]);
        $this->assign('myExerciseList',$myExerciseList);
        $this->assign('sysExerciseList',$sysExerciseList);
        // dump($sysExerciseList);die;
        $this->assign('campInfo',$campInfo);
        // dump($campInfo);die;
        return view('Exercise/exerciseList');
    }




}