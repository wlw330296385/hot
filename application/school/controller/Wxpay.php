<?php 
namespace app\school\Controller;

use Think\Controller;
use Think\Log;
class Wxpay extends Controller{

	// protected $option;
	// public function _initialize(){
	// 	Vendor('WxPayPubHelper.WxPayPubHelper');
	// 	$this->option = [
 //            'appid'     =>config('appid'),
 //            'mchid'     =>config('mchid'),
 //            'key'       =>config('key'),
 //            'appsecret' =>config('appsecret'),
 //        ];
	// }

	// // 获取微信JSpay参数
 //    public function getParameters($out_trade_no,$total){
    	
    
 //    $total ==$total?$total :1;
 //    //①、获取用户openid
	// $openid = session('user.openid');
	// //使用jsapi接口
 //    $jsApi = new \JsApi_pub($this->option);
 //    $unifiedOrder = new \UnifiedOrder_pub($this->option);
 //    //设置统一支付接口参数
 //    $unifiedOrder->setParameter("openid", $openid);                  		//商品描述
 //    $unifiedOrder->setParameter("body", "支付订单费用");                    //商品描述
 //    $unifiedOrder->setParameter("out_trade_no", $out_trade_no);             //商户订单号
 //    $unifiedOrder->setParameter("total_fee", $total);                   	//总金额
 //    $unifiedOrder->setParameter("notify_url", \WxPayConf_pub::NOTIFY_URL);  //通知地址
 //    $unifiedOrder->setParameter("trade_type", "JSAPI");                     //交易类型
 //    $prepay_id = $unifiedOrder->getPrepayId();

 //    //=========步骤3：使用jsapi调起支付============
 //    $jsApi->setPrepayId($prepay_id);
 //    $jsApiParameters = $jsApi->getParameters();
 //    return $jsApiParameters;
 //    }


}