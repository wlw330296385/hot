<?php

namespace app\service;

use app\model\ItemCoupon;
use app\model\ItemCouponMember;
use think\Db;
class ItemCouponService {
    private $CouponModel;
    private $CouponMemberModel;
    public function __construct(){
        $this->ItemCouponModel = new ItemCoupon;
        $this->ItemCouponMemberModel = new ItemCouponMember;
    }


    public function getItemCouponListNoPage($map){
        $result = $this->ItemCouponModel->where($map)->select();
        return $result;
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
        return $result;
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

    // 获取一个卡券-用户
    public function getItemCouponMemberInfo($map) {
        $result = $this->ItemCouponMemberModel->where($map)->find();
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
    public function updateItemCoupon($data,$map){
        
        $validate = validate('ItemCouponVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->ItemCouponModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200];
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
        $itemCoupnMemberInfo = $this->ItemCouponMemberModel->where(['id'=>$item_coupon_member_id])->find();

        if($itemCoupnMemberInfo){
            if($itemCoupnMemberInfo['status']<>1){
                return ['code'=>100,'msg'=>'卡券已被使用'];
            }
        }else{
            return ['code'=>100,'msg'=>'卡券已被删除或不存在'];
        }

        if(strtotime($itemCouponInfo['end'])<time() || strtotime($itemCouponInfo['start'])>time()){
            return ['code'=>100,'msg'=>'卡券不在有效期内,无法使用'];
        }

        if(session('memberInfo.id','','think')<>$itemCoupnMemberInfo['member_id']){
            return ['code'=>100,'msg'=>'卡券不属于你,无法使用'];
        }

        $result = $this->ItemCouponMemberModel->save(['status'=>2],['id'=>$item_coupon_member_id]);
        if($result){
            $this->ItemCouponModel->where(['id'=>$item_coupon_id])->setInc('used',1);

            return ['msg' => '使用成功', 'code' => 200];
        }else{
            return ['msg'=>'使用失败', 'code' => 100];
        }
        
    }






    /**
    * 发放一张卡券
    * @param $member_id $member
    * @param $item_coupon_id 主表id
    **/ 
    public function createItemCouponMember($member_id,$member,$item_coupon_id){
        $itemCouponInfo = $this->ItemCouponModel->where(['id'=>$item_coupon_id])->find();
        if(($itemCouponInfo['max']-$itemCouponInfo['publish'])<1){
            return ['code'=>100,'msg'=>'卡券已经被领完'];
        }
        $data = [
            'member_id'         =>$member_id,
            'member'            =>$member,
            'item_coupon_id'    =>$itemCouponInfo['id'],
            'item_coupon'       =>$itemCouponInfo['coupon'],
            'status'            =>1,
            'coupon_number'     =>getTID($member_id),
        ];

        // $itemCouponMemberInfo = $this->ItemCouponMemberModel->where(['item_coupon_id'=>$item_coupon_id,'member_id'=>$member_id,'status'=>1])->find();
        // if($itemCouponMemberInfo){
        //     return ['code'=>100,'msg'=>'您已经领过该卡'];
        // }
        $result = $this->ItemCouponMemberModel->save($data);

        if($result){
            $this->ItemCouponModel->where(['id'=>$item_coupon_id])->setInc('publish',1);
            if(($itemCouponInfo['max']-$itemCouponInfo['publish']) == 1){
                $this->ItemCouponModel->where(['id'=>$item_coupon_id])->save(['is_max'=>2]);
            }
            return ['msg' => '领取成功', 'code' => 200];
        }else{
            return ['msg'=>'领取失败', 'code' => 100];
        }
    }

    /**
    * 向用户发放一堆卡券
    * @param $member_id $member
    * @param $item_coupon_id 主表id
    **/ 
    public function createItemCouponMemberList($member_id,$member,$item_coupon_ids){

        $itemCouponList = $this->ItemCouponModel->where(['id'=>['in',$item_coupon_ids]])->select();
        // echo $this->ItemCouponModel->getlastsql();
        $data = [];
        $ids = [];
        foreach ($itemCouponList as $key => $value) {
            if(($value['max']-$value['publish'])<1 || $value['status'] <> 1){
                continue;
            }
            $data[] = [
                'member_id'         =>$member_id,
                'member'            =>$member,
                'item_coupon_id'    =>$value['id'],
                'item_coupon'       =>$value['coupon'],
                'status'            =>1,
                'coupon_number'     =>getTID($member_id),
            ];
            $ids[] = $value['id'];      
        }
        $result = $this->ItemCouponMemberModel->saveAll($data);

        if($result){
            $this->ItemCouponModel->where(['id'=>['in',$ids]])->setInc('publish',1);
            // $this->ItemCouponModel->save(['is_max'=>1],['id'=>['in',$ids]]);
            return ['msg' => '领取成功', 'code' => 200];
        }else{
            return ['msg'=>'领取失败', 'code' => 100];
        }
    }

    /**
    * 获取我的卡券列表
    * @param $member_id $member
    * @param $item_coupon_id 主表id
    **/ 
    public function getItemCouponMemberListByPage($map = [],$paginate = 10){
        $result = $this->ItemCouponMemberModel->with('itemCoupon')->where($map)->paginate($paginate);

        return $result;
    }


    //重复发放多张卡券
    public function createItemCouponMemberAll($item_coupon_id,$total){
        $data = [];
        foreach ($arr as $key => $value) {
            $data[] = [
                'member_id'         =>$member_id,
                'member'            =>$member,
                'item_coupon_id'    =>$value['id'],
                'item_coupon'       =>$value['coupon'],
                'status'            =>1,
                'coupon_number'     =>getTID($member_id),
            ];
        }
    }

}

