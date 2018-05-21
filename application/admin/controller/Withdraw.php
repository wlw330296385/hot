<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
class Withdraw extends Backend{
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {

        return view('CampWithdraw/index');
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

        $CampWithdraw = new \app\model\CampWithdraw;
        if($keyword){
            $hasWhere['camp'] = ['like',"%$keyword%"];
            $campWithdrawList = $CampWithdraw->with('bank')->where($map)->paginate(10);
        }else{
            $campWithdrawList = $CampWithdraw->with('bank')->where($map)->paginate(10);
        }
         
        $this->assign('campWithdrawList',$campWithdrawList);
        return $this->fetch('Withdraw/campWithdrawList');
    }

    // 提现处理
    public function campWithdrawDeal(){
        $campWithdraw_id = input('param.campWithdraw_id');

        $remarks = input('param.remarks','略');
        $action = input('param.action');//2=同意,3=已打款,4=同意并已打款,-1=拒绝;
        
        $CampWithdraw = new \app\model\CampWithdraw;
        $campWithdrawInfo = $CampWithdraw->where(['id'=>$campWithdraw_id])->find();
        if(!$campWithdrawInfo){
            $this->error('传参错误,找不到提现信息');
        }
        $campInfo = db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->find();

        if($action == 2){
      
            if($campWithdrawInfo['rebate_type'] == 2){
                
                db('output')->insert([
                    'output'        => $campWithdrawInfo['camp_withdraw_fee'],
                    'camp_id'       => $campWithdrawInfo['camp_id'],
                    'camp'          => $campWithdrawInfo['camp'],
                    'member_id'     => $campWithdrawInfo['member_id'],
                    'member'        => $campWithdrawInfo['member'],
                    'type'          => 4,
                    'e_balance'     =>($campInfo['balance'] - $campWithdrawInfo['camp_withdraw_fee']),
                    's_balance'     =>$campInfo['balance'],
                    'f_id'          =>$campWithdrawInfo['id'],
                    'system_remarks'=>$remarks,
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
            }
            db('output')->insert([
                'output'        => $campWithdrawInfo['withdraw'],
                'camp_id'       => $campWithdrawInfo['camp_id'],
                'camp'          => $campWithdrawInfo['camp'],
                'member_id'     => $campWithdrawInfo['member_id'],
                'member'        => $campWithdrawInfo['member'],
                'type'          => -1,
                'e_balance'     =>($campInfo['balance'] - $campWithdrawInfo['camp_withdraw_fee'] - $campWithdrawInfo['buffer']),
                's_balance'     =>($campInfo['balance'] - $campWithdrawInfo['camp_withdraw_fee']),
                'f_id'          =>$campWithdrawInfo['id'],
                'system_remarks'=>$remarks,
                'create_time'   => time(),
                'update_time'   => time(),
            ]);
            $CampWithdraw->save(['status'=>2,'buffer'=>0],['id'=>$campWithdraw_id]);
        }elseif ($action == -1) {
            // 解冻资金
            $CampWithdraw->save(['status'=>-1,'buffer'=>0,'e_balance'=>($campInfo['balance']+$campWithdrawInfo['buffer'])],['id'=>$campWithdraw_id]);
            db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->inc('balance',$campWithdrawInfo['buffer'])->update();
        }
        $this->success('操作成功'); 
          
        
    }


}