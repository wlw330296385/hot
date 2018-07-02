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
 
    // 获取卡券列表
    public function getItemCouponListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->ItemCouponService->getItemCouponList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
     // 获取卡券列表 无page
    public function getItemCouponListNoPageApi(){
         try{
            $map = input('post.');
            $result = $this->ItemCouponService->getItemCouponListNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
    // 获取卡券列表带page
     public function getItemCouponListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->ItemCouponService->getItemCouponListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取用户卡券带page
    public function getItemCouponMemberListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->ItemCouponService->getItemCouponMemberListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 获取用户卡券带page
    public function getItemCouponMemberListNoPageApi(){
        try{
            $map = input('post.');
            $result = $this->ItemCouponService->getItemCouponMemberLisNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
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
           if(isset($data['starts'])){
               $data['start'] = strtotime($data['starts']);
           }
           if(isset($data['ends'])){
               $data['end'] = strtotime($data['ends'])+86399;
           }
           if(isset($data['publish_starts'])){
                   $data['publish_start'] = strtotime($data['publish_starts']);
           }
           if(isset($data['publish_ends'])){
               $data['publish_end'] = strtotime($data['publish_ends'])+86399;
           }
            $result = $this->ItemCouponService->updateItemCoupon($data,['id'=>$item_coupon_id]);
            return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }



    public function editItemCouponApi(){
        try{
           $data = input('post.');
           $item_coupon_id = input('param.item_coupon_id');
           $data['member_id'] = $this->memberInfo['id'];
           $data['member'] = $this->memberInfo['member'];
           $result = db('item_coupon')->where(['id'=>$item_coupon_id])->update($data);
           if($result){
                return json(['code'=>200,'msg'=>'ok']);
            }
            return json(['code'=>100,'msg'=>'失败']);
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
            if( $data['starts'] || isset($data['starts'])){
                $data['start'] = strtotime($data['starts']);
            }
            if(isset($data['ends'])){
                $data['end'] = strtotime($data['ends'])+86399;
            }
            if(isset($data['publish_starts'])){
                    $data['publish_start'] = strtotime($data['publish_starts']);
            }
            if(isset($data['publish_ends'])){
                $data['publish_end'] = strtotime($data['publish_ends'])+86399;
            }


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

    //不同卡券每种发放一张
    public function createItemCouponMemberListApi(){
         try{
            $item_coupon_id = input('param.item_coupon_ids');
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            $item_coupon_ids = json_decode($item_coupon_id,'true');
            $result = $this->ItemCouponService->createItemCouponMemberList($member_id,$member,$this->memberInfo['telephone'],$this->memberInfo['avatar'],$item_coupon_ids);
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
            $result = $this->ItemCouponService->useItemCoupon($item_coupon_member_id,$item_coupon_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    //通过输入编码使用卡券
    public function useItemCouponWithCodeApi(){
        try{
            $item_coupon_id = input('param.item_coupon_id');
            $ic_code = input('param.ic_code');
            if (!$ic_code) {
                return json(['code'=>100,'msg'=>'请输入卡券码']);
            }
            $itemCouponInfo = $this->ItemCouponService->getItemCouponInfo(['id'=>$item_coupon_id]);
            if(!$itemCouponInfo){
                return json(['code'=>100,'msg'=>'查找不到该卡券']);
            }
            if($itemCouponInfo['organization_type'] == 2){
                $is_power = db('camp_member')->where(['camp_id'=>$itemCouponInfo['organization_id'],'status'=>1,'member_id'=>$this->memberInfo['id']])->find();
                if(!$is_power){
                    return json(['code'=>100,'msg'=>'权限不足']);
                }
                $result = db('item_coupon_member')->where(['coupon_number'=>$ic_code,'status'=>1])->update(['status'=>2,'update_time'=>time(),'use_member'=>$this->memberInfo['member'],'use_member_id'=>$this->memberInfo['id']]);
                if(!$result){
                    return json(['code'=>100,'msg'=>'卡券码不正确或者卡券已被使用']);
                }
            }else{
                return json(['code'=>100,'msg'=>'非训练营平台卡券不允许输入卡券码使用']);
            }
            return json(['code'=>200,'msg'=>'使用成功']);
         }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    //同一种卡券发放多张
    public function createItemCouponMemberAllApi(){
        try{
            $item_coupon_id = input('param.item_coupon_id');
            $total = input('param.total');
            $result = $this->ItemCouponService->createItemCouponMemberAll($item_coupon_id,$total);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //赠送卡券API
    public function presentItemCouponApi(){
        try{
            $item_coupon_id = input('param.item_coupon_id');
            $ItemCouponMemberInfo = $this->ItemCouponService->getItemCouponMemberInfo(['id'=>$item_coupon_id]);
            if(!$ItemCouponMemberInfo){
                return json(['code'=>100,'msg'=>'查找不到该卡券']);
            }
            if($itemCouponInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'不允许赠送他人卡券']);
            }



            if($result){
                return json(['code'=>200,'msg'=>'操作成功']);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            } 
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }  
    }

    // 领取他人卡券API
    public function receiveItemCouponApi(){
        try{
            $item_coupon_id = input('param.item_coupon_id');
            $ItemCouponMemberInfo = $this->ItemCouponService->getItemCouponMemberInfo(['id'=>$item_coupon_id]);
            if(!$ItemCouponMemberInfo){
                return json(['code'=>100,'msg'=>'查找不到该卡券']);
            }
            if($ItemCouponMemberInfo['member_id']==$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'不允许领取自己的卡券']);
            }
            if($ItemCouponMemberInfo['status'] != "未使用"){
                return json(['code'=>100,'msg'=>'该卡券已被使用']);
            }
            // 新的卡券数据
            $data['item_coupon_id'] = $ItemCouponMemberInfo['item_coupon_id'];
            $data['item_coupon'] = $ItemCouponMemberInfo['item_coupon'];
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];
            $data['telephone'] = $this->memberInfo['telephone'];
            $data['coupon_number'] = getTID($this->memberInfo['id']);
            $data['create_time'] = $data['update_time'] = time();
            $res = db('item_coupon_member')->insert($data);
            if($res){
                $result = db('item_coupon_member')->where(['id'=>$item_coupon_id])->update(['status'=>3,'to_member'=>$this->memberInfo['member'],'to_member_id'=>$this->memberInfo['id']]);
            }
            if($result){
                return json(['code'=>200,'msg'=>'操作成功']);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }  
    }

}