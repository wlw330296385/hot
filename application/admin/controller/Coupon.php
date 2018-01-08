<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\ItemCouponService;
class Coupon extends Backend{
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
        

        $field = '请选择搜索关键词';
        $map = [];

        $field = input('param.field');
        $keyword = input('param.keyword');
        if($keyword==''){
            $map = [];
            $field = '请选择搜索关键词';
        }else{
            if($field){
                $map = [$field=>['like',"%$keyword%"]];
            }else{
                $field = '请选择搜索关键词';
                $map = function($query) use ($keyword){
                    $query->where(['coupon'=>['like',"%$keyword%"]])
                    // ->whereOr(['telephone'=>['like',"%$keyword%"]])
                    // ->whereOr(['nickname'=>['like',"%$keyword%"]])
                    // ->whereOr(['hot_id'=>['like',"%$keyword%"]])
                    ;
                };
            }
        }
            
        $itemCouponList = $this->ItemCouponService->getItemCouponListByPage($map);
        $this->assign('field',$field);

        // dump($itemCouponList->toArray());die;
        $this->assign('itemCouponList',$itemCouponList);
        return view('Coupon/itemCouponList');
    }

    public function updateItemCoupon(){   	
    	$itemCoupon_id = input('param.itemCoupon_id');
        $ItemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$itemCoupon_id]);
        $CampService = new \app\service\CampService;
        $power = $CampService->isPower($ItemCouponInfo['camp_id'],$this->memberInfo['id']);
        if($power<2){
            $this->error('请先加入一个训练营并成为管理员或者创建训练营');
        }
		$this->assign('ItemCouponInfo',$ItemCouponInfo);
    	return view('Coupon/updateItemCoupon');
    }

    public function createItemCoupon(){

        if(request()->isPost()){
            $data = input('post.');
            $datetime = explode('-', $data['datetime']);
            $data['start'] = strtotime($datetime[0]);
            $data['end'] = strtotime($datetime[1]);
            $data['member_id'] = $this->admin['id'];
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
}