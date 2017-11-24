<?php
namespace app\index\controller;
use think\Controller;
use think\Cookie;
use think\Db;
use app\service\WechatService;
class Index extends Controller{

    public function counttest(){
        db('log_wxpay')->count('*');
        echo db('log_wxpay')->getlastsql();
    }

    public function index(){
        $timestr = strtotime('2017-11-16');
        // 生成微信参数
        $shareurl = request()->url(true);
        $WechatService = new WechatService();
        $jsApi = $WechatService->jsapi($shareurl);
        // echo $timestr-time();
        $this->assign('timestr',time());
        $this->assign('jsApi',$jsApi);
        return view('Index/index');
    }


    public function gdMap(){



        return view('Index/gdMap');

    }

    public function wxMap(){
        // 生成微信参数
        $shareurl = request()->url(true);
        $WechatService = new WechatService;
        $jsApi = $WechatService->jsapi($shareurl); 
        $this->assign('jsApi',$jsApi);   
        return view('Index/wxMap');
    }
    

    public function xmltest(){
       $xml = '<xml><appid><![CDATA[wx19f60be0f2f24c31]]></appid>
                <bank_type><![CDATA[CFT]]></bank_type>
                <cash_fee><![CDATA[120000]]></cash_fee>
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
                <total_fee>120000</total_fee>
                <trade_type><![CDATA[JSAPI]]></trade_type>
                <transaction_id><![CDATA[4200000027201711032186864528]]></transaction_id>
                </xml>';
                $obj=simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA);
                $jsonObj = json_encode($obj);
                $data = json_decode($jsonObj,true);
        dump($data);die; 
    }
    public function grade(){
        $action = input('param.action');
        if($action!= 'woo'){

            return '???';die;
        }
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
        $action = input('param.action');
        if($action!= 'woo'){

            return '???';die;
        }
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
        $id = input('id',6);
        $memberInfo = db('member')->find($id);
        dump($memberInfo);
        if($memberInfo['realname']){
            dump($memberInfo['realname']) ;
        }else{
            // dump($memberInfo['realname']);
            echo 22;
        }
    	// return view('Index/test');
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
                        "url" => url('frontend/bill/billInfoOfCamp',['bill_order'=>'1201711081030416766'],'',true),
                        "topcolor"=>"#FF0000",
                        "data" => [
                            'first' => ['value' => '李鸣轩购买课程订单支付成功补发通知'],
                            'keyword1' => ['value' => '李鸣轩'],
                            'keyword2' => ['value' => '1201711081030416766'],
                            'keyword3' => ['value' => '1200元'],
                            'keyword4' => ['value' => '李鸣轩购买课程'],
                            'remark' => ['value' => '大热篮球']
                        ]
                    ];
        $MessageCampSaveData = [
                                'title'=>"购买课程-龙岗民警子女篮球课程",
                                'content'=>"订单号: 1201711081030416766<br/>支付金额: 1200元<br/>购买学生:李鸣轩<br/>购买理由: 系统补发",
                                'member_id'=>125,
                                'url'=>url('frontend/bill/billInfoOfCamp',['bill_order'=>'1201711081030416766'],'',true)
                            ];

        // 发送个人消息
        $MessageData = [
            "touser" => 'o83291A4UscsGS6_i1solCR2Ly4U',
            "template_id" => config('wxTemplateID.successBill'),
            "url" => url('frontend/bill/billInfo',['bill_order'=>'1201711081030416766'],'',true),
            "topcolor"=>"#FF0000",
            "data" => [
                'first' => ['value' => '订单支付成功通知'],
                'keyword1' => ['value' => '李鸣轩'],
                'keyword2' => ['value' => '1201711081030416766'],
                'keyword3' => ['value' => '1200元'],
                'keyword4' => ['value' => '李鸣轩购买课程'],
                'remark' => ['value' => '大热篮球']
            ]
        ];
        $saveData = [
                        'title'=>"订单支付成功-龙岗民警子女篮球课程",
                        'content'=>"订单号: 1201711081030416766<br/>支付金额: 1200元<br/>支付学生信息:李鸣轩",
                        'url'=>url('frontend/bill/billInfo',['bill_order'=>'1201711081030416766']),
                        'member_id'=>125
                    ];
        $MessageService->sendMessageMember(125,$MessageData,$saveData);            
        $MessageService->sendCampMessage(9,$MessageCampData,$MessageCampSaveData);
    }



    public function insertLessonMember(){
        $action = input('param.action');
        if($action!= 'woo'){

            return '???';die;
        }
        $grade_member = db('grade_member')->select();
        foreach ($grade_member as $key => &$value) {
            unset($value['id']);
        }

        // dump($grade_member);die;
        $LessonMmeber = new \app\model\LessonMember;
        $LessonMmeber->saveAll($grade_member);

    }

    public function repairCourt(){
        $result = db('court_camp')
                ->field("camp_id,count('court_id') camp_base,camp")
                ->where('delete_time','null')
                ->group('camp_id')
                ->select();
                echo db('court_camp')->getlastsql();
        dump($result);
        foreach ($result as $key => $value) {
           db('camp')->where(['id'=>$value['camp_id']])->update(['camp_base'=>$value['camp_base']]);
        }
    }

    public function repairBill(){
        $result = db('bill')
                ->where(['balance_pay'=>0])
                ->update(['expire'=>time()+86400]);
        
    }

    public function repairStudentStotalschedule(){
        // $studentList = db('lesson_member')->field('sum(`rest_schedule`) total_schedule,student_id id')->group('student_id')->select();

        $studentList = db('bill')->field('sum(`total`) total_schedule,student_id id')->where(['is_pay'=>1,'status'=>1,'expire'=>0,'goods_type'=>1])->group('student_id')->select();
        dump(db('bill')->getlastsql()) ;
        // dump($studentList);die;
        $StudentModel = new \app\model\Student;
        $StudentModel->saveAll($studentList);
        echo $StudentModel->getlastsql();
    }


    public function repairStudentStotalslesson(){
        // $studentList = db('lesson_member')->field('sum(`rest_schedule`) total_schedule,student_id id')->group('student_id')->select();

        $studentList = db('bill')->field('count(`goods_id`) total_lesson,student_id id')->where(['is_pay'=>1,'status'=>1,'expire'=>0,'goods_type'=>1])->group('student_id')->select();
        dump(db('bill')->getlastsql()) ;
        // dump($studentList);die;
        $StudentModel = new \app\model\Student;
        $StudentModel->saveAll($studentList);
        echo $StudentModel->getlastsql();
    }
}