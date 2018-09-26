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

		$lessonList = db('lesson')->where(['camp_id'=>$this->campInfo['id']])->select();

		if(request()->isPost()){
			$data = input('post.');
			$l_id = input('param.l_id');
			$lessonInfo = $lessonList[$l_id];
            $camp_id = $this->campInfo['id'];
			$ScheduleService = new \app\service\ScheduleService;
            $isPower = $ScheduleService->isPower($camp_id, $this->memberInfo['id']);
            if ($isPower < 2) {
                $this->error(__lang('MSG_403') . '不能操作');
            }
            if(!$lessonInfo){
                $this->error('找不到课程信息');
            }
            $totalCost = $data['quantity'] * $lessonInfo['cost'];
            $campInfo = $this->campInfo;
            if($this->campInfo['balance']<$totalCost && $campInfo['rebate_type'] == 1){
                $this->error('训练营余额不足');
            }
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['camp'] = $this->campInfo['camp'];
            $data['camp_id'] = $this->campInfo['id'];
            $data['lesson'] = $lessonInfo['lesson'];
            $data['lesson_id'] = $lessonInfo['id'];
			$result = $ScheduleService->buygift($data);
			if($result['code']==200){
				$this->success($result['msg'],'giftbuyList');
			}else{
				$this->error($result['msg']);
			}
		}

		$this->assign('lessonList',$lessonList);
		return view();
	}


	// 赠课购买列表
	public function giftbuyList(){
		$map = ['schedule_giftbuy.camp_id'=>$this->campInfo['id']];
		$keyword = input('param.keyword');
		if($keyword){
			$map['schedule_giftbuy.lesson'] = ['like',"%$keyword%"];
		}
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
		$keyword = input('param.keyword');
		if($keyword){
			$map['schedule_giftrecord.lesson'] = ['like',"%$keyword%"];
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

		$lesson_id = input('param.l_id');
		$list = db('schedule_gift_student')
				->where(['lesson_id'=>$lesson_id])
				->select();

		$this->assign('list',$list);
		return view();
	}


}