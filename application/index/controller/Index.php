<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $ress = db('student')->where(['id'=>1])->inc('total_lesson',1)->inc('total_schedule',2)->update();
    	return view('Index/index');
    }

    public function wxbind() {
        $WeixinService = new Weixin();
        $WeixinService->mpbind();
    }

    public function test(){
    	return view('Index/test');
    }


    public function sendMsg(){
        $MessageCampData = [
                        "touser" => '',
                        "template_id" => config('wxTemplateID.successBill'),
                        "url" => url('frontend/bill/billInfoOfCamp',['bill_id'=>$this->Bill->id],'',true),
                        "topcolor"=>"#FF0000",
                        "data" => [
                            'first' => ['value' => '蒋清奕购买课程订单支付成功补发通知'],
                            'keyword1' => ['value' => '蒋清奕'],
                            'keyword2' => ['value' => '1201710231510000000'],
                            'keyword3' => ['value' => '1500元'],
                            'keyword4' => ['value' => '蒋清奕购买课程'],
                            'remark' => ['value' => '大热篮球']
                        ]
                    ];
        $MessageCampSaveData = [
                                'title'=>"购买课程-北大附小一年级",
                                'content'=>"订单号: {$data['bill_order']}<br/>支付金额: {$data['balance_pay']}元<br/>购买学生:{$data['student']}<br/>购买理由: {$data['remarks']}",
                                'member_id'=>$data['member_id'],
                                'url'=>url('frontend/bill/billInfoOfCamp',['bill_id'=>$this->Bill->id],'',true)
                            ];
        $MessageService->sendCampMessage($data['camp_id'],$MessageCampData,$MessageCampSaveData);
    }
}
