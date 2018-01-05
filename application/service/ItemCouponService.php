<?php

namespace app\service;

use app\model\ItemCoupon;
use app\model\ItemCouponMember;
use think\Db;
use app\common\validate\ItemItemCouponVal;
class ItemCouponService {
    private $CouponModel;
    private $CouponMemberModel;
    public function __construct(){
        $this->ItemCouponModel = new ItemCoupon;
        $this->ItemCouponMemberModel = new ItemCouponMember;
    }


    // 获取所有卡券
    public function getItemCouponList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = $this->ItemCouponModel->where($map)->order($order)->page($page,$paginate)->select();

        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 分页获取卡券
    public function getItemCouponListByPage($map=[], $order='',$paginate=10){
        $result = $this->ItemCouponModel->where($map)->order($order)->paginate($paginate);
        if($result){
            $res =  $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 软删除
    public function SoftDeleteItemCoupon($id) {
        $result = $this->ItemCouponModel->destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个卡券
    public function getItemCouponInfo($map) {
        $result = $this->ItemCouponModel->where($map)->find();
        if ($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 生成卡券
    public function createItemCoupon($data){
        
        $validate = validate('ItemCouponVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->ItemCouponModel->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->ItemCouponModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    // 编辑卡券
    public function updateItemCoupon($data,$id){
        
        $validate = validate('ItemCouponVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->ItemCouponModel->save($data,['id'=>$id]);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    
    /**
    * 使用卡券
    * @param $item_coupon_member_id 关系表id
    * @param $item_coupon_id 主表id
    **/ 

    public function useItemCoupon($item_coupon_member_id,$item_coupon_id){
        $itemCouponInfo = $this->ItemCouponModel->where(['id'=>$item_coupon_id])->find();
        if($itemCouponInfo['end']>time() || $itemCouponInfo['start']<time()){
            return json(['code'=>100,'msg'=>'卡券不在有效期内,无法使用']);
        }
        $result = $this->ItemCouponMemberModel->save(['status'=>1],['id'=>$item_coupon_member_id]);
        if($result){
            $this->ItemCouponModel->where(['id'=>$item_coupon_id])->setInc('used',1);
            return ['msg' => '使用成功', 'code' => 200, 'data' => $item_coupon_member_id];
        }else{
            return ['msg'=>'使用失败', 'code' => 100];
        }
        
    }


    /**
    * 发放卡券
    * @param $member_id $member
    * @param $item_coupon_id 主表id
    **/ 
    public function createItemCouponMember($member_id,$member,$item_coupon_id){
        $itemCouponInfo = $this->ItemCouponModel->where(['id'=>$item_coupon_id])->find();
        if(($itemCouponInfo['max']-$itemCouponInfo['publish'])<1){
            return json(['code'=>100,'msg'=>'卡券已经被领完']);
        }
        $data = [
            'member_id'         =>$member_id,
            'member'            =>$member,
            'item_coupon_id'    =>$itemCouponInfo['id'],
            'item_coupon'       =>$itemCouponInfo['coupon'],
            'status'            =>1,
            'coupon_number'     =>getTID($member_id),
        ];
        $result = $this->ItemCouponMemberModel->save($data);
        if($result){
            $this->ItemCouponModel->where(['id'=>$item_coupon_id])->setInc('publish',1);
            return ['msg' => '生成成功', 'code' => 200, 'data' => $this->ItemCouponMemberModel->id];
        }else{
            return ['msg'=>'生成失败', 'code' => 100];
        }
    }


}

