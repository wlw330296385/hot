<?php
namespace app\index\controller;
use think\Controller;
use think\Cookie;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        $list = Db::view('member')
                ->view('student','member_id,student','student.member_id = member.id')
                // ->where(1)
                ->order('member.id asc')
                ->select();
        dump($list);die;
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
        $action = input('param.action');
        if($action!= 'woo'){
            return '???';die;
        }
        $MessageService = new \app\service\MessageService;
        $MessageCampData = [
                        "touser" => '',
                        "template_id" => config('wxTemplateID.successBill'),
                        "url" => url('frontend/bill/billInfoOfCamp',['bill_id'=>77],'',true),
                        "topcolor"=>"#FF0000",
                        "data" => [
                            'first' => ['value' => '蒋清奕购买课程订单支付成功补发通知'],
                            'keyword1' => ['value' => '李泓'],
                            'keyword2' => ['value' => '1201710231510000001'],
                            'keyword3' => ['value' => '1500元'],
                            'keyword4' => ['value' => '李泓购买课程'],
                            'remark' => ['value' => '大热篮球']
                        ]
                    ];
        $MessageCampSaveData = [
                                'title'=>"购买课程-松坪小学",
                                'content'=>"订单号: 1201710231510000001<br/>支付金额: 1500元<br/>购买学生:李泓<br/>购买理由: 系统补发",
                                'member_id'=>89,
                                'url'=>url('frontend/bill/billInfoOfCamp',['bill_id'=>77],'',true)
                            ];
        $MessageService->sendCampMessage(15,$MessageCampData,$MessageCampSaveData);
    }
}
