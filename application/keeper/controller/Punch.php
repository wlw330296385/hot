<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\PunchService;
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
    	$puchList = db('punch')->where(['month_str'=>$month_str,'member_id'=>$this->memberInfo['id']])->select();
    	//本月打卡总数
    	$monthPunch = count($puchList);

    	$this->assign('puchList',$puchList);
    	$this->assign('monthPunch',$monthPunch);
        return view('Punch/index');
    }


    //打卡详情
    public function punchInfo(){
    	$punch_id = input('param.punch_id');

    	$punchInfo = $this->PunchService->getPunchInfo(['id'=>$punch_id]);
    	$month_str = date('Ym',time());
    	// 累计打卡
    	$totalPunch = db('punch')->where(['member_id'=>$this->memberInfo['id']])->count();
    	//本月打卡
    	$monthPunch = db('punch')->where(['month_str'=>$month_str,'member_id'=>$this->memberInfo['id']])->count();


    	$this->assign('totalPunch',$totalPunch);
    	$this->assign('monthPunch',$monthPunch);
    	$this->assign('punchInfo',$punchInfo);
    	return view('Punch/punchInfo');
    }



    // 打卡
    public function createPunch(){
    	$month_str = date('Ym',time());
    	//本月打卡
    	$monthPunch = db('punch')->where(['month_str'=>$month_str,'member_id'=>$this->memberInfo['id']])->count();

    	$groupList = db('group_member')
            ->field('group_member.*,pool.stake,pool.pool,pool.status as p_status,pool.id as p_id')
            ->join('pool','pool.group_id = group_member.group_id','left')
            ->where(['group_member.member_id'=>$this->memberInfo['id'],'group_member.status'=>1])
            ->where(['pool.status'=>1])
            ->order('group_member.id desc')
            ->select();
        
    	$this->assign('monthPunch',$monthPunch);
        $this->assign('groupList',$groupList);
    	return view('Punch/createPunch');
	}
	
	// 打卡列表
	public function punchList() {
        return view('Punch/punchList');
    }

}