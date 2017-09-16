<?php
namespace app\service;
use mikkle\tp_wxpay\UnifiedOrder_pub as UnifiedOrder;;
use mikkle\tp_wxpay\JsApi_pub as JaApi;
class WechatJsPayService {

    protected $openid;
    protected $option;
    protected $notify_url =  'https://m.hot-basketball.com/api/Wxpay/notifyUrl';
    public function __construct(){
        $memberInfo = session('memberInfo','','think');
        $this->openid = $memberInfo['openid'];
        $this->option = [
            'appid'     =>config('appid'),
            'mchid'     =>config('mchid'),
            'appsecret' =>config('appsecret'),
            'key'       =>config('key'),
            'sslcert_path'=>'',
            'sslkey_path'=> '',
        ];
    }

    // 统一下单
    public function pay($data){
            dump($this->openid);die;
          $unified_order = $this->unifiedOrder($data);  //统一下单
          $jsApiParameters=$this->getParameters($unified_order);
          return ['code'=>100,'msg'=>'','data'=>['order_no'=>$data['order_no'],'jsApiParameters'=>$jsApiParameters,'amount'=>$data['amount']]];
    }


    protected function unifiedOrder($data=[]){

        $unifiedOrder = new UnifiedOrder;
        $unifiedOrder->setParameter("openid",$this->openid);       // openid
        $unifiedOrder->setParameter("body",'商品订单号'+$data['order_no']);    // 商品描术
        $unifiedOrder->setParameter("out_trade_no",$data['order_no'].'_'.$unifiedOrder->createNoncestr(6));  // 商户订单号
        $unifiedOrder->setParameter("total_fee",$data['amount']*100);    // 总金额
        $unifiedOrder->setParameter("notify_url",$this->notify_url);  // 通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");      // 交易类型
        return $unifiedOrder->getPrepayId();
    }

    protected function getParameters($unified_order=''){
        $jsApi= new JaApi();
        $jsApi->setPrepayId($unified_order);
        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }

}