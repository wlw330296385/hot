<?php 
namespace app\frontend\controller;
use app\frontend\controller\Frontend;
use app\service\BillService;
class Bill extends Base{
	protected $BillService;
	public function _initialize(){
		parent::_initialize();
        $this->BillService = new BillService;
	}

    public function index() {
    	
        return view();
    }

    //训练营查看会员订单
    public function billInfoOfCamp(){
        $bill_id = input('param.bill_id');
        $billInfo = $this->BillService->getBill(['id'=>$bill_id]);
        $lessonInfo = [];
        $studentInfo = [];
        // 课程信息
        if($billInfo['goods_type'] == '课程'){
            $LessonService = new \app\service\LessonService;
            $lessonInfo = $LessonService->getLessonInfo(['id'=>$billInfo['goods_id']]);
            $this->assign('lessonInfo',$lessonInfo);
            // 学生信息
            $StudentService = new \app\service\StudentService;
            $studentInfo = $StudentService->getStudentInfo(['id'=>$billInfo['student_id']]);
        }        
        // 判断权限
        $isPower = $this->BillService->isPower($billInfo['camp_id'],$this->memberInfo['id']);
        // dump($isPower);die;
        $this->assign('studentInfo',$studentInfo);
        $this->assign('power',$isPower);
        $this->assign('billInfo',$billInfo);
        return view('Bill/billInfoOfCamp');
    }

    // 训练营修改会员订单
    public function updateBillInfoOfCamp(){
        $bill_id = input('param.bill_id');
        $billInfo = $this->BillService->getBill(['id'=>$bill_id]);
        $lessonInfo = [];
        // 判断权限
        $isPower = $this->BillService->isPower($billInfo['camp_id'],$this->memberInfo['id']);
        if($isPower<3){
            $this->error('您没有权限');
        }
        // 课程信息
        if($billInfo['goods_type'] == '课程'){
            $LessonService = new \app\service\LessonService;
            $lessonInfo = $LessonService->getLessonInfo(['id'=>$billInfo['goods_id']]);
           
            // 学生信息
            $StudentService = new \app\service\StudentService;
            $studentInfo = $StudentService->getStudentInfo(['id'=>$billInfo['student_id']]);
            $this->assign('studentInfo',$studentInfo);
        }        
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('power',$isPower);
        $this->assign('billInfo',$billInfo);
        return view('Bill/updateBillInfoOfCamp');
    }


    // 会员查看自己的订单信息
    public function billInfo(){
    	$bill_id = input('param.bill_id');
    	$billInfo = $this->BillService->getBill(['id'=>$bill_id]);
        $lessonInfo = [];
        if($billInfo['goods_type']=='课程'){
            $LessonService = new \app\service\LessonService;
            $lessonInfo = $LessonService->getLessonInfo(['id'=>$billInfo['goods_id']]);
            
            // 学生信息
            $StudentService = new \app\service\StudentService;
            $studentInfo = $StudentService->getStudentInfo(['id'=>$billInfo['student_id']]);
            $this->assign('studentInfo',$studentInfo);
        }

        $this->assign('lessonInfo',$lessonInfo);
    	$this->assign('billInfo',$billInfo);
    	return view('Bill/billInfo');
    }


    // 会员查看自己的订单信息
    public function billInfoTest(){
        $bill_order = input('param.bill_order');
        $billInfo = $this->BillService->getBill(['bill_order'=>$bill_order]);
        $lessonInfo = [];
        if($billInfo['goods_type']=='课程'){
            $LessonService = new \app\service\LessonService;
            $lessonInfo = $LessonService->getLessonInfo(['id'=>$billInfo['goods_id']]);
            
            // 学生信息
            $StudentService = new \app\service\StudentService;
            $studentInfo = $StudentService->getStudentInfo(['id'=>$billInfo['student_id']]);
            $this->assign('studentInfo',$studentInfo);
        }
        // 生成微信参数
        $amount = $billInfo['total']*$billInfo['price'];
        $WechatJsPayService = new \app\service\WechatJsPayService;
        $result = $WechatJsPayService->pay(['order_no'=>$bill_order.time(),'amount'=>$amount]);
        
        $jsApiParameters = $result['data']['jsApiParameters'];

        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('billInfo',$billInfo);
        return view('Bill/billInfo');
    }




