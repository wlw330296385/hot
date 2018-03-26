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
		// 教学分布点
		$list1 = db('grade')->field('sum(students) as s_students,court')->where(['camp_id'=>$this->camp_member['camp_id']])->select();
		// 一年的营业额
		$list2 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m') as month")->where(['camp_id'=>$this->camp_member['camp_id']])->whereTime('create_time','y')->group('month')->select();
		// 一个月的营业额
		$list2 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m%d') as days")->where(['camp_id'=>$this->camp_member['camp_id']])->whereTime('create_time','m')->group('days')->select();

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

		// dump($lessonBill);die;
		// dump($billList);
		foreach ($billList as $key => $value) {
			$kk = $value['days'] - $dateStart;
			if($value['goods_type'] == 1){
				
				// echo "$kk------{$value['days']}---{$value['s_balance_pay']}<br/>";
				$lessonBill[$kk] = $value['s_balance_pay'];

			}elseif ($value['goods_type'] == 2) {
				$eventBill[$kk] = $value['s_balance_pay'];
			}
		}

		$this->assign('lessonBill',json_encode($lessonBill));
		$this->assign('eventBill',json_encode($eventBill));
		$this->assign('totalIncome',$totalIncome);
		$this->assign('totalGift',$totalGift);
		$this->assign('totalStudents',$totalStudents);
		$this->assign('totalSchedule',$totalSchedule);
		return view('Index/index');
	}

	
}