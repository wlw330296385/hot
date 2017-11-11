<?php 
namespace app\api\Controller;
use app\api\controller\Base;
use Think\Controller;
use Think\Log;
use app\service\WechatJsPayService;

class Wxpay extends Base{

    public function _initialize(){
        parent::_initialize();
    }
    
	public function index(){

        echo "这里是wxpay的index";
    }


    public function pay(){
    	
    }

    // 获取parameters
    public function getParametersApi(){
        try{
            $data = input('param.');
            $WechatJsPayService = new WechatJsPayService;
            $parameters = $WechatJsPayService->pay($data);
            return json(['code'=>200,'msg'=>'ok','data'=>$parameters]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
        
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
        db('log_wxpay')->insert(['callback'=>$jsonObj,'create_time'=>time(),'time_end'=>$data['time_end'],'total_fee'=>$data['total_fee'],'openid'=>$data['openid'],'bill_order'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id']]);
        $msg = [
            'return_code'=>'SUCCESS',
            'return_msg'=>'OK'
            ];
        $billInfo = db('bill')->where(['bill_order'=>$data['out_trade_no']])->find();
        if($billInfo['is_pay']!=1 || 'status'!=1){
            $billData = [
                'balance_pay'   =>($data['total_fee']/100),
                'callback_str'     =>$data['transaction_id'],
                'status'    =>1,
                'is_pay'    =>1
            ];

            $BillService = new \app\service\BillService;
            $result = $BillService->pay($billData,['bill_order'=>$data['out_trade_no']]);  
            if($result){
                return xml($msg);
            }
        }else{
            return xml($msg);
        }    
        
	}
}