    // 获取会员订单列表
    public function billList(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
    	$map = input('post.');
        $map['member_id'] = $member_id;
        $billList = $this->BillService->getBillList($map);
        $count = count($billList);
        // 已付款
        $payCount = 0;
        
        $notPayCount = 0;
        foreach ($billList as $key => $value) {
            if($value['is_pay'] == '已付款'){
                $payCount++;
            }
            if($value['is_pay'] == '未付款'){
                $notPayCount++;
            }
        }
        $this->assign('notPayCount',$notPayCount);
        $this->assign('payCount',$payCount);
        $this->assign('count',$count);
        $this->assign('billList',$billList);
		return view('Bill/billList');
    }

    //获取会员订单接口
    public function getBillListApi(){
    	$map = input('post.');
        $result = $this->BillService->getBillList($map);
        $billList['count'] = count($billList);
        return json(['code'=>100,'data'=>$billList,'msg'=>'OK']);    	
    }
    //编辑|添加订单
    public function createBill(){
    	// 训练营主教练
    	$map = input('post.');
    	$coachList = db('grade_member')->where(['type'=>0,'camp_id'=>$camp_id,'status'=>1])->select();
    	$assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
    	$this->assign('coachList',$coachList);
    	$this->assign('assitantList',$assitantList);
    	return view('Bill/createBill');
    }


    public function comfirmBill(){
        // 生成订单号
        $billOrder = '1'.date('YmdHis',time()).rand(0000,9999).$this->memberInfo['id'];
        // 生成微信参数
        // dump($billOrder);die;
        $this->assign('billOrder',$billOrder);
        return view('Bill/comfirmBill');
    }

    
    public function finishBill(){
        //查询是否成功支付
        $billOrder = input('param.bill_order');
        if(!$billOrder){
            $this->error('未查询到订单');
        }else{
            $billInfo = $this->BillService->getBill(['bill_order'=>$billOrder]);
        }     
        // 判断权限
        $isPower = $this->BillService->isPower($billInfo['camp_id'],$this->memberInfo['id']);
        if($isPower > 1){
            $title = "您有课程被购买,请及时跟进";
        }else{
            $title = "您的订单已支付成功";
        }
        $this->assign('title',$title);

        if($billInfo['goods_type'] == '课程'){
            // 课程信息
            $lessonInfo = db('lesson')->where(['id'=>$billInfo['goods_id']])->find();
            $this->assign('lessonInfo',$lessonInfo);
        }
        // dump($billInfo);die;
        $this->assign('billInfo',$billInfo);
        return view('Bill/finishBill');
    }

    public function finishBookBill(){
        //查询是否成功支付
        $billOrder = input('param.bill_order');
        if(!$billOrder){
            $this->error('未查询到订单');
        }else{
            $billInfo = $this->BillService->getBill(['bill_order'=>$billOrder]);
        }  

         // 判断权限
        $isPower = $this->BillService->isPower($billInfo['camp_id'],$this->memberInfo['id']);

        if($isPower > 1){
            $title = "您的体验课被预约申请,请及时跟进";
        }else{
            $title = "您的体验课预约成功,请等待回复";
        }
        $this->assign('title',$title);

        if($billInfo['goods_type'] == '课程'){
            // 课程信息
            $lessonInfo = db('lesson')->where(['id'=>$billInfo['goods_id']])->find();
            $this->assign('lessonInfo',$lessonInfo);
            // 学员姓名
            $studentInfo = db('grade_member')->where(['lesson_id'=>$lessonInfo['id'],'member_id'=>$this->memberInfo['id']])->find();
            $this->assign('studentInfo',$studentInfo);
        }

        $this->assign('billInfo',$billInfo);
        return view('Bill/finishBookBill');
    }
}