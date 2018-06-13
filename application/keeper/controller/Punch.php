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
        $group_id = input('param.group_id');
        $is_pool = -1;
        if($group_id){
            $is_pool = db('pool')->where(['group_id'=>$group_id,'status'=>2])->value('id');
        }
    	$month_str = date('Ym',time());
    	//本月打卡
    	$monthPunch = db('punch')->where(['month_str'=>$month_str,'member_id'=>$this->memberInfo['id']])->count();

        // 获取开启奖金池规则的社群
        $groupList = [];
    	$groupList = db('group_member')
            ->field('group_member.*,pool.stake,pool.pool,pool.status as p_status,pool.id as p_id,pool.times')
            ->join('pool','pool.group_id = group_member.group_id','left')
            ->where(['group_member.member_id'=>$this->memberInfo['id'],'group_member.status'=>1])
            ->where(['pool.status'=>2])
            ->order('group_member.id desc')
            ->select();
         
        //如果某人当天已在奖金池里打卡超过times(不允许打卡)
        $pool_ids = [];
        if(!empty($groupList)){
            foreach ($groupList as $key => $value) {
                $pool_ids[] = $value['p_id'];
                $groupList[$key]['is_max'] = 0;
            }
            $punchList = db('group_punch')->field('count(id) as c_id,pool_id')->where(['pool_id'=>['in',$pool_ids]])->where(['member_id'=>$this->memberInfo['id']])->whereTime('create_time','today')->group('pool_id')->select();
            foreach ($groupList as $key => $value) {
                foreach ($punchList as $k => $val) {
                    if($val['c_id']>=$value['times'] && $val['pool_id'] == $val['p_id']){
                        // unset($groupList[$key]);
                        $groupList[$key]['is_max'] = 1;
                    }
                }
            }
        }
        dump($groupList);

        $this->assign('is_pool',$is_pool?$is_pool:-1);
    	$this->assign('monthPunch',$monthPunch);
        $this->assign('groupList',$groupList);
    	return view('Punch/createPunch');
	}
	
	// 打卡列表
	public function punchList() {
        return view('Punch/punchList');
    }

}