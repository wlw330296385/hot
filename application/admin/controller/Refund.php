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
        if($keyword){
            $hasWhere['camp|goods|student'] = ['like',"%$keyword%"];
        }
        if($status){
            $map['bill.status'] = $status;
        }
        if($rebate_type){
            $map['bill.rebate_type'] = $rebate_type;
        }
        $Refund = new \app\model\Refund;
        $refundList = $Refund->hasWhere('bill',['goods'=>'大热'])->with('bill')->where($map)->select();

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
            $refund = input('param.refund');
            $remarks = input('param.remarks');
            $refund_type = input('param.refund_type');
            $action = input('param.action');//2=同意,3=同意并打款,4=同意后打款;
            
            $Refund = new \app\model\Refund;
            $refundInfo = $Refund->where(['id'=>$refund_id])->find();
            if(!$refundInfo){
                $this->error('传参错误,找不到退款信息');
            }
            $refundamount = $refundInfo['refundamount'];
            if($refundamount <= $refund){
                $this->error('打款金额不可大于退款金额');
            }
            
            if($this->campInfo['rebate_type'] == 1){//课时版
                $refund_fee = ($refundamount - $refund)*$this->campInfo['schedule_rebate'];
                $output = 0;
            }else{
                $refund_fee = 0;
                $output = $refund;//手续费+退款金额;
            }
            $BillService = new \app\service\BillService;
            if($action == 2 || $action == 3){
            
                $refundData = [
                    'refund'=>$refund,
                    'refund_fee'=>$refund_fee,
                    'remarks'=>$remarks,
                    'refund_type'=>$refund_type,
                    'process'=>$this->memberInfo['member'],
                    'process_id'=>$this->memberInfo['id'],
                    'process_time'=>time(),
                    'status'=>2,
                    'agree_time'=>time()
                ]; 
                
                $res = $BillService->updateBill(['action'=>3,'output'=>$output],['id'=>$refundInfo['bill_id']],$refundData);
                if($res['code'] == 100){
                    $this->error($res['msg']);
                }
            }elseif ($action == -1) {
                $refundData = [
                    'refund'=>0,
                    'refund_fee'=>0,
                    'remarks'=>$remarks,
                    'refund_type'=>$refund_type,
                    'process'=>$this->memberInfo['member'],
                    'process_id'=>$this->memberInfo['id'],
                    'process_time'=>time(),
                    'status'=>-1,
                    'reject_time'=>time()
                ]; 
                
                $res = $BillService->updateBill(['action'=>4,'output'=>0],['id'=>$refundInfo['bill_id']],$refundData);
                if($res['code'] == 100){
                    $this->error($res['msg']);
                }
            }
            if($action == 3 || $action == 4) {
                if($this->campInfo['rebate_type'] == 1){
                    $this->error('训练营为[课时版结算],不可以操作打款');
                }
                
                //训练营营业额支出
                db('output')->insert([
                    'output'        => $output,
                    'camp_id'       => $refundInfo['camp_id'],
                    'camp'          => $refundInfo['camp'],
                    'member_id'     => $refundInfo['member_id'],
                    'member'        => $refundInfo['member'],
                    'type'          => 2,
                    'e_balance'     =>($this->campInfo['balance'] - $output),
                    's_balance'     =>$this->campInfo['balance'],
                    'f_id'          =>$refundInfo['id'],
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
                // 减少训练营营业额
                db('camp')->where(['id'=>$refundInfo['camp_id']])->dec('balance',$output)->update();
                $Refund->save(['status'=>3],['id'=>$refund_id]);
                db('bill')->where(['id'=>$refundInfo['bill_id']])->update(['status'=>-2]);
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