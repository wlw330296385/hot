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


   public function payApi(){
        try{
            $bill_order = input('param.bill_order');
            $data = input('post.');
            $data['status'] = 1;
            $data['is_pay'] = 1;
            $result = $this->BillService->pay($data,['bill_order'=>$bill_order]);  
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