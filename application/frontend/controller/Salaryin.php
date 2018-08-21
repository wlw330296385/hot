<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CampService;
use app\service\CoachService;
use app\service\SalaryInService;

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
        // 教练总数和教练列表
        $coachList = db('camp_member')->where(['type'=>['in',[2,4]],'status'=>1,'camp_id'=>$camp_id])->select();
        $coachCount = count($coachList);

        $coachIDs = [];
        foreach ($coachList as $key => $value) {
            $coachIDs[] = $value['member_id'];
        }
        // 工资总额
        $countSalaryin = $this->SalaryInService->countSalaryin(['camp_id'=>$camp_id,'type'=>1]);
        // 工资列表,由于根据结算时间和上课时间得出的结果不同,因此不可联表查
        $between = getStartAndEndUnixTimestamp($y, $m);

        // 获取结算时间
        $salaryList = db('salary_in')
                    ->field('realname,sum(push_salary+salary) as s_salary,member_id')
                    ->where(['camp_id'=>$camp_id,'type'=>1,'create_time'=>['between',[$between['start'],$between['end']]],'member_id'=>['in',$coachIDs]])
                    ->group('member_id')
                    ->select();

        // dump($salaryList);

        // 获取课时工资
        $sacheduleSalaryList = db('schedule')
                ->field('coach_salary,assistant_salary,salary_base,students,coach_id,assistant_id')
                ->where(['status'=>1,'lesson_time'=>['between',[$between['start'],$between['end']]],'camp_id'=>$camp_id]) 
                ->select();
                // dump($sacheduleSalaryList);die;
        foreach ($sacheduleSalaryList as $key => $value) {
                
             }     
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
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $this->assign('camp_id', $camp_id);
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign('member_id', $member_id);
        $this->assign('coachInfo', $coachInfo);
        $this->assign('campInfo', $campInfo);
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