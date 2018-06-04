<?php
// 前端控制器基类
namespace app\index\controller;

use app\frontend\controller\Base;

class Wechatpay extends Base
{

    public function _initialize(){
        parent::_initialize();
    }


    public function wechatPay(){
        $total = ceil(input('param.total',1)); 
        $total = 0.01;
        $billOrder = '3'.getOrderID(rand(0,9));
        $jsonBillInfo = [
            'goods'=>'篮球管家平台充值',
            'goods_id'=>0,
            'camp_id'=>0,
            'camp'=>'篮球管家平台',
            'organization_type'=>0,
            'price'=>$total,
            'score_pay'=>0,
            'goods_type'=>0,
            'pay_type'=>'wxpay',
        ];

        $WechatJsPayService = new \app\service\WechatJsPayService;
        $result = $WechatJsPayService->pay(['order_no'=>$billOrder,'amount'=>$total]);
        
        $jsApiParameters = $result['data']['jsApiParameters'];
        $url = request()->url(true);//支付链接
        $wechatS = new \app\service\WechatService;
        $jsApi = $wechatS->jsapi($url);

        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('jsApi', $jsApi);
        $this->assign('jsonBillInfo',json_encode($jsonBillInfo));
        $this->assign('billOrder',$billOrder);
        return $this->fetch('Wechatpay/wechatPay');
    }
    
}