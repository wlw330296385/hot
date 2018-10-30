<?php 
namespace app\api\Controller;
use app\api\controller\Base;
use Think\Log;
class Wxpay extends Base{

    public function _initialize(){
        parent::_initialize();
    }
    
	public function index(){

    }




	/**
	 * 异步通知接口
	 * @return void
	 */
	public function notifyUrl()
	{      

        $xml = file_get_contents('php://input');
        $obj=simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA);
        $jsonObj = json_encode($obj);
        $data = json_decode($jsonObj,true);
        
        $msg = [
            'return_code'=>'SUCCESS',
            'return_msg'=>'OK'
            ];
        $bill_order = $data['out_trade_no'];
        // 订单号的类型:1:课程|2:活动|3:充值
        if($bill_order<3000000000000000000){
            $billInfo = db('bill')->where(['bill_order'=>$data['out_trade_no']])->find();
            if($billInfo){
                if($billInfo['is_pay'] <> 1 || $billInfo['status'] <> 1){
                    $billData = [
                        'balance_pay'   =>($data['total_fee']/100),
                        'callback_str'     =>$data['transaction_id'],
                        'status'    =>1,
                        'is_pay'    =>1,
                    ];
                    $BillService = new \app\service\BillService;
                    $result = $BillService->pay($billData,['bill_order'=>$data['out_trade_no']]);  
                    if($result===false){
                        db('log_wxpay')->insert(['callback'=>$jsonObj,'create_time'=>time(),'time_end'=>$data['time_end'],'total_fee'=>$data['total_fee'],'openid'=>$data['openid'],'bill_order'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id'],'sys_remarks'=>'订单修改失败']);
                        return xml($msg);
                    }else{
                        db('log_wxpay')->insert(['callback'=>$jsonObj,'create_time'=>time(),'time_end'=>$data['time_end'],'total_fee'=>$data['total_fee'],'openid'=>$data['openid'],'bill_order'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id'],'sys_remarks'=>'订单修改成功']);
                        return xml($msg);
                    }
                }else{
                        db('log_wxpay')->insert(['callback'=>$jsonObj,'create_time'=>time(),'time_end'=>$data['time_end'],'total_fee'=>$data['total_fee'],'openid'=>$data['openid'],'bill_order'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id'],'sys_remarks'=>'订单正确,不需要修改']);
                        return xml($msg);
                }
            
            }else{
                db('log_wxpay')->insert(['callback'=>$jsonObj,'create_time'=>time(),'time_end'=>$data['time_end'],'total_fee'=>$data['total_fee'],'openid'=>$data['openid'],'bill_order'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id'],'sys_remarks'=>'商品订单修改失败']);
                return xml($msg);
            } 


            // 充值订单
        }elseif ($bill_order>3000000000000000000 && $bill_order<4000000000000000000) {
            $result = db('charge')->where(['charge_order'=>$bill_order])->update(['callback'=>$data['transaction_id'],'is_pay'=>1,'status'=>1,'date_str'=>date('Ymd',time())]);
            if($result){
                db('log_wxpay')->insert(['callback'=>$jsonObj,'create_time'=>time(),'time_end'=>$data['time_end'],'total_fee'=>$data['total_fee'],'openid'=>$data['openid'],'bill_order'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id'],'sys_remarks'=>'充值订单修改成功']);
                return xml($msg);
            }else{
                db('log_wxpay')->insert(['callback'=>$jsonObj,'create_time'=>time(),'time_end'=>$data['time_end'],'total_fee'=>$data['total_fee'],'openid'=>$data['openid'],'bill_order'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id'],'sys_remarks'=>'充值订单修改失败']);
                return xml($msg);
            } 
        }

           
        
	}


    


    
}