<?php 
namespace app\admin\controller;
use app\admin\controller\base\Camp;
use app\service\ItemCouponService;
class Coupon extends Camp{
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
        $itemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$itemCoupon_id]);
        $itemCouponMemberInfo = $this->ItemCouponService->getItemCouponMemberInfo(['item_coupon_id'=>$itemCoupon_id,'member_id'=>$this->memberInfo['id']]);
        // dump($itemCouponMemberInfo);die;
        $this->assign('itemCouponMemberInfo',$itemCouponMemberInfo);
        $this->assign('itemCouponInfo',$itemCouponInfo);
    	return view('Coupon/itemCouponInfo');
    }

    public function itemCouponList(){
        

        $map = ['organization_type'=>2,'organization_id'=>$this->campInfo['id']];

        $keyword = input('param.keyword');
        if($keyword){
            
            $map = ['coupon'=>['like',"%$keyword%"]];
            
        }
        $itemCouponList = $this->ItemCouponService->getItemCouponListByPage($map);


        // dump($itemCouponList->toArray());die;
        $this->assign('itemCouponList',$itemCouponList);
        return view('Coupon/itemCouponList');
    }

    public function updateItemCoupon(){   	
    	$itemCoupon_id = input('param.itemCoupon_id');
        $itemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$itemCoupon_id]);
        if($itemCouponInfo['organization_id']<>$this->campInfo['id']){
            $this->error('非法操作');
        }

        if(request()->isPost()){
            $data = input('post.');
            $datetime = explode('-', $data['datetime']);
            $data['start'] = strtotime($datetime[0]);
            $data['end'] = strtotime($datetime[1]);
            $publishtime = explode('-', $data['publishtime']);
            $data['publish_start'] = strtotime($publishtime[0]);
            $data['publish_end'] = strtotime($publishtime[1]);
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['organization_type'] = 2;
            $data['organization'] = $this->campInfo['camp'];
            $data['organization_id'] = $this->campInfo['id'];
            $result = $this->ItemCouponService->updateItemCoupon($data,['id'=>$itemCoupon_id]);
            if($result['code'] == 200){
                $this->success($result['msg']);
            }else{
                $this->success($result['msg']);
            }
        }

		$this->assign('itemCouponInfo',$itemCouponInfo);
    	return view('Coupon/updateItemCoupon');
    }

    public function createItemCoupon(){

        if(request()->isPost()){
            $data = input('post.');
            $datetime = explode('-', $data['datetime']);
            $data['start'] = strtotime($datetime[0]);
            $data['end'] = strtotime($datetime[1]);
            $publishtime = explode('-', $data['publishtime']);
            $data['publish_start'] = strtotime($publishtime[0]);
            $data['publish_end'] = strtotime($publishtime[1]);
            $data['member_id'] = $this->memberInfo['id'];
            $data['organization_type'] = 2;
            $data['organization'] = $this->campInfo['camp'];
            $data['organization_id'] = $this->campInfo['id'];
            $result = $this->ItemCouponService->createItemCoupon($data);
            if($result['code'] == 200){
                $this->success($result['msg']);
            }else{
                $this->success($result['msg']);
            }
        }
        return view('Coupon/createItemCoupon');
    }
    // 分页获取数据
    public function itemCouponListApi(){
        $map = input('post.');
    	$itemCouponList = $this->ItemCouponService->getItemCouponPage($map,10);
    	return json($result);
    }

    public function searchItemCouponList(){
        $camp_id = input('param.camp_id');
        $this->assign('camp_id',$camp_id);
        return view('Coupon/searchItemCouponList');
    }
}