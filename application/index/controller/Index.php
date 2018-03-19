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
        phpinfo();
    }
    

    public function test(){
        $list = [];
        for ($i=1; $i <= 16; $i++) { 
            $list[]  = $i;
            $list[]  = $i;
            $list[]  = $i;
            $list[]  = $i;
        }

        $times = 1;
        foreach ($list as $key => &$value) {
            $value = $value*10;
            if($times == 4){
                $times = 5;
            }
            $value.=$times;
            $times++;
            if($times>5){
                $times = 1;
            }
        }

        dump($list);
        foreach ($list as $key => $value) {
           db('test')->insert(['name'=>$value]);
        }
    }

    public function salaryinStudents(){
        $list = db('salary_in')->field('salary_in.id,salary_in.schedule_id,schedule.students')->join('schedule','schedule.id=salary_in.schedule_id')->select();
        dump($list);
        foreach ($list as $key => $value) {
            db('salary_in')->where(['id'=>$value['id']])->update(['students'=>$value['students']]);
        }
    }

    public function scheduleSassistantsalary(){
        // UPDATE `schedule` SET s_coach_salary = coach_salary+students*salary_base;
        $list1 = db('schedule')->select();
        foreach ($list1 as $key => $value) {
            if($value['assistant_id']){
                $assistant_num = count(unserialize($value['assistant_id']));
                $s_assistant_salary =  ($assistant_num * $value['assistant_salary']) + ($value['students']*$value['salary_base']);
                dump($s_assistant_salary);
                db('schedule')->where(['id'=>$value['id']])->update(['s_assistant_salary'=>$s_assistant_salary]);
            }
            
        }

    }

 
    public function scheduletime(){
        $list1 = db('income')->field('income.id,income.f_id,schedule.students,schedule.lesson_time as schedule_time,schedule.schedule_income')->join('schedule','income.f_id = schedule.id')->where(['income.type'=>3])->select();
        $income = new \app\model\Income;
        $income->saveAll($list1);
    }
    // 1 退费订单
    public function income(){
        $billList = db('bill')->where('delete_time',null)->where(['is_pay'=>1,'status'=>1])->select();
        $data = [];
        foreach ($billList as $key => &$value) {
            $campInfo = db('camp')->where(['id'=>$value['camp_id']])->find();
            $data['type'] = $value['goods_type'];
            $data['lesson_id'] = $value['goods_id'];
            $data['lesson'] = $value['goods'];
            $data['goods_id'] = $value['goods_id'];
            $data['goods'] = $value['goods'];
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['total'] = $value['total'];
            $data['member_id'] = $value['member_id'];
            $data['member'] = $value['member'];
            $data['price'] = $value['price'];
            $data['f_id'] = $value['id'];
            $data['student_id'] = $value['student_id'];
            $data['student'] = $value['student'];
            $data['balance_pay'] = $value['balance_pay'];
            $data['income'] = $value['balance_pay'];
            $data['create_time'] = $value['create_time'];
            $data2['type'] = 1;
            $data2['camp_id'] = $value['camp_id'];
            $data2['camp'] = $value['camp'];
            $data2['f_id'] = $value['id'];
            $data2['money'] = $value['balance_pay'];
            $data2['create_time'] = $value['create_time'];
            $data2['date_str'] = date('Ymd',$value['create_time']);
            $data2['datetime'] = $value['create_time'];
            if($campInfo['rebate_type'] == 2){
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                db('camp')->where(['id'=>$value['camp_id']])->inc('balance',$value['balance_pay'])->update();
            }else{
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance'];
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'];
            }
            db('income')->insert($data);
            db('camp_finance')->insert($data2);
        }
    }

    // 2 退费订单
    public function output(){
        $billList = db('bill')->where('delete_time',null)->where(['is_pay'=>1,'status'=>-2])->select();
        $data = [];
        foreach ($billList as $key => &$value) {
            $campInfo = db('camp')->where(['id'=>$value['camp_id']])->find();
            $data['type'] = 2;
            $data['s_balance'] = $campInfo['balance'];
            $data['e_balance'] = $campInfo['balance'];
            $data['member_id'] = $value['member_id'];
            $data['member'] = $value['member'];
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['f_id'] = $value['id'];
            $data['output'] = $value['refundamount'];
            $data['create_time'] = $value['create_time'];
            
            $data2['type'] = -3;
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['f_id'] = $value['id'];
            $data['output'] = $value['refundamount'];
            $data['create_time'] = $value['create_time'];    
            $data2['money'] = $value['balance_pay'];
            if($campInfo['rebate_type'] == 2){
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                db('camp')->where(['id'=>$value['camp_id']])->dec('balance',$value['refundamount'])->update();
            }else{
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance']; 
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'];
            }
            db('output')->insert($data);
            db('camp_finance')->insert($data2);
        }
    }

    // 3
    public function gift(){
        $giftList = db('schedule_giftrecord')->field('schedule_giftrecord.*,lesson.cost')->join('lesson','lesson.id=schedule_giftrecord.lesson_id')->where('schedule_giftrecord.delete_time',null)->select();      
        $data = [];
        foreach ($giftList as $key => $value) {
            $campInfo = db('camp')->where(['id'=>$value['camp_id']])->find();
            $data['type'] = 1;
            $data['member_id'] = $value['member_id'];
            $data['member'] = $value['member'];
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['f_id'] = $value['id'];
            $data['output'] = $value['student_num']*$value['gift_schedule']*$value['cost'];
            $data['create_time'] = $value['create_time'];
            $data['s_balance'] = $campInfo['balance'];
            $data['e_balance'] = $campInfo['balance'] - $data['output'];
            db('output')->insert($data);
            db('camp')->where(['id'=>$value['camp_id']])->dec('balance',$data['output'])->update();
        }
        

    }

    public function schedulecost(){
        $list = db('schedule')->select();
        foreach ($list as $key => $value) {
            $lesson = db('lesson')->where(['id'=>$value['lesson_id']])->find();
            if($lesson){
                db('schedule')->where(['id'=>$value['id']])->update(['cost'=>$lesson['cost']]);
            }
        }
    }

    public function follow(){
        $campmember = db('camp_member')->field('member,member_id,camp as follow_name,camp_id as follow_id,create_time')->where('delete_time',null)->select();
        $follow = new \app\model\Follow;
        $follow->saveAll($campmember);
    }

    public function eventMemberTotal(){
        $list = db('bill')->where(['goods_type'=>2,'status'=>1,'is_pay'=>1])->select();
        foreach ($list as $key => $value) {
            db('event_member')->where(['member_id'=>$value['member_id'],'event_id'=>$value['goods_id']])->update(['total'=>$value['total']]);
        }

    }

    public function spu(){
        $a = [
            ['name'=>'包车','price'=>5200],
            ['name'=>'不包车','price'=>5000]
        ];
        $b = in_array('1,2,3,4', ['a'=>1]);
        dump($b);
        echo json_encode($a);
    }

    public function insql(){
        $service = new \app\service\ItemCouponService;
        $ids = [];
        for ($i=0; $i < 30;$i++) { 
            $ids[] = $i;    
        }
        $service->createItemCouponMemberList(8,'woo',$ids);


    }
    /** 
    * @desc 根据两点间的经纬度计算距离 
    * @param float $lat 纬度值 
    * @param float $lng 经度值 
    */
    // public function test(){
    //     $earthRadius = 6367000;//地球半径(米);
    //     $a = [113.9108100000,22.5235500000];//lng,lat;阳光文体中心坐标
    //     $b = [113.9128589630,22.5232210498];//lng,lat阳光小学坐标
    //     $lat1 = ($a[0] * pi())/180;//纬度换算;
    //     $lng1 = ($a[1] * pi())/180;//经度换算;

    //     $lat2 = ($b[0] * pi())/180;//纬度换算;
    //     $lng2 = ($b[1] * pi())/180;//经度换算;
    //     $calcLongitude = $lng2 - $lng1; 
    //     $calcLatitude = $lat2 - $lat1; 
    //     $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
    //     $stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
    //     $calculatedDistance = $earthRadius * $stepTwo; 
    //     // echo floor($calculatedDistance);
    //     echo round($calculatedDistance); 

    //     return view('Index/test');
    // }

    public function totalSchedule(){
        $giftRecord = db('schedule_giftrecord')->select();
        $list = [];
        foreach ($giftRecord as $key => &$value) {
            $studentList = json_decode($value['student_str'],true);
            foreach ($studentList as $k => $val) {
                
                $list[] = [
                    'student'=> $val['student'],
                    'student_id'=>$val['student_id'],
                    'member'=>$value['member'],
                    'member_id'=>$value['member_id'],
                    'camp'=>$value['camp'],
                    'camp_id'=>$value['camp_id'],
                    'lesson_id'=>$value['lesson_id'],
                    'lesson'=>$value['lesson'],
                    'grade'=>$value['grade'],
                    'grade_id'=>$value['grade_id'],
                    'gift_schedule'=>$value['gift_schedule'],
                    'remarks'=>$value['remarks'],
                    'status'=>$value['status'],
                    'system_remarks'=>'',
                    'delete_time'=>$value['delete_time'],
                    'create_time'=>$value['create_time'],
                    'update_time'=>$value['update_time'],
                ];
   
                
            }

        }
        dump($list);
        foreach ($list as $key => $value) {
            db('schedule_gift_student')->insert($value);
        }
        
    }



    public function totalLessonSchedule(){
        // 赠送课时的数量
        $scheduleGiftList = db('schedule_gift_student')
        ->field("student_id,lesson_id,lesson,student,sum(gift_schedule) total ")
        ->where('delete_time',null)
        ->group('student_id,lesson_id')
        ->select();
        // dump($scheduleGiftList);
        foreach ($scheduleGiftList as $key => $value) {
            db('lesson_member')->where(['lesson_id'=>$value['lesson_id'],'student_id'=>$value['student_id'],'status'=>1,'type'=>1])->setInc('total_schedule',$value['total']);
        }
        $scheduleBuyList = db('bill')
        ->field("student_id,goods_id as lesson_id,goods as lesson,student,sum(total) total ")
        ->where(['status'=>1,'is_pay'=>1,'goods_type'=>1])
        ->group('student_id,goods_id')
        ->select();
        foreach ($scheduleBuyList as $key => $value) {
            db('lesson_member')->where(['lesson_id'=>$value['lesson_id'],'student_id'=>$value['student_id'],'status'=>1,'type'=>1])->setInc('total_schedule',$value['total']);
        }
        echo '<br /><br /><br />--------------------------------------------------------------------------<br />成功<br /><br /><br />--------------------------------------------------------------------------<br />';
        dump($scheduleBuyList);
    }
    

  

    public function adminAuth(){
        $res = db('admin_menu')
                ->where(['pid'=>4])
                ->whereOr('pid =5')
                ->whereOr('pid = 3')
                ->column('id');
        echo json_encode($res);
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
    

    public function exerciseSort(){
        header("Content-Type:text/html;charset=utf-8");
        $str = file_get_contents(ROOT_PATH.'/data/exercise.txt');
        dump($str);
        $arrr = ['a'=>['a'=>2,'b'=>2],'b'=>['a'=>2,'b'=>3]];
        $strr = json_encode($arrr);


        dump(json_decode($strr,true));
        $arr = json_decode($str,true);
        dump($arr);
    }


    public function getStudentAddress(){
        $students = db('lesson_member')->field('lesson_member.student_id,lesson_member.lesson_id,lesson.area')->join('lesson','lesson.id=lesson_member.lesson_id')->distinct('student_id')->order('lesson_member.id')->select();


        foreach ($students as $key => $value) {

            $update = ['student_province'=>'广东省','student_city'=>'深圳市','student_area'=>$value['area']];
            db('student')->where(['id'=>$value['student_id']])->update($update);
        }
    }

    public function getPost(){
        $model = new \app\model\Exercise;
        $postData = input('post.');
        $arr = [];
        foreach ($postData as $key => $value) {
            // $save = ['exercise_setion'=>$value['exercise_setion'],'exercise'=>$value['exercise_setion'],'camp_id'=>0,'pid'=>0,'id'=>$key+1,'create_time'=>time(),'member'=>'平台'];
            // db('exercise')->insert($save);
            foreach ($value['sub'] as $k => $v) {
                $save = ['exercise_setion'=>$value['exercise_setion'],'exercise'=>$v['exercise'],'camp_id'=>0,'pid'=>$v['pid'],'create_time'=>time(),'member'=>'平台','exercise_detail'=>$v['exercise_detail']];
                db('exercise')->insert($save);
            }
        }
       
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
        
    




    
    public function sendMsg(){
        $action = input('param.action');
        if($action!= 'woo'){

            return '???';die;
        }
        
        $MessageService = new \app\service\MessageService;
        $MessageCampData = [
                        "touser" => '',
                        "template_id" => config('wxTemplateID.successBill'),
                        "url" => url('frontend/bill/billInfoOfCamp',['bill_order'=>'1201712190929205361'],'',true),
                        "topcolor"=>"#FF0000",
                        "data" => [
                            'first' => ['value' => '强亦宸购买课程订单支付成功补发通知'],
                            'keyword1' => ['value' => '强亦宸'],
                            'keyword2' => ['value' => '1201712190929205361'],
                            'keyword3' => ['value' => '1500元'],
                            'keyword4' => ['value' => '强亦宸购买课程'],
                            'remark' => ['value' => '大热篮球']
                        ]
                    ];
        $MessageCampSaveData = [
                                'title'=>"购买课程-大热常规班",
                                'content'=>"订单号: 1201712190929205361<br/>支付金额: 1200元<br/>购买学生:强亦宸<br/>购买理由: sys",
                                'member_id'=>244,
                                'url'=>url('frontend/bill/billInfoOfCamp',['bill_order'=>'1201712190929205361'],'',true)
                            ];

        // 发送个人消息
        $MessageData = [
            "touser" => '',
            "template_id" => config('wxTemplateID.successBill'),
            "url" => url('frontend/bill/billInfo',['bill_order'=>'1201712190929205361'],'',true),
            "topcolor"=>"#FF0000",
            "data" => [
                'first' => ['value' => '订单支付成功通知'],
                'keyword1' => ['value' => '强亦宸'],
                'keyword2' => ['value' => '1201712190929205361'],
                'keyword3' => ['value' => '1500元'],
                'keyword4' => ['value' => '强亦宸购买课程'],
                'remark' => ['value' => '大热篮球']
            ]
        ];
        $saveData = [
                        'title'=>"订单支付成功-大热常规班",
                        'content'=>"订单号: 1201712190929205361<br/>支付金额: 1200元<br/>支付学生信息:强亦宸",
                        'url'=>url('frontend/bill/billInfo',['bill_order'=>'1201712190929205361']),
                        'member_id'=>244
                    ];
        $MessageService->sendMessageMember(244,$MessageData,$saveData);            
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

        $studentList = db('lesson_member')->field('count(`lesson_id`) total_lesson,student_id id')->group('student_id')->select();
        dump(db('bill')->getlastsql()) ;
        // dump($studentList);die;
        $StudentModel = new \app\model\Student;
        $StudentModel->saveAll($studentList);
        echo $StudentModel->getlastsql();
    }


    public function sortGC(){
        
        $arr = db('grade_category')->order('sort asc')->select();
        $arr = $this->getGradeCategoryTree($arr);
        $this->assign('arr',$arr);
        return view('Index/sortGC');
        // dump($arr);
    }



    protected function getGradeCategoryTree($arr = [],$pid = 0){
        $list = [];
         foreach ($arr as $key => $value) {
            if($value['pid'] == $pid){
                $value['daughter'] = $this->getGradeCategoryTree($arr,$value['id']);
               $list[] = $value;
            }
        }
        return $list;
    }

    public function sortLesson(){
        $list = Db::view('lesson','*')
                ->view('grade_category','pid','lesson.gradecate_id=grade_category.id')
                ->select();
        
        foreach ($list as $key => $value) {
            $name = db('grade_category')->where(['id'=>$value['pid']])->value('name');    
            $list[$key]['gradecate_setion'] = $name;
            $list[$key]['gradecate_setion_id'] = $value['pid'];

            db('lesson')->where(['id'=>$value['id']])->update(['gradecate_setion_id'=>$value['pid'],'gradecate_setion'=>$name]);
        }     
       
    }

    public function sortGrade(){
        $list = Db::view('grade','*')
                ->view('lesson','gradecate gradecates, gradecate_id gradecate_ids, gradecate_setion gradecate_setions,gradecate_setion_id gradecate_setion_ids','lesson.id=grade.lesson_id')
                ->select();
        foreach ($list as $key => $value) { 
            db('grade')->where(['id'=>$value['id']])->update(['gradecate'=>$value['gradecates'],'gradecate_id'=>$value['gradecate_ids'],'gradecate_setion'=>$value['gradecate_setions'],'gradecate_setion_id'=>$value['gradecate_setion_ids']]);
        }     
       
    }

    public function gradecate(){
        $arr = db('test')->where(['pid'=>0])->select();
        foreach ($arr as $key => $value) {
            $data1 = ['sort'=>99,'pid'=>$value['id'],'name'=>'花式篮球课程'];
            $data2 = ['sort'=>99,'pid'=>$value['id'],'name'=>'专项训练课程'];
            db('test')->insert($data1);
            db('test')->insert($data2);
        }
        
    }

    public function getLocation(){
        $aee = file_get_contents('https://api.map.baidu.com/location/ip?ak=g5XXhTU6gY4Ka68E5ktVMrGz2uiosuTE&coor=bd09ll');
        dump($aee);die;
    }

    public function getAdmin(){
        $ids = db('admin_menu')->column('id');
        dump(json_encode($ids));
        db('admin_group')->where(['pid'=>1])->update(['menu_auth'=>json_encode($ids)]);
    }
}