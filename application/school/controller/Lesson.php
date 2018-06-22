<?php 
namespace app\school\controller;
use app\school\controller\Base;
use app\service\LessonService;
use app\service\GradeService;
use app\service\WechatService;

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
        $lessonInfo['cover'] = request()->root(true) . $lessonInfo['cover'];
        $isPower = $this->LessonService->isPower($lessonInfo['camp_id'],$this->memberInfo['id']);
        //卡券列表
        $map = function($query)use($lessonInfo){
            // $query->where(['target_type'=>1,'target_id'=>0])
            // ->whereOr(['target_type'=>3])
            // ->whereOr(['target_type'=>1,'target_id'=>$lessonInfo]);
            // ;
            $query->where('target_type',['=',1],['=',3],'or')
                  ->where('target_id',['=',$lessonInfo['id']],['=',0],'or');
        };
        // 卡券系统        
        $ItemCoupon = new \app\model\ItemCoupon;
        // 平台卡券
        $couponListOfSystem = $ItemCoupon
                            ->where($map)
                            ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                            ->select();
        if($couponListOfSystem){
            $couponListOfSystem = $couponListOfSystem->toArray();
        }else{
            $couponListOfSystem = [];
        }
        // 训练营卡券
        $couponListOfCamp = $ItemCoupon->where(['organization_type'=>2,'organization_id'=>$lessonInfo['camp_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])->where($map)->select();

        if($couponListOfCamp){
            $couponListOfCamp = $couponListOfCamp->toArray();
        }else{
            $couponListOfCamp = [];
        }
        $this->assign('couponListOfSystem',$couponListOfSystem);
        $this->assign('couponListOfCamp',$couponListOfCamp);
        $this->assign('isPower',$isPower);
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
        $lessonList = $this->LessonService->getLessonList($map);
        // // 课程类型
        $GradeService = new \app\service\GradeService;
        $gradecateList = $GradeService->getGradeCategory();

        $this->assign('gradecateList',$gradecateList);  
        $this->assign('lessonList',$lessonList);
        return view('Lesson/lessonList');
    }

    // 课程列表（机构版）
    public function lessonListOfOrganization(){
        $camp_id = input('param.camp_id');
        $map = [];
        if($camp_id){
            $map['camp_id'] = $camp_id;
        }
        $lessonList = $this->LessonService->getLessonList($map);
        // // 课程类型
        $GradeService = new \app\service\GradeService;
        $gradecateList = $GradeService->getGradeCategory();

        $this->assign('gradecateList',$gradecateList);  
        $this->assign('lessonList',$lessonList);
        return view('Lesson/lessonListOfOrganization');
    }

    // 课程订单购买页面
    public function comfirmBill(){
        $lesson_id = input('param.lesson_id');
        $total = input('param.total');
        if(!$lesson_id){
            $this->error('缺少课程id');
        }
        
        if(!$total){
            $this->error('缺少购买总数');
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
            'pay_type'=>'wxpay',
        ];
        $amount = $total*$lessonInfo['cost'];
        // $amount = 0.01;
        $WechatJsPayService = new \app\service\WechatJsPayService;
        $result = $WechatJsPayService->pay(['order_no'=>$billOrder,'amount'=>$amount]);
        
        $jsApiParameters = $result['data']['jsApiParameters'];
        $shareurl = request()->url(true);
        $wechatS = new WechatService();
        $jsapi = $wechatS->jsapi($shareurl);
        
        //卡券列表
        $map = function($query) use($lessonInfo){
            $query->where('target_type',['=',1],['=',3],'or')
                  ->where('target_id',['=',$lessonInfo['id']],['=',0],'or');
        };
        // 平台卡券
        $ItemCoupon = new \app\model\ItemCoupon;
        $item_coupon_ids1 = $ItemCoupon
                        ->where($map)
                        ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->column('id');
        // 训练营卡券
        $item_coupon_ids2 = $ItemCoupon
                        ->where(['organization_type'=>2,'organization_id'=>$lessonInfo['camp_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->where($map)
                        ->column('id');
        $item_coupon_ids = array_merge($item_coupon_ids1,$item_coupon_ids2);

         // 平台卡券
        $couponListOfSystem = $ItemCoupon
                            ->where($map)
                            ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                            ->select();
        // echo $ItemCoupon->getlastsql();die;
        if($couponListOfSystem){
            $couponListOfSystem = $couponListOfSystem->toArray();
        }else{
            $couponListOfSystem = [];
        }
        // dump($couponListOfSystem);die;
        // 训练营卡券
        $couponListOfCamp = $ItemCoupon->where(['organization_type'=>2,'organization_id'=>$lessonInfo['camp_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])->where($map)->select();
        if($couponListOfCamp){
            $couponListOfCamp = $couponListOfCamp->toArray();
        }else{
            $couponListOfCamp = [];
        }
        $this->assign('couponListOfSystem',$couponListOfSystem);
        $this->assign('couponListOfCamp',$couponListOfCamp);
        $this->assign('item_coupon_ids',json_encode($item_coupon_ids));
        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('jsapi', $jsapi);
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
        $billOrder = '1'.date('YmdHis',time()).rand(0000,9999);
        $jsonLessonInfo = [
            'camp'  => $lessonInfo['camp'],
            'camp_id'=>$lessonInfo['camp_id'],
            'lesson'=>$lessonInfo['lesson'],
            'lesson_id' =>$lessonInfo['id'],
            'location' =>$lessonInfo['location'],
        ];
        $this->assign('jsonLessonInfo',json_encode($jsonLessonInfo));
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
        // 私密课程 获取指定会员列表
        $assignMemberList = [];
        if ($lessonInfo['isprivate']) {
            $assignMemberList = $this->LessonService->getAssignMember($lessonInfo['id']);
        }

        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('power',$power);
        $this->assign('assignMemberList', $assignMemberList);
        return view('Lesson/lessonInfoOfCamp');
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

   //编辑课程
    public function updateLesson(){
    	//训练营主教练
    	$camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        // 获取会员在训练营角色
        if($is_power<2){
            $this->error('您没有权限');
        }
        // 兼职教练不能操作
        if ($is_power == 2) {
            $level = getCampMemberLevel($camp_id,$this->memberInfo['id']);
            if ($level == 1) {
                $this->error('您没有权限');
            }
        }
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        // 教练列表
    	$staffList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        // 课程分类
        $GradeCategoryService = new \app\service\GradeCategoryService;
        $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();
        
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        // 私密课程 获取指定会员列表
        $assignMemberList = [];
        $assignMemberCount = 0;
        if ($lessonInfo['isprivate']) {
            $assignMemberList = $this->LessonService->getAssignMember($lessonInfo['id']);
            $assignMemberCount = count($assignMemberList);
        }

        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('camp_id',$camp_id);
    	$this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
    	$this->assign('staffList',$staffList);
    	$this->assign('assignMemberList', $assignMemberList);
    	$this->assign('assignMemberCount', $assignMemberCount);
    	return view('Lesson/updateLesson');
    }

    // 添加课程|发布课程
    public function createLesson(){
        //训练营主教练
        $camp_id = input('param.camp_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        // 获取会员在训练营角色
        if($is_power<2){
            $this->error('您没有权限');
        }
        // 兼职教练不能操作
        if ($is_power == 2) {
            $level = getCampMemberLevel($camp_id,$this->memberInfo['id']);
            if ($level == 1) {
                $this->error('您没有权限');
            }
        }

        // 教练列表
        $staffList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        // 课程分类
        $GradeCategoryService = new \app\service\GradeCategoryService;
        $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        $this->assign('campInfo',$campInfo);
        $this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
        $this->assign('staffList',$staffList);
        return view('Lesson/createLesson');
    }


    // 课程转换
    public function changeLesson(){
    	//训练营
        $camp_id = input('param.camp_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        if($is_power<2){
            $this->error('您没有权限');
        }
        // 兼职教练不能操作
        if ($is_power == 2) {
            $level = getCampMemberLevel($camp_id,$this->memberInfo['id']);
            if ($level == 1) {
                $this->error('您没有权限');
            }
        }

        // 课程列表
        $lessonList = db('lesson')->where(['camp_id'=>$camp_id,'status'=>1,'is_school'=>-1])->where('delete_time','null')->select();

        $this->assign('lessonList',$lessonList);
        $this->assign('camp_id',$camp_id);
        $this->assign('campInfo',$campInfo);
        return view('Lesson/changeLesson');
    }

    //转课列表
    public function changeLessonList(){
        //训练营
        $camp_id = input('param.camp_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        if($is_power<2){
            $this->error('您没有权限');
        }

        $this->assign('camp_id',$camp_id);
        $this->assign('campInfo',$campInfo);
        return view('Lesson/changeLessonList');
    }

    // 转课详情
    public function changeLessonInfo(){
        $transfer_lesson_id = input('param.transfer_lesson_id');
        //训练营
        $camp_id = input('param.camp_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        if($is_power<2){
            $this->error('您没有权限');
        }

        $TransferLesson = new \app\model\TransferLesson;
        $changeLessonInfo = $TransferLesson->where(['id'=>$transfer_lesson_id])->find();
        

        $this->assign('changeLessonInfo',$changeLessonInfo);
        $this->assign('camp_id',$camp_id);
        $this->assign('campInfo',$campInfo);
        return view('Lesson/changeLessonInfo');
    }



    // 添加校园课程
    public function createLessonOfSchool(){
        //训练营主教练
        $camp_id = input('param.camp_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        // 获取会员在训练营角色
        if($is_power<2){
            $this->error('您没有权限');
        }
        // 兼职教练不能操作
        if ($is_power == 2) {
            $level = getCampMemberLevel($camp_id,$this->memberInfo['id']);
            if ($level == 1) {
                $this->error('您没有权限');
            }
        }

        // 教练列表
        $staffList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        // 课程分类
        $GradeCategoryService = new \app\service\GradeCategoryService;
        $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        $this->assign('campInfo',$campInfo);
        $this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
        $this->assign('staffList',$staffList);
        return view('Lesson/createLessonOfSchool');
    }

   //编辑校园课程
    public function updateLessonOfSchool(){
    	//训练营主教练
        $camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $is_power = $this->LessonService->isPower($camp_id,$this->memberInfo['id']);
        // 获取会员在训练营角色
        if($is_power<2){
            $this->error('您没有权限');
        }
        // 兼职教练不能操作
        if ($is_power == 2) {
            $level = getCampMemberLevel($camp_id,$this->memberInfo['id']);
            if ($level == 1) {
                $this->error('您没有权限');
            }
        }
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        // 教练列表
        $staffList = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->select();
        // 课程分类
        $GradeCategoryService = new \app\service\GradeCategoryService;
        $gradeCategoryList = $GradeCategoryService->getGradeCategoryList();
        
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        // 私密课程 获取指定会员列表
        $assignMemberList = [];
        $assignMemberCount = 0;
        if ($lessonInfo['isprivate']) {
            $assignMemberList = $this->LessonService->getAssignMember($lessonInfo['id']);
            $assignMemberCount = count($assignMemberList);
        }

        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('camp_id',$camp_id);
        $this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
        $this->assign('staffList',$staffList);
        $this->assign('assignMemberList', $assignMemberList);
        $this->assign('assignMemberCount', $assignMemberCount);
        return view('Lesson/updateLessonOfSchool');
    }

    public function lessonInfoOfSchool(){
        $lesson_id = input('param.lesson_id');
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        $lessonInfo['cover'] = request()->root(true) . $lessonInfo['cover'];

        $this->assign('lessonInfo',$lessonInfo);
        return view('Lesson/lessonInfoOfSchool');
    }



    // 购买体验课
    public function comfirmBillOfSchool(){
        $lesson_id = input('param.lesson_id');
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
                    'pay_type'=>'wxpay',
                ];
        $jsonLessonInfo = [
            'camp'  => $lessonInfo['camp'],
            'camp_id'=>$lessonInfo['camp_id'],
            'lesson'=>$lessonInfo['lesson'],
            'lesson_id' =>$lessonInfo['id'],
            'location' =>$lessonInfo['location'],
        ];
         $this->assign('jsonBillInfo',json_encode($jsonBillInfo));
        $this->assign('jsonLessonInfo',json_encode($jsonLessonInfo));
        $this->assign('lessonInfo',$lessonInfo);
        $this->assign('billOrder',$billOrder);
        return view('Lesson/comfirmBillOfSchool');
    }

}