<?php
namespace app\index\controller;
use think\Controller;
use think\Cookie;
use think\Db;
class Index extends Controller{



    public function index(){
        $xml = '<xml><appid><![CDATA[wx19f60be0f2f24c31]]></appid>
                <bank_type><![CDATA[CFT]]></bank_type>
                <cash_fee><![CDATA[150000]]></cash_fee>
                <fee_type><![CDATA[CNY]]></fee_type>
                <is_subscribe><![CDATA[N]]></is_subscribe>
                <mch_id><![CDATA[1488926612]]></mch_id>
                <nonce_str><![CDATA[alw7b10lcwiorixu0deh3ul4ooycn6rb]]></nonce_str>
                <openid><![CDATA[o83291NM7kHtVyTmKG-ao5-Pxwzo]]></openid>
                <out_trade_no><![CDATA[1201711031610202726]]></out_trade_no>
                <result_code><![CDATA[SUCCESS]]></result_code>
                <return_code><![CDATA[SUCCESS]]></return_code>
                <sign><![CDATA[430A51B37742ABF6D5F6CBECF84E09C5]]></sign>
                <time_end><![CDATA[20171103160702]]></time_end>
                <total_fee>150000</total_fee>
                <trade_type><![CDATA[JSAPI]]></trade_type>
                <transaction_id><![CDATA[4200000027201711032186864528]]></transaction_id>
                </xml>';
                $obj=simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA);
                $jsonObj = json_encode($obj);
                $data = json_decode($jsonObj,true);
        dump($data);die;
        return view('Index/index');
    }
    
    public function grade(){
        // $GradeService = new \app\service\GradeService;
        // $result = $GradeService->getGradeListByPage([]);
        $result = db('grade')->select();
        dump($result);die;
        foreach($result as $key =>&$value){
            if($value['student_str'] == 0){
                $value['student_str'] = '';
            }
            if($value['status'] == 0){
                $value['status'] = 1;
            }
        }
        $GradeModel = new \app\model\Grade;
        $GradeModel->saveAll($result); 
    }
        
    public function getGradeStudentStr(){
        $GradeService = new \app\service\GradeService;
        $result = $GradeService->getGradeListByPage([]);
        // $list = $result->toArray();
        $list = [];
        dump($result);die;
        foreach ($result['data'] as $key => &$value) {
            // dump($value['grade_member']);
            $value['grade_member'] = $value['grade_member']->toArray();
        }
        $list = $result['data'];
        foreach ($list as $key => &$value) {
            if($value['student_str'] == 0){
                $value['student_str'] ='';
            }
            foreach ($value['grade_member'] as $ky => $val) {
                // dump($val);
                $value['student_str'] .= $val['student'].',';
            }
            $value['student_str'] = substr($value['student_str'],0,strlen($value['student_str'])-1);
            unset($value['grade_member']);
            unset($value['status']);
        }
        dump($list);
        $GradeModel = new \app\model\Grade;
        $GradeModel->saveAll($list);
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