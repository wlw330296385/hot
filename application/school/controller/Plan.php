<?php 
namespace app\school\controller;
use app\school\controller\Base;
use app\service\PlanService;
class Plan extends Base{
	protected $planService;

	public function _initialize(){
		parent::_initialize();
		$this->PlanService = new PlanService;
	}

    public function index() {

        return view('Plan/index');
    }


    public function planInfo(){
    	$plan_id = input('param.plan_id');
        $camp_id = input('camp_id',0);
        $planInfo = $this->PlanService->getPlanInfo(['id'=>$plan_id]);
        $planInfo['exercise_strarr'] = json_decode($planInfo['exercise_str'], true);
        // 判读权限
        $CampService = new \app\service\CampService;
        $is_power = $CampService->isPower($planInfo['camp_id'],$this->memberInfo['id']);
        $campInfo = $CampService->getCampInfo(['id'=>$camp_id]);
        $this->assign('power',$is_power);
        $this->assign('campInfo',$campInfo);
        $this->assign('planInfo',$planInfo);
    	return view('Plan/planInfo');
    }


    //编辑项目
    public function updatePlan(){
    	$plan_id = input('param.plan_id');
        $planInfo = $this->PlanService->getPlanInfo(['id'=>$plan_id]);
        $camp_id = $planInfo['camp_id'];
        $planInfo['exercise_strarr'] = json_decode($planInfo['exercise_str'], true);
        // 判读权限
        $CampService = new \app\service\CampService;

        $is_power = $CampService->isPower($planInfo['camp_id'],$this->memberInfo['id']);
        if($is_power < 2){
            $this->error('您没有权限');
        }   
        $campInfo = $CampService->getCampInfo(['id'=>$camp_id]);    
        // 获取适合阶段
        $gradecateService = new \app\service\GradeService;
        $gradecateList = $gradecateService->getGradeCategory();

        // 获取训练项目列表
        $ExerciseService = new \app\service\ExerciseService;
        $exerciseList = $ExerciseService->getExerciseList(['camp_id'=>$camp_id]);

//    dump($exerciseList);die;
        $this->assign('exerciseList',$exerciseList);
        $this->assign('gradecateList',$gradecateList);
        $this->assign('planInfo',$planInfo);
        $this->assign('campInfo',$campInfo);
    	return view('Plan/updatePlan');
    }

    // 添加教案
    public function createPlan(){
        $camp_id = input('param.camp_id');
        // 判读权限
        $CampService = new \app\service\CampService;
        $is_power = $CampService->isPower($camp_id,$this->memberInfo['id']);
        // dump($is_power);die;
        if($is_power < 2){
            $this->error('您没有权限');
        }       
        // 获取适合阶段
        $gradecateService = new \app\service\GradeService;
        $gradecateList = $gradecateService->getGradeCategory();
        // 训练营信息
        $campInfo = $CampService->getCampInfo(['id'=>$camp_id]);
        // 获取训练项目列表
        $ExerciseService = new \app\service\ExerciseService;
        $exerciseList = $ExerciseService->getExerciseList(['camp_id'=>$camp_id]);


        $this->assign('exerciseList',$exerciseList);
        $this->assign('campInfo',$campInfo);
        $this->assign('gradecateList',$gradecateList);
        return view('Plan/createPlan');
    }


    // 分页获取数据
    public function planList(){
    	$camp_id = input('param.camp_id');
        // $planListOfCamp = $this->PlanService->getPlanList(['camp_id'=>$camp_id,'type'=>1]);
        // $planListOfSys = $this->PlanService->getPlanList(['type'=>0]);
 

        // $this->assign('planListOfCamp',$planListOfCamp);
        // $this->assign('planListOfSys',$planListOfSys);
        $CampService = new \app\service\CampService;
        $is_power = $CampService->isPower($camp_id,$this->memberInfo['id']);
        $campInfo = $CampService->getCampInfo(['id'=>$camp_id]);
        $this->assign('campInfo',$campInfo);
        $this->assign('camp_id',$camp_id);
        return view('Plan/planList');
    }

}