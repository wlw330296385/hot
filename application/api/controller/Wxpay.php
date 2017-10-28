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

        $data = input();
        if(is_string($data)){
            db('log_wxpay')->insert(['callback'=>$data,'create_time'=>time()]);
        }else{
            db('log_wxpay')->insert(['callback'=>json_encode($data),'create_time'=>time()]);
        }
       
	}
}