<?php 
namespace app\management\controller;
use app\management\controller\Camp;

// 按课时结算的训练营财务页面
class Gift extends Camp{
	public function _initialize(){
		
		parent::_initialize();
	}

	public function index(){


		return view();
	}

	// 购买赠课
	public function giftbuy(){
		return view();
	}


	// 赠课购买列表
	public function giftbuyList(){
		$map = ['schedule_giftbuy.camp_id'=>$this->campInfo['id']];
		$lesson_id = input('param.lesson_id');
		if($lesson_id){
			$map['schedule_giftbuy.lesson_id'] = $lesson_id;
		}
		$lessonList = db('lesson')->where(['camp_id'=>$this->campInfo['id']])->select();
		$list = db('schedule_giftbuy')
				->field('schedule_giftbuy.*,lesson.cost,lesson.total_giftschedule,lesson.resi_giftschedule')
				->join('lesson','lesson.id = schedule_giftbuy.lesson_id')
				->where($map)
				->order('schedule_giftbuy.id desc')
				->select();


		$this->assign('list',$list);
		return view();
	}



	// 赠课
	public function giftrecord(){
		return view();
	}



	// 赠课列表
	public function giftrecordList(){
		$map = ['schedule_giftrecord.camp_id'=>$this->campInfo['id']];
		$lesson_id = input('param.lesson_id');
		if($lesson_id){
			$map['schedule_giftrecord.lesson_id'] = $lesson_id;
		}
		$list = db('schedule_giftrecord')
				->where($map)
				->select();
		foreach ($list as $key => $value) {
			$sl = '';
			$s_l = json_decode($value['student_str'],true);
			foreach ($s_l as $k => $val) {

				$sl.=$val['student'].',';	
			}			
			$list[$key]['studentList'] = $sl;
		}		
		$this->assign('list',$list);				
		return view();
	}



	// 赠课详情
	public function giftstudent(){
		return view();
	}


}