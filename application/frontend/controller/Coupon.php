<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ItemCouponService;
class Coupon extends Base{
	protected $ItemCouponService;
	public function _initialize(){
		parent::_initialize();
		$this->ItemCouponService = new ItemCouponService;
	}

    public function index() {

        return view('Coupon/index');
    }


    public function itemCouponInfo(){
    	$itemCoupon_id = input('param.item_coupon_id');
    	$itemCouponMember_id = input('param.itemCouponMember_id');
        $itemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$itemCoupon_id]);
        $itemCouponMemberInfo = $this->ItemCouponService->getItemCouponMemberInfo(['id'=>$itemCouponMember_id]);

        $this->assign('itemCouponMemberInfo',$itemCouponMemberInfo);
        $this->assign('itemCouponInfo',$itemCouponInfo);
    	return view('Coupon/itemCouponInfo');
    }

    public function itemCouponList(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $itemCouponList = $this->ItemCouponService->getItemCouponMemberListByPage(['member_id'=>$member_id]);
        // dump($itemCouponList->toArray());die;
        $this->assign('itemCouponList',$itemCouponList);
        return view('Coupon/itemCouponList');
    }

    public function itemCouponListOfEvent(){
        $organization_id = input('param.organization_id');
        $coupon_id = input('param.coupon_id');
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $itemCouponList = $this->ItemCouponService->getItemCouponMemberListByPage(['member_id'=>$member_id]);
        $CampService = new \app\service\CampService;
        $organizationInfo = $CampService->getCampInfo(['id'=>$organization_id]);
        $this->assign('organizationInfo',$organizationInfo);
        $this->assign('coupon_id',$coupon_id);
        $this->assign('itemCouponList',$itemCouponList);
        return view('Coupon/itemCouponListOfEvent');
    }

    public function couponListOfCamp(){

        $organization_id = input('param.organization_id');


        $this->assign('organization_id',$organization_id);
        return view('Coupon/couponListOfCamp');
    }


    public function couponListOfMember(){
        
        
        return view('Coupon/couponListOfMember');
    }

    public function updateItemCoupon(){   	
    	$itemCoupon_id = input('param.item_coupon_id');
        $lessontList = [];
        $eventList = [];
        $itemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$itemCoupon_id]);
        if($itemCouponInfo['organization_type'] == 2){
            $CampService = new \app\service\CampService;
            $power = $CampService->isPower($itemCouponInfo['organization_id'],$this->memberInfo['id']);
            if($power<2){
                $this->error('请先加入一个训练营并成为管理员或者创建训练营');
            }
            $eventList = db('event')->where(['organization_id'=>$itemCouponInfo['organization_id'],'organization_type'=>$itemCouponInfo['organization_type']])->where('delete_time',null)->select();
            $lessontList = db('lesson')->where(['camp_id'=>$itemCouponInfo['organization_id'],'is_school'=>-1])->where('delete_time',null)->select();
        }
//        dump($itemCouponInfo);die;
        $this->assign('itemCouponInfo',$itemCouponInfo);
        $this->assign('eventList',$eventList);
        $this->assign('lessontList',$lessontList);
    	return view('Coupon/updateItemCoupon');
    }

    public function createItemCoupon(){
        $organization_id = input('param.organization_id');
        $organization_type = input('param.organization_type',1);
        $eventList = [];
        $lessontList = [];
        if($organization_type == 1){
            $CampService = new \app\service\CampService;
            $power = $CampService->isPower($organization_id,$this->memberInfo['id']);

            if($power<2){
                $this->error('请先加入一个训练营并成为管理员或者创建训练营');
            }

            $eventList = db('event')->where(['organization_id'=>$organization_id,'organization_type'=>$organization_type])->where('delete_time',null)->select();
            $lessontList = db('lesson')->where(['camp_id'=>$organization_id,'is_school'=>-1])->where('delete_time',null)->select();



            $organizationInfo = $CampService->getCampInfo(['id'=>$organization_id]);

        }


        $this->assign('eventList',$eventList);
        $this->assign('lessontList',$lessontList);
        $this->assign('organization_id',$organization_id);
        $this->assign('organizationInfo',$organizationInfo);
        return view('Coupon/createItemCoupon');
    }
    // 分页获取数据
    public function itemCouponListApi(){
    	$camp_id = input('param.camp_id');
        $condition = input('post.');
        $where = ['status'=>['or',[1,$camp_id]]];
        $map = array_merge($condition,$where);
    	$itemCouponList = $this->ItemCouponService->getItemCouponPage($map,10);
    	return json($result);
    }

    public function searchItemCouponList(){
        $camp_id = input('param.camp_id');
        $this->assign('camp_id',$camp_id);
        return view('Coupon/searchItemCouponList');
    }

    // 新加领取卡券名单列表
    public function couponOfSignUpList(){
        $item_coupon_id = input('param.item_coupon_id');
        $itemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$item_coupon_id]);
        $this->assign('itemCouponInfo',$itemCouponInfo);
        $this->assign('item_coupon_id',$item_coupon_id);
        
        return view('Coupon/couponOfSignUpList');
    }


    public function useCoupon(){

        $organization_id = input('param.organization_id');
        $organization_type = input('param.organization_type',1);

        if($organization_type == 1){
            $CampService = new \app\service\CampService;
            $power = $CampService->isPower($organization_id,$this->memberInfo['id']);

            if($power<1){
                $this->error('请先加入一个训练营并成为兼职、管理员或者创建训练营');
            }

            $eventList = db('event')->where(['organization_id'=>$organization_id,'organization_type'=>$organization_type])->where('delete_time',null)->select();
            $lessontList = db('lesson')->where(['camp_id'=>$organization_id,'is_school'=>-1])->where('delete_time',null)->select();



            $organizationInfo = $CampService->getCampInfo(['id'=>$organization_id]);

        }

        $this->assign('organization_id',$organization_id);
        $this->assign('organizationInfo',$organizationInfo);

        $this->assign('organization_id',$organization_id);
        return view('Coupon/useCoupon');
    }


    public function itemCouponGift(){
    	$itemCoupon_id = input('param.item_coupon_id');
    	$itemCouponMember_id = input('param.itemCouponMember_id');
        $itemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$itemCoupon_id]);
        $itemCouponMemberInfo = $this->ItemCouponService->getItemCouponMemberInfo(['id'=>$itemCouponMember_id]);

        $this->assign('itemCouponMemberInfo',$itemCouponMemberInfo);
        $this->assign('itemCouponInfo',$itemCouponInfo);
    	return view('Coupon/itemCouponGift');
    }
}