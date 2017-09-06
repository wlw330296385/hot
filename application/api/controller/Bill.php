<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\BillService;
class Bill extends Base{
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
            $billList = $result['data'];
            $billList['count'] = count($billList);
            return json(['code'=>100,'data'=>$billList,'msg'=>'OK']);       
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   	
    }

    //编辑|添加订单接口
    public function updateBillApi(){
        try{
            $id = input('get.id');
            $data = input('post.');
            if($id){
                $result = $this->BillService->updateBill($data,$id);
            }else{
                $result = $this->BillService->pubBill($data);
            }
            return json($result);
        
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   	
    }


    
}