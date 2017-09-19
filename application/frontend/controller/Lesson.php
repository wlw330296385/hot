<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\LessonService;
use app\service\GradeService;

class Lesson extends Base{
	protected $LessonService;
	protected $GradeService;
	public function _initialize(){
		$this->LessonService = new LessonService;
		$this->GradeService = new GradeService;
		parent::_initialize();
	}
    public function test(){
        $is_power = $this->LessonService->isPower(9,1);
    }
    // 可购买
    public function index() {
    	$lesson_id = input('param.lesson_id');
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
     
        $lessonInfo['doms'] =  unserialize($lessonInfo['dom']);
        unset($lessonInfo['dom']);
        $this->assign('lessonInfoJson',json_encode($lessonInfo));
        $this->assign('lessonInfo',$lessonInfo);
        return view('Lesson/index');

    }

    // 可编辑
    public function lessonInfo(){
    	$lesson_id = input('param.lesson_id');
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        $this->assign('lessonInfoJson',json_encode($lessonInfo));
        $this->assign('lessonInfo',$lessonInfo);
        return view('Lesson/lessonInfo');
    }

    //
    public function lessonList(){
        $camp_id = input('param.camp_id');
        $map = [];
        if($camp_id){
            $map['camp_id'] = $camp_id;
        }
        $lessonList = $this->LessonService->getLessonPage($map);
        // 课程类型
        $GradeService = new \app\service\GradeService;
        $gradecateList = $GradeService->getGradeCategory();

        $this->assign('gradecateList',$gradecateList);
        $this->assign('lessonList',$lessonList);
        return view('Lesson/lessonList');
    }

    //编辑课程
    public function updateLesson(){
    	//训练营主教练
    	$camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        if($is_power<2){
            $this->error('您没有权限');
        }
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        
        // 教练列表
    	$staffList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();

    	$gradeCategoryList = $this->GradeService->getGradeCategory(1);
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['status'=>$camp_id]);
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('camp_id',$camp_id);
    	$this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
    	$this->assign('staffList',$staffList);
    	return view('Lesson/updateLesson');
    }

    // 添加课程|发布课程
    public function createLesson(){
        //训练营主教练
        $camp_id = input('param.camp_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        // 教练列表
        $staffList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        $gradeCategoryList = $this->GradeService->getGradeCategory(1);
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['status'=>$camp_id]);
        // dump($assitantList);die;
        $this->assign('campInfo',$campInfo);
        $this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
        $this->assign('staffList',$staffList);
        return view('Lesson/createLesson');
    }



    // 购买课程
    // public function buyLesson(){
    //     $studentInfo = db('student')->where(['member_id'=>$this->memberInfo['id']])->select();        
    //     $this->assign('studentInfo',$studentInfo); 
    // 	return view('Lesson/buyLesson');
    // }

    // 课程订单购买页面
    // public function comfirmBill(){
    //     $lesson_id = input('param.lesson_id');
    //     $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);

    //     // 生成订单号
    //     $billOrder = '1'.date('YmdHis',time()).rand(0000,9999);
    //     $jsonBillInfo = [
    //         'goods'=>$lessonInfo['lesson'],
    //         'goods_id'=>$lessonInfo['id'],
    //         'camp_id'=>$lessonInfo['camp_id'],
    //         'camp'=>$lessonInfo['camp'],
    //         'price'=>$lessonInfo['cost'],
    //         'score_pay'=>$lessonInfo['score'],
    //         'goods_type'=>1,
    //         'pay_type'=>'wxpay'
    //     ];
    //     $this->assign('jsonBillInfo',json_encode($jsonBillInfo));
    //     $this->assign('lessonInfo',$lessonInfo);
    //     $this->assign('billOrder',$billOrder);
    //     return view('Lesson/comfirmBill');
    // }

    // 课程订单购买页面
    public function comfirmBill(){
        $lesson_id = input('param.lesson_id');
        $total = input('param.total');
        if(!$lesson_id){
            $this->error('参数错误');
        }
        
        if(!$total){
            $this->error('参数错误');
        }
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        // 生成订单号
        $billOrder = '1'.date('YmdHis',time()).rand(0000,9999);
        $jsonBillInfo = [
            'goods'=>$lessonInfo['lesson'],
            'goods_id'=>$lessonInfo['id'],
            'camp_id'=>$lessonInfo['camp_id'],
            'camp'=>$lessonInfo['camp'],
            'price'=>$lessonInfo['cost'],
            'score_pay'=>$lessonInfo['score'],
            'goods_type'=>1,
            'pay_type'=>'wxpay'
        ];
        $amount = $total*$lessonInfo['cost'];
        $WechatJsPayService = new \app\service\WechatJsPayService;
        $result = $WechatJsPayService->pay(['order_no'=>$billOrder,'amount'=>$amount]);
        
        $jsApiParameters = $result['data']['jsApiParameters'];

        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('jsonBillInfo',json_encode($jsonBillInfo));
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('billOrder',$billOrder);
        return view('Lesson/comfirmBill');
    }

    // 购买体验课
    public function bookBill(){
        $lesson_id = input('param.lesson_id');
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        // 生成订单号
        $billOrder = '1'.date('YmrHis',time()).rand(0000,9999);
        // 生成微信参数
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('billOrder',$billOrder);
        return view('Lesson/bookBill');
    }
    // 邀请体验课程
    public function inviteStudent(){
        
        return view('Lesson/inviteStudent');
    }

     // 可编辑课程
    public function LessonInfoOfCamp(){
        $lesson_id = input('param.lesson_id');
        $member_id = $this->memberInfo['id'];
        $camp_id = input('param.camp_id');
        $power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        if($power<2){
            $this->error('您没有权限');
        }
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('power',$power);
        return view('Lesson/LessonInfoOfCamp');
    }


    public function lessonListOfCamp(){
        $camp_id = input('param.camp_id');
        
        // 上架课程
        $onlineLessonList = $this->LessonService->getLessonList(['camp_id'=>$camp_id,'status'=>1]);
        // 下架课程
        $offlineLessonList = $this->LessonService->getLessonList(['camp_id'=>$camp_id,'status'=>-1]);
        // 训练营信息
        // $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $this->assign('onlineLessonList',$onlineLessonList);
        $this->assign('offlineLessonList',$offlineLessonList);
        $this->assign('camp_id',$camp_id);
        return view('Lesson/lessonListOfCamp');
    }



}