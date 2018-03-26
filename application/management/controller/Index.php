<?php 
namespace app\management\controller;
use app\management\controller\Backend;


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
		$list2 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m') as month")->whereTime('create_time','m')->group('month')->select();
		
		// 一个月的营业额
		$list2 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m%d') as days")->whereTime('create_time','d')->group('days')->select();
		return view('Index/index');
	}

	
}