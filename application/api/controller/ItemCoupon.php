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
    
     public function getItemCouponListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->ItemCouponService->getItemCouponListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
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
            $data['start'] = strtotime($data['starts']);
            $data['end'] = strtotime($data['ends']);
            $data['publish_start'] = strtotime($data['publish_starts']);
            $data['publish_end'] = strtotime($data['publish_ends']);
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
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['start'] = strtotime($data['starts']);
            $data['end'] = strtotime($data['ends']);
            $data['publish_start'] = strtotime($data['publish_starts']);
            $data['publish_end'] = strtotime($data['publish_ends']);
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
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            // $member_id = 8;
            // $member = 'woo';
            $result = $this->ItemCouponService->createItemCouponMember($member_id,$member,$item_coupon_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //发放一堆卡券
    public function createItemCouponMemberListApi(){
         try{
            $item_coupon_id = input('param.item_coupon_ids');
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            // dump($item_coupon_id);
            $item_coupon_ids = json_decode($item_coupon_id,'true');
            // dump($item_coupon_ids);
            $result = $this->ItemCouponService->createItemCouponMemberList($member_id,$member,$item_coupon_ids);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //使用卡券
    public function useItemCoupon(){
        try{
            $item_coupon_member_id = input('param.item_coupon_member_id');
            $item_coupon_id = input('param.item_coupon_id');
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            // $member_id = 8;
            // $member = 'woo';
            $result = $this->ItemCouponService->useItemCoupon($item_coupon_member_id,$item_coupon_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}