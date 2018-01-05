<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\ItemCouponService;
class ItemCoupon extends Base{
   protected $ItemCouponService;
 
    public function _initialize(){
        parent::_initialize();
       $this->ItemCouponService = new ItemCouponService;
    }
 
    public function getItemCouponListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->ItemCouponService->getItemCouponList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    public function updateItemCouponApi(){
         try{
            $data = input('post.');
            $item_coupon_id = input('param.item_coupon_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->ItemCouponService->updateItemCoupon($data,$item_coupon_id);
             return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }

    //生成一张卡券
    public function createItemCouponApi(){
         try{
            $data = input('post.');
            // $data['member_id'] = $this->memberInfo['id'];
            // $data['member'] = $this->memberInfo['member'];
            $result = $this->ItemCouponService->createItemCoupon($data);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


 
    //发放一张卡券
    public function createItemCouponMemberApi(){
         try{
             $item_coupon_id = input('param.item_coupon_id');
             // $member_id = $this->memberInfo['id'];
             // $member = $this->memberInfo['member'];
             $member_id = 8;
             $member = 'woo';
            $result = $this->ItemCouponService->createItemCouponMember($member_id,$member,$item_coupon_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}