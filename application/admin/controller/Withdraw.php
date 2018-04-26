<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\admin\service\WithdrawService;
class Withdraw extends Backend{
	protected $WithdrawService;
	public function _initialize(){
		parent::_initialize();
		$this->WithdrawService = new WithdrawService;
	}

    public function index() {

        return view('Withdraw/index');
    }


   
    // 提现列表
    public function campWithdrawList(){
        $keyword = input('param.keyword');
        $status = input('param.status');
        $camp_type = input('param.camp_type');
        $map = [];
        if($status){
            $map['status'] = $status;
        }
        if($camp_type){
            $map['camp_type'] = $camp_type;
        }

        $Withdraw = new \app\model\Withdraw;
        if($keyword){
            $hasWhere['camp|goods|student'] = ['like',"%$keyword%"];
            $campWithdrawList = $Withdraw->where($map)->select();
        }else{
            $campWithdrawList = $Withdraw->where($map)->select();
        }
        

        if($campWithdrawList){
            $campWithdrawList = $campWithdrawList->toArray();
        }else{
            $campWithdrawList = [];
        }  

        $this->assign('campWithdrawList',$campWithdrawList);
        return $this->fetch('StatisticsCamp/campWithdrawList');
    }

    // 提现处理
    public function campWithdrawDeal(){
        $campWithdraw_id = input('param.campWithdraw_id');
        if(request()->isPost()){
            $remarks = input('param.remarks');
            $action = input('param.action');//2=同意,3=已打款,4=同意并已打款;
            
            $Withdraw = new \app\model\Withdraw;
            $campWithdrawInfo = $Withdraw->where(['id'=>$campWithdraw_id])->find();
            if(!$campWithdrawInfo){
                $this->error('传参错误,找不到退款信息');
            }
            $campInfo = db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->find();
            if($action == 2) {
                if($campWithdrawInfo['camp_type'] == 2){
                    $camp_withdraw_fee = $campWithdrawInfo['withdraw'] * $campInfo['schedule_rebate'];
                    $output  = $campWithdrawInfo['withdraw'] - $campWithdrawInfo['campWithdraw'] - $campWithdrawInfo['campWithdraw_fee'];
                }
                
                $BillService = new \app\service\BillService;
                //训练营课时版收入
                $campInfo = db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->find();
                db('income')->insert([
                    'income'        => $income,
                    'camp_id'       => $campWithdrawInfo['camp_id'],
                    'camp'          => $campWithdrawInfo['camp'],
                    'member_id'     => $campWithdrawInfo['member_id'],
                    'member'        => $campWithdrawInfo['member'],
                    'type'          => 5,
                    'e_balance'     =>($campInfo['balance'] + $income),
                    's_balance'     =>$campInfo['balance'],
                    'f_id'          =>$campWithdrawInfo['id'],
                    'student_id'    =>$campWithdrawInfo['student_id'],
                    'student'       =>$campWithdrawInfo['student'],
                    'system_remarks'=>$remarks,
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
                // 增加训练营营业额
                db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->inc('balance',$income)->update();
                $Withdraw->save(['status'=>3],['id'=>$campWithdraw_id]);
            }
            $this->success('操作成功');    
        }else{
            $Withdraw = new \app\model\Withdraw;
            $campWithdrawInfo = $Withdraw
                        ->with('bank')
                        ->where(['id'=>$campWithdraw_id])
                        ->find();    
            $this->assign('campWithdrawInfo',$campWithdrawInfo);
            return $this->fetch('StatisticsCamp/campWithdrawDeal');
        }
        
    }


}