<?php 
namespace app\school\controller;
use app\school\controller\Base;
use app\school\serviceCampService;
use app\school\serviceCoachService;
use app\school\serviceSalaryInService;
use think\helper\Time;

class Salaryin extends Base{
	private $SalaryInService;
	public function __construct(){
		parent::__construct();
		$this->SalaryInService = new SalaryInService($this->memberInfo['id']);
	}

    // 训练营的当月工资单
    public function salaryOfCamp(){
        $camp_id = input('param.camp_id');
        // 获取当前年/月，用于输出时间筛选
        $y = date('Y',time());
        $m = date('m',time());
        // 教练总数
        $campS = new CampService();
        $coachList = $campS->getCoachList($camp_id);
        $coachCount = count($coachList);
        // 工资总额
        // $countSalaryin = $this->SalaryInService->countSalaryin(['camp_id'=>$camp_id,'type'=>1,'create_time'=>['BETWEEN',[$startInt,$endInt]]]);
        $countSalaryin = $this->SalaryInService->countSalaryin(['camp_id'=>$camp_id,'type'=>1, 'member_type' => 4]);
        // 工资列表 api读取数据
        
        $this->assign('countSalaryin',$countSalaryin);
        $this->assign('y',$y); 
        $this->assign('m',$m);
        $this->assign('coachCount',$coachCount);
        $this->assign('camp_id', $camp_id);
        return view('Salaryin/salaryOfCamp');
    }

    // 当月工资详情
    public function salaryInfo(){
    	// 接收参数 member_id（会员id） year、month（筛选日期和初始日期）
        $camp_id = input('camp_id');
        $member_id = input('member_id');
        $year = input('year', date('y'));
        $month = input('month', date('m'));
        // 获取教练信息
        $coachS = new CoachService();
        $coachInfo = $coachS->getCoachInfo(['member_id' => $member_id]);

        $this->assign('camp_id', $camp_id);
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign('coachInfo', $coachInfo);
    	return view('Salaryin/salaryInfo'); 
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
}