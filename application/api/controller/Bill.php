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
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $result = $this->BillService->getBillList($map,$page);
            $balancePay = input('param.balancePay');
            if($balancePay == 1){
                $map['balance_pay'] = ['gt',0];
            }
            if($balancePay == -1){
                $map['balance_pay'] = 0;
            }
            $result['count'] = count($result);
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
            $map['member_id'] = $this->memberInfo['id'];
            $result = $this->BillService->getBillListByPage($map);
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
                $result = $this->BillService->updateBill($data,['id'=>$bill_id]);
            }else{
                $result = $this->BillService->createBill($data);
            }
            return json($result);
        
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   	
    }


   
    
}