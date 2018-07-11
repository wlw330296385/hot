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

    // 退费处理(打款)
    public function refundDeal(){
        $refund_id = input('param.refund_id');
        if(request()->isPost()){
            $remarks = input('param.remarks');
            $refund_type = input('param.refund_type');
            $action = input('param.action',4);//4=已打款;
            
            $Refund = new \app\model\Refund;
            $refundInfo = $Refund->where(['id'=>$refund_id])->find();

            if(!$refundInfo){
                $this->error('传参错误,找不到退款信息');
            }
            $refund = $refundInfo['refund'];//实际退费
            $refundamount = $refundInfo['refundamount'];
            if($refund>$refundamount){
                $this->error('实际退款不允许大于可退款');
            }
            if($refundInfo['status'] <> 2){//课时版
                $this->error('训练营未同意退款,不允许操作');
            }
            
            // if($refundInfo['rebate_type']<>1){
            //     $this->error('非课时版训练营,不允许操作');
            // }
            $campInfo = db('camp')->where(['id'=>$refundInfo['camp_id']])->find();
            if($campInfo['rebate_type'] == 2){
                //训练营营业额支出
                db('output')->insert([
                    'output'        => $refund,
                    'camp_id'       => $refundInfo['camp_id'],
                    'camp'          => $refundInfo['camp'],
                    'member_id'     => $refundInfo['member_id'],
                    'member'        => $refundInfo['member'],
                    'type'          => 2,
                    'e_balance'     => ($this->campInfo['balance'] - $refund),
                    's_balance'     => $this->campInfo['balance'],
                    'f_id'          => $refundInfo['id'],
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);

                // 减少训练营营业额
                db('camp')->where(['id'=>$refundInfo['camp_id']])->dec('balance',$output)->update();
                db('camp_finance')->insert([
                        'money'        => -($refund),
                        'camp_id'       => $refundInfo['camp_id'],
                        'camp'          => $refundInfo['camp'],
                        'type'          => -3,
                        'e_balance'     =>($campInfo['balance']-$refundInfo['buffer']),
                        's_balance'     =>($campInfo['balance']),
                        'f_id'          =>$refundInfo['id'],
                        'rebate_type'   =>$refundInfo['rebate_type'],
                        'schedule_rebate'   =>$refundInfo['schedule_rebate'],
                        'date_str'      => date('Ymd',time()),
                        'create_time'   => time(),
                        'update_time'   => time(),
                    ]);
                $Refund->save(['status'=>3,'process_time'=>time(),'finish_time'=>time()],['id'=>$refund_id]);
            }elseif ($campInfo['rebate_type'] == 1) {
                // 训练营课时版收入
                $income = ($refundamount-$refund)*(1-$refundInfo['refund_rebate']);//实际退费
                $refund_fee = ($refundamount-$refund)*$refundInfo['refund_rebate'];//手续费
                if($income>0){
                    db('income')->insert([
                        'income'        => $income,
                        'camp_id'       => $refundInfo['camp_id'],
                        'camp'          => $refundInfo['camp'],
                        'member_id'     => $refundInfo['member_id'],
                        'member'        => $refundInfo['member'],
                        'type'          => 5,
                        'e_balance'     =>($campInfo['balance'] + $income),
                        's_balance'     =>$campInfo['balance'],
                        'f_id'          =>$refundInfo['id'],
                        'student_id'    =>$refundInfo['student_id'],
                        'student'       =>$refundInfo['student'],
                        'system_remarks'=>$remarks,
                        'create_time'   => time(),
                        'update_time'   => time(),
                    ]);
                    // 增加训练营营业额
                    db('camp')->where(['id'=>$refundInfo['camp_id']])->inc('balance',$income)->update();
                    db('camp_finance')->insert([
                        'money'         => -$income,
                        'camp_id'       => $refundInfo['camp_id'],
                        'camp'          => $refundInfo['camp'],
                        'type'          => -3,
                        'e_balance'     =>($campInfo['balance']+$income),
                        's_balance'     =>($campInfo['balance']),
                        'f_id'          =>$refundInfo['id'],
                        'rebate_type'   =>$refundInfo['rebate_type'],
                        'schedule_rebate'   =>$refundInfo['schedule_rebate'],
                        'date_str'      => date('Ymd',time()),
                        'create_time'   => time(),
                        'update_time'   => time(),
                    ]);
                }
                $Refund->save(['status'=>3,'process_time'=>time(),'finish_time'=>time()],['id'=>$refund_id]);
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