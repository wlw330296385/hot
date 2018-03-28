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



		// 培训购买总量曲线图
		$billList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m%d') as days,goods_type")->where(['camp_id'=>$this->camp_member['camp_id'],'is_pay'=>1])->whereTime('create_time','m')->group('days')->select();
		$list = Time::month();
		$lessonBill = [];
		$eventBill = [];

		$dateStart = date('Ymd',$list[0]);
		$dateEnd = date('Ymd',$list[1]);
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
		$gradeCourt = db('grade')->field('sum(students) as s_students,court')->where(['status'=>1])->group('court_id')->select();
		$gradeCourtData = [];
		foreach ($gradeCourt as $key => $value) {
			$gradeCourtData['legend'][] = $value['court'];
			$gradeCourtData['series'][] = ['value'=>$value['s_students'],'name'=>$value['court']];
		}
		$this->assign('gradeCourtData',json_encode($gradeCourtData,true));
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