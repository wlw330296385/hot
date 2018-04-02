<?php 
namespace app\management\controller;
use app\management\controller\Backend;
use think\helper\Time;

/**
* 引导页
*/
class Index extends Backend
{
	
	function _initialize()
	{
		parent::_initialize();
	}

	public function index(){

		$campInfo = db('camp')->where(['id'=>$this->camp_member['camp_id']])->find();

		// 一个月的收益
		$monthIncome = db('income')->where(['camp_id'=>$this->camp_member['camp_id']])->whereTime('create_time','m')->where('delete_time',null)->sum('income');
		if($campInfo['rebate_type'] == 2){
			$monthOutput = db('output')->where(['camp_id'=>$this->camp_member['camp_id']])->where('type',
				'not in',[-1,-2,3])->whereTime('create_time','m')->where('delete_time',null)->sum('output');
			$monthOutput = $monthOutput?$monthOutput:0;
			$monthIncome = $monthIncome - $monthOutput;
		}		
		// 总收益
		$totalIncome = db('income')->where(['camp_id'=>$this->camp_member['camp_id']])->where('delete_time',null)->sum('income');
		// 赠课总人数
		$totalGift = db('schedule_giftrecord')->where(['camp_id'=>$this->camp_member['camp_id']])->where('delete_time',null)->sum('student_num');
		// 上课总人次
		$totalStudents = db('schedule')->where(['camp_id'=>$this->camp_member['camp_id']])->where('delete_time',null)->sum('students');
		//总课时
		$totalSchedule = db('schedule')->where(['camp_id'=>$this->camp_member['camp_id']])->where('delete_time',null)->count('id');


		
		// 月营业额总量曲线图
		$billList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m%d') as days,goods_type")->where(['camp_id'=>$this->camp_member['camp_id'],'is_pay'=>1])->whereTime('create_time','m')->group('days')->select();
		$month = Time::month();
		$lessonBill = [];
		$eventBill = [];

		$dateStart = date('Ymd',$month[0]);
		$dateEnd = date('Ymd',$month[1]);
		for ($i=$dateStart; $i <= $dateEnd ; $i++) { 
			$lessonBill[] = 0;
			$eventBill[] = 0;
		}

		foreach ($billList as $key => $value) {
			$kk = $value['days'] - $dateStart;
			if($value['goods_type'] == 1){
				
				// echo "$kk------{$value['days']}---{$value['s_balance_pay']}<br/>";
				$lessonBill[$kk] = $value['s_balance_pay'];

			}elseif ($value['goods_type'] == 2) {
				$eventBill[$kk] = $value['s_balance_pay'];
			}
		}



		// 教学点分布
		$gradeCourt = db('grade')->field('sum(students) as s_students,court')->where(['status'=>1,'camp_id'=>$this->camp_member['camp_id']])->group('court_id')->select();
		$gradeCourtData = [];
		foreach ($gradeCourt as $key => $value) {
			$gradeCourtData['legend'][] = $value['court'];
			$gradeCourtData['series'][] = ['value'=>$value['s_students'],'name'=>$value['court']];
		}


		// 课程购买饼图
		$lessonBuy = db('bill')->field("sum(total) as s_total,goods,goods_id")->where(['camp_id'=>$this->camp_member['camp_id'],'is_pay'=>1,'goods_type'=>1])->group('goods_id')->select();
		$lessonBuyData = [];
		foreach ($lessonBuy as $key => $value) {
			$lessonBuyData['legend'][] = $value['goods'];
			$lessonBuyData['series'][] = ['value'=>$value['s_total'],'name'=>$value['goods']];
		}


		// 年营业额折线图
		$billMonthList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m') as month,goods_type")->where(['camp_id'=>$this->camp_member['camp_id'],'is_pay'=>1])->whereTime('create_time','y')->group('month')->select();
		$month = Time::year();
		$lessonBillYear = [];
		$eventBillYear = [];

		$dateStartMonth = date('Ym',$month[0]);
		$dateEndMonth = date('Ym',$month[1]);
		for ($i=$dateStartMonth; $i <= $dateEndMonth ; $i++) { 
			$lessonBillYear[] = 0;
			$eventBillYear[] = 0;
		}

		foreach ($billMonthList as $key => $value) {
			$kk = $value['month'] - $dateStartMonth;
			if($value['goods_type'] == 1){
				$lessonBillYear[$kk] = $value['s_balance_pay'];

			}elseif ($value['goods_type'] == 2) {
				$eventBillYear[$kk] = $value['s_balance_pay'];
			}
		}



		// 学员总人数折线图(年)	
		$year = Time::year();
		$yearStart = date('Ym',$year[0]);
		$yearEnd = date('Ym',$year[1]);
		$monthlyStudentsData = [0,0,0,0,0,0,0,0,0,0,0,0];
		$monthly_students = db('monthly_students')->where(['camp_id'=>$this->camp_member['camp_id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->column('online_students');
		foreach ($monthly_students as $key => $value) {
			$monthlyStudentsData[$key] = $value;
		}


		$monthlyCourtStudentsData = [];
		$monthly_court_students = db('monthly_court_students')->where(['camp_id'=>$this->camp_member['camp_id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->select();
		foreach ($monthly_court_students as $key => $value) {
			$monthlyCourtStudentsData[$key] = $value;
		}
		
		
		$this->assign('monthlyCourtStudentsData',json_encode($monthlyCourtStudentsData));
		$this->assign('monthlyStudentsData',json_encode($monthlyStudentsData));
		$this->assign('lessonBuyData',json_encode($lessonBuyData,true));
		$this->assign('gradeCourtData',json_encode($gradeCourtData,true));
		$this->assign('lessonBillYear',json_encode($lessonBillYear));
		$this->assign('eventBillYear',json_encode($eventBillYear));
		$this->assign('lessonBill',json_encode($lessonBill));
		$this->assign('eventBill',json_encode($eventBill));
		$this->assign('monthIncome',$monthIncome);
		$this->assign('totalIncome',$totalIncome);
		$this->assign('totalGift',$totalGift);
		$this->assign('totalStudents',$totalStudents);
		$this->assign('totalSchedule',$totalSchedule);
		return view('Index/index');
	}

	
}