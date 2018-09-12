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

        $this->CampService = new CampService();
		$this->SalaryInService = new SalaryInService($this->memberInfo['id']);
	}

    // 训练营的当月工资单
    public function salaryOfCamp(){
        $camp_id = input('param.camp_id');
        // 获取会员在训练营角色
        $power = $this->CampService->isPower($camp_id,$this->memberInfo['id']);
        if($power <2){
            $this->error('权限不足');
        }


        // 获取当前年/月，用于输出时间筛选
        $y = input('param.year',date('Y',time()));
        $m = input('param.month',date('m',time()));
        // $y = date('Y',time());
        // $m = date('m',time());
        if($power == 2){
            $map = ['camp_member.member_id'=>$this->memberInfo['id'],'camp_member.status'=>1,'camp_member.camp_id'=>$camp_id];
        }else{
            $map = ['camp_member.type'=>['in',[2,4]],'camp_member.status'=>1,'camp_member.camp_id'=>$camp_id];
        }
        // 教练总数和教练列表
        $coachList = db('camp_member')->field('camp_member.member,camp_member.member_id,coach.id as coach_id,coach.coach')->join('coach','coach.member_id = camp_member.member_id')->where($map)->order('camp_member.id desc')->select();
        $coachCount = count($coachList);
        $coachIDs = [];
        $memberIDs = [];
        foreach ($coachList as $key => $value) {
            $coachIDs[] = $value['coach_id'];
            $memberIDs[] = $value['member_id'];
            $coachList[$key]['ss'] = 0;//结算工资
            $coachList[$key]['s'] = 0;//课时工资
            $coachList[$key]['sss'] = 0;//公益课工资
        }

        // 工资总额
        $countSalaryin = $this->SalaryInService->countSalaryin(['camp_id'=>$camp_id,'type'=>1]);
        // 工资列表,由于根据结算时间和上课时间得出的结果不同,因此不可联表查
        $between = getStartAndEndUnixTimestamp($y, $m);

        // 获取结算时间
        $salaryList = db('salary_in')
                    ->field('realname,sum(push_salary+salary) as s_salary,member_id')
                    ->where(['camp_id'=>$camp_id,'type'=>1,'create_time'=>['between',[$between['start'],$between['end']]],'member_id'=>['in',$memberIDs]])
                    ->group('member_id')
                    ->select();
        // echo db('salary_in')->getlastsql();die;
        foreach ($coachList as $k => $val) {
  
            foreach ($salaryList as $key => $value) {

                if($value['member_id'] == $val['member_id']){
                     
                    $coachList[$k]['ss']+=$value['s_salary'];
                }
            }
        }

        // 获取课时工资
        $sacheduleSalaryList = db('schedule')
                ->field('coach_salary,assistant_salary,salary_base,students,coach_id,assistant_id,is_school')
                ->where(['status'=>1,'lesson_time'=>['between',[$between['start'],$between['end']]],'camp_id'=>$camp_id]) 
                ->select();

        foreach ($sacheduleSalaryList as $key => $value) {
            if($value['assistant_id']){
                $sacheduleSalaryList[$key]['a_ids'] = unserialize($value['assistant_id']);
            }else{
                 $sacheduleSalaryList[$key]['a_ids'] = [];
            }
        }


        foreach ($coachList as $k => $val) {
            foreach ($sacheduleSalaryList as $key => $value) {
                
                if($val['coach_id'] == $value['coach_id']){
                    $coachList[$k]['s']+=$value['coach_salary']+$value['salary_base']*$value['students'];
                    if($value['is_school'] == 1){// 这里判断是否公益课
                        $coachList[$k]['sss']+=$value['coach_salary']+$value['salary_base']*$value['students'];
                    }
                }   

                if(in_array($val['coach_id'],$value['a_ids'])){
                    $coachList[$k]['s']+=$value['assistant_salary']+$value['salary_base']*$value['students'];
                    if($value['is_school'] == 1){
                        $coachList[$k]['sss']+=$value['assistant_salary']+$value['salary_base']*$value['students'];
                    }
                }
                
                
            }  
        }   


        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        // dump($coachList);
        $this->assign('y',$y); 
        $this->assign('m',$m);
        $this->assign('coachCount',$coachCount);
        $this->assign('camp_id', $camp_id);
        $this->assign('campInfo', $campInfo);
        $this->assign('coachList', $coachList);
        return view('Salaryin/salaryOfCamp');
    }

    // 当月工资详情
    public function salaryInfo(){
    	// 接收参数 member_id（会员id） year、month（筛选日期和初始日期）
        $camp_id = input('camp_id');
        // 获取会员在训练营角色
        $power = $this->CampService->isPower($camp_id,$this->memberInfo['id']);
        if($power <2){
            $this->error('权限不足');
        }
        $member_id = input('member_id',$this->memberInfo['id']);
        $year = input('year', date('y'));
        $month = input('month', date('m'));
        // 获取教练信息
        $coachS = new CoachService();
        $coachInfo = $coachS->getCoachInfo(['member_id' => $member_id]);
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();

        $scheduleList = db('schedule_member as s')
                    ->field('s.*')
                    ->join('schedule ss','ss.id = s.schedule_id')
                    ->where(['s.member_id'=>$member_id])
                    ->where(['s.type'=>['<>',1]])
                    ->order('s.id desc')
                    ->select();

        
        // 结算总工资:
        $totalSalary = db('salary_in')->where(['camp_id'=>$camp_id,'type'=>1,'member_id'=>$member_id])->sum('salary+push_salary');

        // 课时总工资:
        $totalScheduleSalary1 = db('schedule_member s_m')
                    ->field('s.id')
                    ->join('schedule s','s.id = s_m.schedule_id')
                    ->where(['s_m.camp_id'=>$camp_id,'type'=>3,'member_id'=>$member_id])
                    ->order('s_m.id desc')
                    ->sum('s.assistant_salary+s.salary_base*s.students');
        $totalScheduleSalary2 = db('schedule_member s_m')
                    ->field('s.id')
                    ->join('schedule s','s.id = s_m.schedule_id')
                    ->where(['s_m.camp_id'=>$camp_id,'type'=>2,'member_id'=>$member_id])
                    ->order('s_m.id desc')
                    ->sum('s.coach_salary+s.salary_base*s.students');
        $totalScheduleSalary = $totalScheduleSalary1+$totalScheduleSalary2;


        $this->assign('camp_id', $camp_id);
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign('member_id', $member_id);
        $this->assign('coachInfo', $coachInfo);
        $this->assign('totalSalary', $totalSalary);
        $this->assign('totalScheduleSalary', $totalScheduleSalary);
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