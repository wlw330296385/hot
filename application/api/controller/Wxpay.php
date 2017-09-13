<?php 
namespace api\Controller;

use Think\Controller;
use Think\Log;
class Wxpay extends Frontend{

	public function index(){
    }


    public function pay(){
    	
    }

    // 获取parameters
    public function getParametersApi(){
        try{
            $data = input('post.');
            $WechatJsPayService = new \app\service\WechatJsPayService();
            $parameters = $WechatJsPayService->pay($data);
            return json(['code'=>100,'msg'=>'o','data'=>$parameters]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
        
    }

	/**
	 * 异步通知接口
	 * @return void
	 */
	public function notifyUrl()
	{
	    return $this-input();
	}
}