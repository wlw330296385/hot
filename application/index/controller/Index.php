<?php
namespace app\index\controller;
use think\Controller;
use think\Cookie;
use think\Db;
class Index extends Controller{



    public function index(){
        $list = Db::table();
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
                        "url" => url('frontend/bill/billInfoOfCamp',['bill_id'=>1201711011851072758],'',true),
                        "topcolor"=>"#FF0000",
                        "data" => [
                            'first' => ['value' => '梁浩峰购买课程订单支付成功补发通知'],
                            'keyword1' => ['value' => '梁浩峰'],
                            'keyword2' => ['value' => '1201711011851072758'],
                            'keyword3' => ['value' => '1500元'],
                            'keyword4' => ['value' => '梁浩峰购买课程'],
                            'remark' => ['value' => '大热篮球']
                        ]
                    ];
        $MessageCampSaveData = [
                                'title'=>"购买课程-石厦学校兰球队",
                                'content'=>"订单号: 1201711011851072758<br/>支付金额: 1500元<br/>购买学生:梁浩峰<br/>购买理由: 系统补发",
                                'member_id'=>101,
                                'url'=>url('frontend/bill/billInfoOfCamp',['bill_id'=>'1201711011851072758'],'',true)
                            ];

        // 发送个人消息
        $MessageData = [
            "touser" => 'o83291ONqTeJlke5wNqfpsh8Oo0Q',
            "template_id" => config('wxTemplateID.successBill'),
            "url" => url('frontend/bill/billInfo',['bill_id'=>'1201711011851072758'],'',true),
            "topcolor"=>"#FF0000",
            "data" => [
                'first' => ['value' => '订单支付成功通知'],
                'keyword1' => ['value' => '梁浩峰'],
                'keyword2' => ['value' => '1201711011851072758'],
                'keyword3' => ['value' => '1500元'],
                'keyword4' => ['value' => '梁浩峰购买课程'],
                'remark' => ['value' => '大热篮球']
            ]
        ];
        $saveData = [
                        'title'=>"订单支付成功-石厦学校兰球队",
                        'content'=>"订单号: 1201711011851072758<br/>支付金额: 1500元<br/>支付学生信息:梁浩峰",
                        'url'=>url('frontend/bill/billInfo',['bill_order'=>'1201711011851072758']),
                        'member_id'=>101
                    ];
        $MessageService->sendMessageMember(101,$MessageData,$saveData);            
        $MessageService->sendCampMessage(15,$MessageCampData,$MessageCampSaveData);
    }

}