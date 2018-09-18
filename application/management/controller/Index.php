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
		$Time = new Time;
		$campInfo = db('camp')->where(['id'=>$this->camp_member['camp_id']])->find();
		if($campInfo['rebate_type'] == 2){//营业额版
			// 一个月的收益
			$monthIncome = db('income')->where(['camp_id'=>$campInfo['id']])->whereTime('create_time','m')->where('delete_time',null)->sum('income');
			$monthOutput1 = db('output')->where(['camp_id'=>$campInfo['id']])->where('type',
				'not in',[-1,-2])->whereTime('create_time','m')->where('delete_time',null)->sum('output');
			$monthOutput2 = 0;
			// $monthOutput2 = db('output')->where(['camp_id'=>$campInfo['id']])->where('type',
			// 	3)->whereTime('schedule_time','m')->where('delete_time',null)->sum('output');
			$monthOutput1 = $monthOutput1?$monthOutput1:0;
			// $monthOutput2 = $monthOutput2?$monthOutput2:0;
			$monthIncome = $monthIncome - $monthOutput1-$monthOutput2;
			// 总收益
			$totalIncome = db('income')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->sum('income');
			// 总支出
			$totalOuput = db('output')->where(['camp_id'=>$campInfo['id']])->where('type',
				'not in',[-1,-2])->where('delete_time',null)->sum('output');
			$totalOuput = $totalOuput?$totalOuput:0;
			$totalIncome = $totalIncome - $totalOuput;
		}else{//课时版
			// 一个月的收益
			$monthIncome = db('income')->where(['camp_id'=>$campInfo['id'],'type'=>3])->whereTime('schedule_time','m')->where('delete_time',null)->sum('income');
			// 总收益
			$totalIncome = db('income')->where(['camp_id'=>$campInfo['id'],'type'=>3])->where('delete_time',null)->sum('income');
		}	
		
		// 赠课总人数
		$totalGift = db('schedule_giftrecord')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->sum('student_num');
		
		
		//总已上课量
		$totalSchedule = 0;
		$totalScheduleList = db('schedule')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->select();
		$totalSchedule = count($totalScheduleList);
		// 上课总人次
		$totalStudents = 0;
		foreach ($totalScheduleList as $key => $value) {
			$totalStudents+=$value['students'];
		}
		//本月已上课量
		$monthSchedule = 0;
		$monthScheduleList = db('schedule')->where(['camp_id'=>$campInfo['id']])->whereTime('lesson_time','m')->where('delete_time',null)->select();
		$monthSchedule = count($monthScheduleList);
		// 本月上课总人次
		$monthStudents = 0;
		foreach ($monthScheduleList as $key => $value) {
			$totalStudents+=$value['students'];
		}
		// 总营业额
		$totalBill = db('bill')->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->sum('balance_pay');
		//本月营业额
		$monthBill = db('bill')->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('pay_time','m')->sum('balance_pay');
		// 在学会员
		$monthCampStudents = db('monthly_students')->where(['camp_id'=>$campInfo['id']])->limit(2)->select();
		// 本月新增会员
		$monthNewStudents = 0;
		//本月离营学员
		$monthofflineStudents = 0;
		//在学会员
		$onlineStudents = 0;
		if (count($monthCampStudents) == 2) {
			$monthNewStudents = $monthCampStudents[0]['online_students'] - $monthCampStudents[1]['online_students'];
			$monthofflineStudents = $monthCampStudents[0]['offline_students'] - $monthCampStudents[1]['offline_students'];
			$onlineStudents = $monthCampStudents[0]['onlesson_students'];
		}elseif (count($monthCampStudents) == 1){
			$monthNewStudents = $monthCampStudents[0]['online_students'];
			$monthofflineStudents = $monthCampStudents[0]['offline_students'];
			$onlineStudents = $monthCampStudents[0]['onlesson_students'];
		}
		

	



		// 月营业额总量曲线图
		$billList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m%d') as days,goods_type")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('create_time','m')->group('days')->select();
		$month = $Time::month();
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
		$gradeCourt = db('grade')->field('sum(students) as s_students,court')->where(['status'=>1,'camp_id'=>$campInfo['id']])->group('court_id')->select();
	
		$gradeCourtData = [
			'legend'=>[],
			'series'=>[],	
		];
		foreach ($gradeCourt as $key => $value) {
			$gradeCourtData['legend'][] = $value['court'];
			$gradeCourtData['series'][] = ['value'=>$value['s_students'],'name'=>$value['court']];
		}

		// dump($gradeCourtData);die;
		// 课程购买饼图
		$lessonBuy = db('bill')->field("sum(total) as s_total,goods,goods_id")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1,'goods_type'=>1])->group('goods_id')->select();
		$lessonBuyData = [
			'legend'=>[],
			'series'=>[],	
		];
		foreach ($lessonBuy as $key => $value) {
			$lessonBuyData['legend'][] = $value['goods'];
			$lessonBuyData['series'][] = ['value'=>$value['s_total'],'name'=>$value['goods']];
		}


		// 年营业额折线图
		$billMonthList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m') as month,goods_type")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('create_time','y')->group('month')->select();
		$month = $Time::year();
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
		$year = $Time::year();
		$yearStart = date('Ym',$year[0]);
		$yearEnd = date('Ym',$year[1]);
		$monthlyStudentsData = [0,0,0,0,0,0,0,0,0,0,0,0];
		$monthly_students = db('monthly_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->column('online_students');
		foreach ($monthly_students as $key => $value) {
			$monthlyStudentsData[$key] = $value;
		}

		//每月学生场地
		$monthlyCourtStudent = [];
		$monthData = [0,0,0,0,0,0,0,0,0,0,0,0];
		$monthly_court_students = db('monthly_court_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->select();
		$monthlyCourtStudentsData = db('monthly_court_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->group('court_id')->select();
		// 初始化
		$list = [];
		foreach ($monthlyCourtStudentsData as $key => $value) {
			$list[$key]['type'] = 'line';
			$list[$key]['name'] = $value['court'];
			$list[$key]['data'] = $monthData;
			$m = substr($value['date_str'],-2,2);
			$monthlyCourtStudent['legend'][] = $value['court'];
		}

		foreach ($list as $key => $value) {
			
			foreach ($monthly_court_students as $k => $val) {
				$m = (int)substr($val['date_str'],-2,2);
				if($val['court']==$value['name']){
					$list[$key]['data'][$m] = $val['students'];
				}
			}
		}
		$monthlyCourtStudent['data'] = $list;
		$this->assign('monthlyCourtStudent',json_encode($monthlyCourtStudent,true));
		$this->assign('monthlyStudentsData',json_encode($monthlyStudentsData,true));
		$this->assign('lessonBuyData',json_encode($lessonBuyData,true));
		$this->assign('gradeCourtData',json_encode($gradeCourtData,true));
		$this->assign('lessonBillYear',json_encode($lessonBillYear));
		$this->assign('eventBillYear',json_encode($eventBillYear));
		$this->assign('lessonBill',json_encode($lessonBill));
		$this->assign('eventBill',json_encode($eventBill));

		$this->assign('monthBill',$monthBill?$monthBill:0);
		$this->assign('totalBill',$totalBill?$totalBill:0);
		$this->assign('monthIncome',$monthIncome?$monthIncome:0);	
		$this->assign('totalIncome',$totalIncome?$totalIncome:0);
		$this->assign('monthCampStudents',$monthCampStudents?$monthCampStudents:0);
		$this->assign('totalGift',$totalGift?$totalGift:0);
		$this->assign('totalStudents',$totalStudents?$totalStudents:0);
		$this->assign('monthStudents',$monthStudents?$monthStudents:0);
		$this->assign('monthSchedule',$monthSchedule?$monthSchedule:0);
		$this->assign('totalSchedule',$totalSchedule?$totalSchedule:0);


		$this->assign('monthNewStudents',$monthNewStudents?$monthNewStudents:0);
		$this->assign('monthofflineStudents',$monthofflineStudents?$monthofflineStudents:0);
		$this->assign('onlineStudents',$onlineStudents?$onlineStudents:0);
		$this->assign('campInfo',$campInfo);
		return view('Index/index');
	}

	public function indexOfCoach(){
		return view('Index/indexOfCoach');
	}
}