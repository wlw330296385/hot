<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\SalaryInService;
class Salaryin extends Base{
	private $SalaryInService;
	public function __construct(){
		parent::__construct();
		$this->SalaryInService = new SalaryInService($this->memberInfo['id']);
	}

	public function index(){
		
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $monthRebate = $this->SalaryInService->getReabteByMonth('08',1,2);
            dump(strtotime('-1 month'));die;
            $avreageMonthSalary = $this->SalaryInService->getAverageSalaryByMonth(2);
            $averageYearSalary = $this->SalaryInService->getAverageSalaryByYear(2);
            $this->assign('monthRebate',$monthRebate);
            return view('Salaryin/index');
	}




    // 训练营的当月工资单
    public function salaryOfCamp(){
        $camp_id = input('param.camp_id');
        $start = input('param.start')?input('param.start'):date(strtotime('-1 month'));
        $end = input('param.end')?input('param.end'):date('Y-m-d H:i:s',time());
        $startInt = strtotime($start);
        $endInt = strtotime($end);
        $y = date('Y',time());
        $m = date('m',time());
        $salaryList = $this->SalaryInService->getSalaryInList($startInt,$endInt,['camp_id'=>$camp_id,'type'=>1]);
        // 工资总额
        // $countSalaryin = $this->SalaryInService->countSalaryin(['camp_id'=>$camp_id,'type'=>1,'create_time'=>['BETWEEN',[$startInt,$endInt]]]);
        $countSalaryin = $this->SalaryInService->countSalaryin(['camp_id'=>$camp_id,'type'=>1]);
        // 教练总数

        $this->assign('countSalaryin',$countSalaryin);
        $this->assign('salaryList',$salaryList);   
        $this->assign('y',$y); 
        $this->assign('m',$m);        
        // dump($salaryList);
        return view('Salaryin/salaryOfCamp');
    }

    // 当月工资详情
    public function salaryInfo(){
    	$member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
    	// 组织分成分成:
    	$rebateIn 	= db('rebate')
    				->where(['member_id'=>$member_id])
    				->whereTime('create_time','m')
    				->sum('salary');
    	$scheduleIn = db('salary_in')
    				->where(['member_id'=>$member_id])
    				->where(['type'=>1])
    				->whereTime('create_time','m')
    				->sum('salary');
    	$sellsIn	= db('salary_in')
    				->where(['member_id'=>$member_id])
    				->where(['type'=>2])
    				->whereTime('create_time','m')
    				->sum('salary');
    	$levelAward = db('system_award')
    				->where(['member_id'=>$member_id])
    				->where(['type'=>1])
    				->whereTime('create_time','m')
    				->sum('salary');
    	$rankAward  = db('system_award')
    				->where(['member_id'=>$member_id])
    				->where(['type'=>2])
    				->whereTime('create_time','m')
    				->sum('salary');
    	$totalSalary = $rebateIn+$scheduleIn+$sellsIn+$levelAward+$rankAward;
    	$this->assign('rebateIn',$rebateIn);
    	$this->assign('scheduleIn',$scheduleIn);
    	$this->assign('sellsIn',$sellsIn);
    	$this->assign('levelAward',$levelAward);
    	$this->assign('rankAward',$rankAward);
    	$this->assign('totalSalary',$totalSalary); 
    	return view('Salaryin/salaryInfo'); 
    }



    public function getSalaryInfoByMonthApi(){
        try{
            $start = input('param.start')?input('param.start'):date(strtotime('-1 month'));
            $end = input('param.end')?input('param.end'):date('Y-m-d H:i:s',time());
            $startInt = strtotime($start);
            $endInt = strtotime($end);
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            // 组织分成分成:
            $rebateIn   = $this->SalaryInService->getReabteByMonth($startInt,$endInt,$member_id);
            $scheduleIn = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            $sellsIn    = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            $levelAward = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            $rankAward  = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);   
            $totalSalary = $rebateIn+$scheduleIn+$sellsIn+$levelAward+$rankAward;
            return json(['code'=>100,'msg'=>'ok','data'=>['rebateIn'=>$rebateIn,'scheduleIn'=>$scheduleIn,'sellsIn'=>$sellsIn,'levelAward'=>$levelAward,'rankAward'=>$rankAward,'totalSalary'=>$totalSalary]]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }


    // 教学明细
    public function salaryList(){
        $start = input('param.start')?input('param.start'):date(strtotime('-1 month'));
        $end = input('param.end')?input('param.end'):date('Y-m-d H:i:s',time());
        $startInt = strtotime($start);
        $endInt = strtotime($end);
        $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
        $salaryList = $this->SalaryInService->getSalaryList($startInt,$endInt,['member_id'=>$member_id,'type'=>1]);
        $count = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);   
        $this->assign('count',$count);
        $this->assign('salaryList',$salaryList);
        return view('Salaryin/salaryList');
    }


    // 商品推荐|分成
    public function goodsSalary(){

        //销售提成
        $start = input('param.start')?input('param.start'):date(strtotime('-1 month'));
        $end = input('param.end')?input('param.end'):date('Y-m-d H:i:s',time());
        $startInt = strtotime($start);
        $endInt = strtotime($end);
        $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
        // 组织分成分成:
        $rebateIn   = $this->SalaryInService->getRebateList($startInt,$endInt,$member_id);
        // 销售提成
        $sellsIn    = $this->SalaryInService->getGoodsSellList($startInt,$endInt,$member_id); 
        // dump($rebateIn);die;
        $this->assign('sellsIn',$sellsIn);
        $this->assign('rebateIn',$rebateIn);
        return view('Salaryin/goodsSalary');
    }

    // 教练工资
    public function coachSalaryOfCamp(){
        $coach_id = input('param.coach_id');
        $camp_id = input('param.coach_id');
        $coachInfo = db('coach')->where(['id'=>$coach_id])->find();


        $this->assign('coachInfo',$coachInfo);
        return view('Salaryin/coachSalaryOfCamp');
    }

    // 教练年薪
    public function coachSalaryOfYear(){

        return view('Salaryin/coachSalaryOfYear');
    }
}