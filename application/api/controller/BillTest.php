<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\BillServiceTest;
class BillTest extends Frontend{
	protected $BillServiceTest;
	public function _initialize(){
		parent::_initialize();
        $this->BillServiceTest = new BillServiceTest;
	}



    //获取会员订单接口
    public function getBillListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            
            $balancePay = input('param.balancePay');
            if($balancePay == 1){
                $map['balance_pay'] = ['gt',0];
            }
            if($balancePay == -1){
                $map['balance_pay'] = 0;
            }
            $result['count'] = count($result);
            $result = $this->BillServiceTest->getBillList($map,$page);
            return json(['code'=>200,'data'=>$result,'msg'=>'OK']);       
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   	
    }

    //获取订单列表带page
    public function getBillListByPageApi(){
        try{
            $map = input('post.');
            $balancePay = input('param.balancePay');
            if($balancePay == 1){
                $map['balance_pay'] = ['gt',0];
            }
            if($balancePay == -1){
                $map['balance_pay'] = 0;
            }

            $result = $this->BillServiceTest->getBillListByPage($map);
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
            $data['avatar'] = $this->memberInfo['avatar'];
            if($bill_id){
                $result = $this->BillServiceTest->updateBill($data,['id'=>$bill_id]);
            }else{
                $result = $this->BillServiceTest->createBill($data);
            }
            return json($result);
        
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   	
    }


   public function payApi(){
        try{
            $bill_order = input('param.bill_order');
            $data = input('post.');
            $data['status'] = 1;
            $data['is_pay'] = 1;
            $result = $this->BillServiceTest->pay($data,['bill_order'=>$bill_order]);  
            if($result){
                return json(['code'=>200,'msg'=>'支付成功']);
            }else{
                return json(['code'=>100,'msg'=>'该订单状态已失效']);
            }  
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
   }
    
}