<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\admin\service\RefundService;
class Refund extends Backend{
	protected $RefundService;
	public function _initialize(){
		parent::_initialize();
		$this->RefundService = new RefundService;
	}

    public function index() {

        return view('Refund/index');
    }


   
    // 退费列表
    public function refundList(){
        $keyword = input('param.keyword');
        $status = input('param.status');
        $rebate_type = input('param.rebate_type');
        $map = [];
        if($status){
            $map['refund.status'] = $status;
        }
        if($rebate_type){
            $map['refund.rebate_type'] = $rebate_type;
        }

        $Refund = new \app\model\Refund;
        if($keyword){
            $hasWhere['camp|goods|student'] = ['like',"%$keyword%"];
            $refundList = $Refund->with('bill')->hasWhere($hasWhere)->where($map)->select();
        }else{
            $refundList = $Refund->with('bill')->hasWhere($hasWhere)->where($map)->select();
        }
        

        if($refundList){
            $refundList = $refundList->toArray();
        }else{
            $refundList = [];
        }  

        $this->assign('refundList',$refundList);
        return $this->fetch('StatisticsCamp/refundList');
    }

    // 退费处理
    public function refundDeal(){
        $refund_id = input('param.refund_id');
        if(request()->isPost()){
            $remarks = input('param.remarks');
            $refund_type = input('param.refund_type');
            $action = input('param.action');//2=同意,3=同意并打款,4=已打款;
            
            $Refund = new \app\model\Refund;
            $refundInfo = $Refund->where(['id'=>$refund_id])->find();
            if(!$refundInfo){
                $this->error('传参错误,找不到退款信息');
            }
            $refundamount = $refundInfo['refundamount'];
            if($refundInfo['rebate_type'] <> 1){//课时版
                $this->error('非课时版训练营不允许操作');
            }
            
            
            if($action == 4) {
                //训练营课时版收入
                $campInfo = db('camp')->where(['id'=>$refundInfo['camp_id']])->find();
                $refund = $refundamount*(1-$campInfo['refund_rebate']);//实际退费
                $refund_fee = $refundamount*$campInfo['refund_rebate'];//手续费
            
                
                // db('income')->insert([
                //     'income'        => $income,
                //     'camp_id'       => $refundInfo['camp_id'],
                //     'camp'          => $refundInfo['camp'],
                //     'member_id'     => $refundInfo['member_id'],
                //     'member'        => $refundInfo['member'],
                //     'type'          => 5,
                //     'e_balance'     =>($campInfo['balance'] + $income),
                //     's_balance'     =>$campInfo['balance'],
                //     'f_id'          =>$refundInfo['id'],
                //     'student_id'    =>$refundInfo['student_id'],
                //     'student'       =>$refundInfo['student'],
                //     'system_remarks'=>$remarks,
                //     'create_time'   => time(),
                //     'update_time'   => time(),
                // ]);
                // 增加训练营营业额
                // db('camp')->where(['id'=>$refundInfo['camp_id']])->inc('balance',$income)->update();
                $Refund->save(['status'=>3,'rebate_type'=>$campInfo['rebate_type'],'refund_rebate'=>$campInfo['refund_rebate'],'refund'=>$refund,'refund_fee'=>$refund_fee],['id'=>$refund_id]);
            }
            $this->success('操作成功');    
        }else{
            $Refund = new \app\model\Refund;
            $refundInfo = $Refund
                        ->with('bill')
                        ->where(['id'=>$refund_id])
                        ->find();    
            $this->assign('refundInfo',$refundInfo);

            return $this->fetch('StatisticsCamp/refundDeal');
        }
        
    }


}