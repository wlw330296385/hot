<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\BillService;
class Bill extends Frontend{
	protected $BillService;
	public function _initialize(){
		parent::_initialize();
        $this->BillService = new BillService;
	}



    //获取会员订单接口
    public function getBillListApi(){
        try{
            $page = input('param.page')?input('param.page'):1;
            $map = input('post.');
            if (input('?start') || input('?end')) {
                $start = input('start');
                $end = input('end');
                $map['create_time'] = ['between', [$start, $end]];
                unset($map['start']);
                unset($map['end']);
            }
            $where = function($query) use($map){
                $query -> where($map)->where(function($query){
                    $query->whereOr('expire',0)->whereOr('expire','gt',time());
                });
            };
            
            $result = $this->BillService->getBillList($where,$page);
            return json(['code'=>200,'data'=>$result,'msg'=>'OK']);       
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   	
    }

    //获取订单列表带page
    public function getBillListByPageApi(){
        try{
            $map = input('post.');
            if (input('?start') || input('?end')) {
                $start = input('start');
                $end = input('end');
                $map['create_time'] = ['between', [$start, $end]];
                unset($map['start']);
                unset($map['end']);
            }
            // $map['member_id'] = $this->memberInfo['id'];
            $where = function($query) use($map){
                $query -> where($map)->where(function($query){
                    $query->whereOr('expire',0)->whereOr('expire','gt',time());
                });
            };
            $result = $this->BillService->getBillListByPage($where);
            return json(['code'=>200,'data'=>$result,'msg'=>'OK']);       
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }





    //编辑|添加订单接口
    public function updateBillApi(){
        try{
            $bill_id = input('param.bill_id');
            $data = input('post.');
            $data['member'] = $this->memberInfo['member'];
            $data['member_id'] = $this->memberInfo['id'];
            if($bill_id){
                $result = $this->BillService->updateBill($data,['id'=>$bill_id]);
            }else{
                $result = $this->BillService->createBill($data);
            }
            return json($result);
        
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   	
    }

    //申请退款
    public function refundBillApi(){
        try {
            $bill_id = input('param.bill_id');
            $remarks = input('param.remarks');
            $result = $this->BillService->refundBill(['id'=>$bill_id],$remarks);
            return json($result);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    //同意退款
    public function agreeBillApi(){
        try {
            $bill_id = input('param.bill_id');
            $refund = input('param.refund');
            $result = $this->BillService->agreeBill(['id'=>$bill_id],$refund);
            return json($result);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 拒绝退款
    public function rejectBillApi(){
        try {
            $bill_id = input('param.bill_id');
            $remarks = input('param.remarks');
            $result = $this->BillService->rejectBill(['id'=>$bill_id],$remarks);
            return json($result);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 拒绝退款
    public function cancelBillApi(){
        try {
            $bill_id = input('param.bill_id');
            $result = $this->BillService->cancelBill(['id'=>$bill_id]);
            return json($result);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   public function payApi(){
        try{
            $bill_order = input('param.bill_order');
            $billInfo = db('bill')->where(['bill_order'=>$bill_order])->find();
            if($billInfo){
                if($billInfo['is_pay'] <> 1 || $billInfo['status'] <> 1){
                    $data = input('post.');
                    $data['status'] = 1;
                    $data['is_pay'] = 1;
                    $result = $this->BillService->pay($data,['bill_order'=>$bill_order]);  
                    if($result){
                        return json(['code'=>200,'msg'=>'支付成功']);
                    }else{
                        return json(['code'=>100,'msg'=>'该订单状态已失效']);
                    }  
                }else{
                    return json(['code'=>200,'msg'=>'订单已支付']);
                }
            }else{
                return json(['code'=>100,'msg'=>'订单号错误']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
   }

   public function paySchoolApi(){
        try{
            $bill_order = input('param.bill_order');
            $billInfo = db('bill')->where(['bill_order'=>$bill_order])->find();
            if($billInfo){
                if($billInfo['is_pay']!= 1 || $billInfo['status']!= 1){
                    $data = input('post.');
                    $data['status'] = 1;
                    $data['is_pay'] = 1;
                    $data['balance_pay'] = 0;
                    $result = $this->BillService->paySchool($data,['bill_order'=>$bill_order]);  
                    if($result){
                        return json(['code'=>200,'msg'=>'支付成功']);
                    }else{
                        return json(['code'=>100,'msg'=>'该订单状态已失效']);
                    }  
                }else{
                    return json(['code'=>200,'msg'=>'订单已支付']);
                }
            }else{
                return json(['code'=>100,'msg'=>'订单号错误']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
   }


   public function editBillApi(){
    try {
        $item_coupon_id = input('param.item_coupon_id');
        $remarks = input('param.remarks');
        $system_remarks = input('param.system_remarks');
        if($item_coupon_id){
            $data['item_coupon_id'] = $item_coupon_id;
        }
        if($remarks){
            $data['remarks'] = $remarks;
        }
        if($system_remarks){
            $data['system_remarks'] = $system_remarks;
        }
        $bill_order = input('param.bill_order');
        $res = db('bill')->where(['bill_order'=>$bill_order])->update($data);
        if($res){
            return json(['code'=>200,'msg'=>'操作成功']);
        }else{
            return json(['code'=>100,'msg'=>'操作失败,请检查订单号']);
        }
    } catch (Exception $e) {
        return json(['code'=>100,'msg'=>$e->getMessage()]);
    }
   }
    
}