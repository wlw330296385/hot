<?php 
namespace app\frontend\controller;
use app\frontend\controller\Frontend;
use app\service\PlanService;
class Plan extends Frontend{
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
    	$planInfo = $this->PlanService->PlanOneById(['id'=>$plan_id]);
        $planInfo['exerciseList'] = unserialize($planInfo['exercise']);
        $this->assign('planInfo',$planInfo);
    	return view('Plan/planInfo');
    }


    //编辑项目
    public function updatePlan(){
    	
    	$plan_id = input('param.plan_id');
        $planInfo = $this->PlanService->PlanOneById(['id'=>$plan_id]);
        // 获取适合阶段
        $gradecateService = new \app\service\GradeService;
        $gradecateList = $gradecateService->getGradeCategory();
        $exerciseService = new \app\service\ExerciseService;
        $exerciseList = $exerciseService->getExerciseList();
        // 训练项目
        $this->assign('exerciseList',$exerciseList);
        $this->assign('gradecateList',$gradecateList);
        $this->assign('planInfo',$planInfo);

    	return view('Plan/updatePlan');
    }

    // 分页获取数据
    public function planList(){
    	$camp_id = input('param.camp_id');
    	$planListOfCamp = $this->PlanService->PlanListPage(['camp_id'=>$camp_id,'type'=>1]);
    	$planListOfSys = $this->PlanService->PlanListPage(['type'=>0]);
        $this->assign('planListOfCamp',$planListOfCamp);
        $this->assign('planListOfSys',$planListOfSys);
        return view('Plan/planList');
    }


    public function planListApi(){
        $map = input('post.');
        $planList = $this->PlanService->PlanListPage($map,10);
        return json($planList);
    }
}