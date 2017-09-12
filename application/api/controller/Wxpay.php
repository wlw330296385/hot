<?php 
namespace api\Controller;

use Think\Controller;
use Think\Log;
class Wxpay extends Frontend{

	public function index($order_no='2017020453102495'){
        $data=controller('base/WxPay')->payByOrderNo($order_no);
        $this->assign('amount',$data['amount']);
        $this->assign('order_no',$order_no);
        $this->assign("jsApiParameters" ,$data['jsApiParameters']);
        $this->assign('openid',$this->open_id);
        return $this->fetch('wxpay/pay');
    }


    public function pay(){
    	
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