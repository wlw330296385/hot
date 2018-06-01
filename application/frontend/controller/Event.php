<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\EventService;
class Event extends Base{
	private $EventService;
	public function _initialize(){
		parent::_initialize();
        $this->EventService = new EventService;
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        $this->assign('eventInfo',$eventInfo);
	}

    public function index() {
  
        return view('Event/index');
    }


    public function bookBill(){
        $event_id = input('param.event_id');

        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]); 
        // ---------------------------------------------------卡券系统
        //卡券列表
        $map = function($query) use($eventInfo){
            $query->where('target_type',['=',2],['=',3],'or')
                  ->where('target_id',['=',$eventInfo['id']],['=',0],'or');
        };
        // 平台卡券
        $ItemCoupon = new \app\model\ItemCoupon;
        $item_coupon_ids1 = $ItemCoupon
                        ->where($map)
                        ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->column('id');
        // 训练营卡券
        $item_coupon_ids2 = $ItemCoupon
                        ->where(['organization_type'=>2,'organization_id'=>$eventInfo['organization_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->where($map)
                        ->column('id');
        $item_coupon_ids = array_merge($item_coupon_ids1,$item_coupon_ids2);
         //卡券列表
        $map = function($query) use($eventInfo){
            $query->where('target_type',['=',2],['=',3],'or')
                  ->where('target_id',['=',$eventInfo['id']],['=',0],'or');
        };
        // 平台卡券
        $ItemCoupon = new \app\model\ItemCoupon;
        $couponListOfSystem = $ItemCoupon
                        ->where($map)
                        ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->select();
        // 训练营卡券
        $couponListOfCamp = $ItemCoupon
                        ->where(['organization_type'=>2,'organization_id'=>$eventInfo['organization_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->where($map)
                        ->select();
        if($couponListOfCamp){
            $couponListOfCamp = $couponListOfCamp->toArray();
        }else{
            $couponListOfCamp = [];
        }
        if($couponListOfSystem){
            $couponListOfSystem = $couponListOfSystem->toArray();
        }else{
            $couponListOfSystem = [];
        }
        // ---------------------------------------------------卡券系统
    
        $this->assign('couponListOfSystem',$couponListOfSystem);
        $this->assign('couponListOfCamp',$couponListOfCamp);
        $this->assign('item_coupon_ids',json_encode($item_coupon_ids));
        $this->assign('eventInfo',$eventInfo);
        return view('Event/bookBill');
    }


    public function comfirmBill() {
        $event_id = input('param.event_id');
        $total = input('param.total');
        $domIndex = input('param.domIndex',0);
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);     
        $billOrder = '2'.getOrderID(rand(0,9));
        $jsonBillInfo = [
            'goods'=>$eventInfo['event'].'-'.$eventInfo['doms'][$domIndex]['name'],
            'goods_id'=>$eventInfo['id'],
            'camp_id'=>$eventInfo['organization_id'],
            'camp'=>$eventInfo['organization'],
            'organization_type'=>1,
            'price'=>$eventInfo['doms'][$domIndex]['price'],
            'score_pay'=>$eventInfo['score'],
            'goods_type'=>2,
            'pay_type'=>'wxpay',
        ];
        $amount = $total*$eventInfo['doms'][$domIndex]['price'];
        // $amount = 0.01;
        $WechatJsPayService = new \app\service\WechatJsPayService;
        $result = $WechatJsPayService->pay(['order_no'=>$billOrder,'amount'=>$amount]);
        
        $jsApiParameters = $result['data']['jsApiParameters'];
        $shareurl = request()->url(true);
        $wechatS = new \app\service\WechatService;
        $jsapi = $wechatS->jsapi($shareurl);
        $eventInfo['price'] = $eventInfo['doms'][$domIndex]['price'];
        // ---------------------------------------------------卡券系统

         //卡券列表
        $map = function($query) use($eventInfo){
            $query->where('target_type',['=',2],['=',3],'or')
                  ->where('target_id',['=',$eventInfo['id']],['=',0],'or');
        };
        // 平台卡券
        $ItemCoupon = new \app\model\ItemCoupon;
        $couponListOfSystem = $ItemCoupon
                        ->where($map)
                        ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->select();
        // 训练营卡券
        $couponListOfCamp = $ItemCoupon
                        ->where(['organization_type'=>2,'organization_id'=>$eventInfo['organization_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->where($map)
                        ->select();
  
        if($couponListOfCamp){
            $couponListOfCamp = $couponListOfCamp->toArray();
        }else{
            $couponListOfCamp = [];
        }
        if($couponListOfSystem){
            $couponListOfSystem = $couponListOfSystem->toArray();
        }else{
            $couponListOfSystem = [];
        }
        //卡券列表
        $map = function($query) use($eventInfo){
            $query->where('target_type',['=',2],['=',3],'or')
                  ->where('target_id',['=',$eventInfo['id']],['=',0],'or');
        };
        // 平台卡券
        $ItemCoupon = new \app\model\ItemCoupon;
        $item_coupon_ids1 = $ItemCoupon
                        ->where($map)
                        ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->column('id');
        // 训练营卡券
        $item_coupon_ids2 = $ItemCoupon
                        ->where(['organization_type'=>2,'organization_id'=>$eventInfo['organization_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->where($map)
                        ->column('id');
        $item_coupon_ids = array_merge($item_coupon_ids1,$item_coupon_ids2);
        // ---------------------------------------------------卡券系统
        $this->assign('item_coupon_ids',json_encode($item_coupon_ids));
        $this->assign('couponListOfSystem',$couponListOfSystem);
        $this->assign('couponListOfCamp',$couponListOfCamp);
        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('jsapi', $jsapi);
        $this->assign('jsonBillInfo',json_encode($jsonBillInfo));
        $this->assign('eventInfo',$eventInfo);
        $this->assign('billOrder',$billOrder);
        return view('Event/comfirmBill');
    }




    // 创建活动
    public function createEvent() {
        $organization_id = input('param.organization_id');
        $CampService = new \app\service\CampService;
        $campInfo = $CampService->getCampInfo(['id'=>$organization_id]);
        // 获取会员在训练营角色
        $isPower = $CampService->isPower($organization_id,$this->memberInfo['id']);
        // 兼职教练不能操作
        if ($isPower == 2) {
            $level = getCampMemberLevel($organization_id,$this->memberInfo['id']);
            if ($level == 1) {
                $this->error('您没有权限');
            }
        }
        // 我是班主任的班级
        $GradeModel = new \app\model\Grade;
        $gradeList = $GradeModel->where(['teacher_id'=>$this->memberInfo['id']])->select();


        $this->assign('gradeList',$gradeList);
        $this->assign('power',$isPower);
        $this->assign('campInfo',$campInfo);
        $this->assign('organization_id', $organization_id);
        return view('Event/createEvent');
    }

    public function eventInfo() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
   
        $variable = 1;
        if($eventInfo['status']=='下架'){
            $variable = 2 ;
        }
        if($eventInfo['is_max'] == '已满人'){
            $variable = 3 ;
        }

        if($eventInfo['end'] <= time()){
            $variable = 4 ;
        }
        //是否已报名
        $EventMember = new \app\model\EventMember;
        $result =  $EventMember->where(['member_id'=>$this->memberInfo['id'],'event_id'=>$event_id,'status'=>1])->select();
        if($result){
            $EventMemberList = $result->toArray();
        }else{
            $EventMemberList = [];
        }
        // ---------------------------------------------------卡券系统
        //卡券列表
        $map = function($query) use($eventInfo){
            $query->where('target_type',['=',2],['=',3],'or')
                  ->where('target_id',['=',$eventInfo['id']],['=',0],'or');
        };
        // 平台卡券
        $ItemCoupon = new \app\model\ItemCoupon;
        $couponListOfSystem = $ItemCoupon
                        ->where($map)
                        ->where(['organization_type'=>1,'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->select();
        // 训练营卡券
        $couponListOfCamp = $ItemCoupon
                        ->where(['organization_type'=>2,'organization_id'=>$eventInfo['organization_id'],'status'=>1,'is_max'=>1,'publish_start'=>['lt',time()],'publish_end'=>['gt',time()]])
                        ->where($map)
                        ->select();
        if($couponListOfCamp){
            $couponListOfCamp = $couponListOfCamp->toArray();
        }else{
            $couponListOfCamp = [];
        }
        if($couponListOfSystem){
            $couponListOfSystem = $couponListOfSystem->toArray();
        }else{
            $couponListOfSystem = [];
        }
        // ---------------------------------------------------卡券系统
  
        $this->assign('couponListOfSystem',$couponListOfSystem);
        $this->assign('couponListOfCamp',$couponListOfCamp);
        $this->assign('EventMemberList',$EventMemberList);
        $this->assign('variable',$variable);
        $this->assign('eventInfo',$eventInfo);
        return view('Event/eventInfo');
    }




    public function eventInfoOfCamp() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);

        $power = $this->EventService->isPower($eventInfo['organization_type'],$eventInfo['organization_id'],$this->memberInfo['id']);

        $this->assign('power',$power);
        $this->assign('eventInfo',$eventInfo);
        return view('Event/eventInfoOfCamp');
    }

    public function eventList() {
        $target_type = input('param.target_type/d', 1);
        $this->assign('target_type', $target_type);
        return view('Event/eventList');
    }

    // 活动列表（机构版）
    public function eventListOfOrganization() {
        $target_type = input('param.target_type/d', 1);
        $this->assign('target_type', $target_type);
        return view('Event/eventListOfOrganization');
    }

    public function eventListOfCamp() {
        $organization_id = input('param.organization_id');



        $this->assign('organization_id', $organization_id);
        return view('Event/eventListOfCamp');
    }
    // 活动编辑
    public function updateEvent() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        if($eventInfo['member_id'] != $this->memberInfo['id']){
            $isPower = $this->EventService->isPower($eventInfo['organization_type'],$eventInfo['organization_id'],$this->memberInfo['id']);
            if($isPower<3){
                $this->error('您没有权限');
            }
            // 兼职教练不能操作
            if ($isPower == 2) {
                $level = getCampMemberLevel($eventInfo['organization_id'],$this->memberInfo['id']);
                if ($level == 1) {
                    $this->error('您没有权限');
                }
            }
        }


        $this->assign('eventInfo',$eventInfo);
        return view('Event/updateEvent');
    }
    // 活动编辑
    public function updateEventTEST() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        if($eventInfo['member_id'] != $this->memberInfo['id']){
            $isPower = $this->EventService->isPower($eventInfo['organization_type'],$eventInfo['organization_id'],$this->memberInfo['id']);
            if($isPower<3){
                $this->error('您没有权限');
            }
        }


        $this->assign('eventInfo',$eventInfo);
        return view('Event/updateEventTEST');
    }
    
    // 活动录入
    public function recordEvent() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        if($eventInfo['member_id'] != $this->memberInfo['id']){
            $isPower = $this->EventService->isPower($eventInfo['organization_type'],$eventInfo['organization_id'],$this->memberInfo['id']);
            if($isPower<3){
                $this->error('您没有权限');
            }
        }


        $this->assign('eventInfo',$eventInfo);
        return view('Event/recordEvent');
    }

    // 营内公开活动列表
    public function eventOfOpen(){
        $organization_id = input('param.organization_id');
        $this->assign('organization_id', $organization_id);
        return view('Event/eventOfOpen');
    }

    // 营内活动列表
    public function eventOfCamp(){
        $organization_id = input('param.organization_id');
        $this->assign('organization_id', $organization_id);
        return view('Event/eventOfCamp');
    }

    // 班内活动列表
    public function eventOfGrade(){
        $organization_id = input('param.organization_id');
        $this->assign('organization_id', $organization_id);
        return view('Event/eventOfGrade');
    }

    // 已报名人员列表
    public function eventOfSignUpList(){
        return view('Event/eventOfSignUpList');
    }


    // 用户的活动
    public function eventListOfMember() {
        return view('Event/eventListOfMember');
    }



    // 活动报名表
    public function applicationForm() {
        return view('Event/applicationForm');
    }
}