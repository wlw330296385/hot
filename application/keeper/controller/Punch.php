<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\PunchService;
use app\service\WechatService;
// 打卡
class Punch extends Base{
	private $PunchService;	
	public function _initialize(){
		parent::_initialize();
		$this->PunchService = new PunchService;
	}
	// 打卡首页
    public function index() {
    	$month_str = date('Ym',time());
    	$member_id = $this->memberInfo['id'];
    	$puchList = db('punch')->where(['member_id'=>$this->memberInfo['id']])->whereTime('punch_time','month')->where('delete_time',null)->select();
    	//本月打卡总数
    	$monthPunch = count($puchList);
        // 本月打卡积分总数
        // 本月日期
        $month = date('Ym',time());
        $month_end = $month*100+32;
        $month_start = $month*100+1;
        $monthScore = db('score')->where(['member_id'=>$this->memberInfo['id'],'score_des'=>"打卡送积分"])->where(['date_str'=>['between',[$month_start,$month_end]]])->sum('score');
    	$this->assign('puchList',$puchList);
        $this->assign('monthScore',$monthScore?$monthScore:0);
    	$this->assign('monthPunch',$monthPunch?$monthPunch:0);
        return view('Punch/index');
    }


    //打卡详情
    public function punchInfo(){
    	$punch_id = input('param.punch_id');

    	$punchInfo = $this->PunchService->getPunchInfo(['id'=>$punch_id]);
    	$month_str = date('Ym',time());
    	// 累计打卡
    	$totalPunch = db('punch')->where(['member_id'=>$punchInfo['member_id']])->where('delete_time',null)->count();
    	//本月打卡
    	$monthPunch = db('punch')->where(['member_id'=>$punchInfo['member_id']])->whereTime('punch_time','month')->where('delete_time',null)->count();

        // 是否已点赞
        $likesInfo = $this->PunchService->getLikesInfo(['punch_id'=>$punch_id,'member_id'=>$this->memberInfo['id']]);
        if($likesInfo){
            $is_like = $likesInfo['status'];
        }else{
            $is_like = -1;
        }

        $this->assign('is_like',$is_like);
    	$this->assign('totalPunch',$totalPunch);
    	$this->assign('monthPunch',$monthPunch);
    	$this->assign('punchInfo',$punchInfo);
    	return view('Punch/punchInfo');
    }



    // 打卡
    public function createPunch(){
        $group_id = input('param.group_id');
        $is_pool = -1;
        if($group_id){
            $is_pool = db('pool')->where(['group_id'=>$group_id,'status'=>2])->where('delete_time',null)->value('id');
        }

        $sport_plan_schedule_id = input('param.sport_plan_schedule_id');
        if($sport_plan_schedule_id){
            $sportPlanScheduleInfo = db('sport_plan_schedule')->where(['id'=>$sport_plan_schedule_id])->where('delete_time',null)->find();
        }else{
            $sportPlanScheduleInfo = [];
        }

    	$month_str = date('Ym',time());

    	//本月打卡
    	$monthPunch = db('punch')->where(['month_str'=>$month_str,'member_id'=>$this->memberInfo['id']])->where('delete_time',null)->count();

        
        $this->assign('is_pool',$is_pool?$is_pool:-1);
    	$this->assign('monthPunch',$monthPunch);
        $this->assign('sportPlanScheduleInfo',$sportPlanScheduleInfo);
    	return view('Punch/createPunch');
	}
	
	// 打卡列表
	public function punchList() {
        
        return view('Punch/punchList');
    }

    // 运动计划
	public function sportPlanList() {

        return view('Punch/sportPlanList');
    }
    // 运动计划日程表
    public function sportPlanScheduleList() {


        return view('Punch/sportPlanScheduleList');
    }

    // 创建运动计划
	public function createSportPlan() {

        return view('Punch/createSportPlan');
    }
    // 创建运动计划日程
    public function createSportPlanSchedule() {

        return view('Punch/createSportPlanSchedule');
    }

    // 运动计划详情
	public function sportPlanInfo() {
        $sport_plan_id = input('param.sport_plan_id');
        $SportPlan = new \app\model\SportPlan;
        $sportPlanInfo = $SportPlan->where(['id'=>$sport_plan_id])->find();

        
        $this->assign('sportPlanInfo',$sportPlanInfo);
        return view('Punch/sportPlanInfo');
    }


    //月打卡照片墙
    public function punchPhotoWall(){
        $currYear = date('Y',time());
        $currMonth = date('m',time());
        
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $userInfo = db('member')->where(['id'=>$member_id])->find();
        $this->assign('userInfo',$userInfo);
        // 累计打卡
        $totalPunch = db('punch')->where(['member_id'=>$member_id])->where('delete_time',null)->count();
        $this->assign('totalPunch',$totalPunch);

        $this->assign('currYear',$currYear);
        $this->assign('currMonth',$currMonth);

        $callback = url('keeper/punch/index', ['pid' => $member_id], '', true);
        $wechatS = new WechatService();
        $url = $wechatS->oauthredirect($callback);
        $qrcodeimg = buildqrcode($url) ;
        $this->assign('qrcodeimg', $qrcodeimg);

        return view('Punch/punchPhotoWall');
    }


    //月打卡照片墙
    public function memberHomePage(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $userInfo = db('member')->where(['id'=>$member_id])->find();
        $this->assign('userInfo',$userInfo);

        $month_str = date('Ym',time());
        $puchList = db('punch')->where(['month_str'=>$month_str,'member_id'=>$member_id])->where('delete_time',null)->select();
        //本月打卡总数
        $monthPunch = count($puchList);
        $this->assign('monthPunch',$monthPunch);

        return view('Punch/memberHomePage');
    }

}