<?php

namespace app\admin\service;

use app\admin\model\Bonus;
use app\admin\model\BonusMember;
use think\Db;
class BonusService {
    private $BonusModel;
    private $BonusMemberModel;
    public function __construct(){
        $this->BonusModel = new Bonus;
        $this->BonusMemberModel = new BonusMember;
    }


    // 获取所有卡券
    public function getBonusList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = $this->BonusModel->where($map)->order($order)->page($page,$paginate)->select();

        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 分页获取卡券
    public function getBonusListByPage($map=[], $order='',$paginate=10){
        $result = $this->BonusModel->where($map)->order($order)->paginate($paginate);
        return $result;
    }

    // 软删除
    public function SoftDeleteBonus($id) {
        $result = $this->BonusModel->destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个卡券
    public function getBonusInfo($map) {
        $result = $this->BonusModel->where($map)->find();
        if ($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 获取一个卡券-用户
    public function getBonusMemberInfo($map) {
        $result = $this->BonusMemberModel->where($map)->find();
        if ($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 生成卡券
    public function createBonus($data){
        
        $validate = validate('BonusVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->BonusModel->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->BonusModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    // 编辑卡券
    public function updateBonus($data,$id){
        
        $validate = validate('BonusVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->BonusModel->save($data,['id'=>$id]);
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

    public function useBonus($item_coupon_member_id,$item_coupon_id){
        $itemBonusInfo = $this->BonusModel->where(['id'=>$item_coupon_id])->find();
        $itemCoupnMemberInfo = $this->BonusMemberModel->where(['id'=>$item_coupon_member_id])->find();

        if($itemCoupnMemberInfo){
            if($itemCoupnMemberInfo['status']<>1){
                return ['code'=>100,'msg'=>'卡券已被使用'];
            }
        }else{
            return ['code'=>100,'msg'=>'卡券已被删除或不存在'];
        }

        if(strtotime($itemBonusInfo['end'])<time() || strtotime($itemBonusInfo['start'])>time()){
            return ['code'=>100,'msg'=>'卡券不在有效期内,无法使用'];
        }

        if(session('memberInfo.id','','think')<>$itemCoupnMemberInfo['member_id']){
            return ['code'=>100,'msg'=>'卡券不属于你,无法使用'];
        }

        $result = $this->BonusMemberModel->save(['status'=>2],['id'=>$item_coupon_member_id]);
        if($result){
            $this->BonusModel->where(['id'=>$item_coupon_id])->setInc('used',1);

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
    public function createBonusMember($member_id,$member,$item_coupon_id){
        $itemBonusInfo = $this->BonusModel->where(['id'=>$item_coupon_id])->find();
        if(($itemBonusInfo['max']-$itemBonusInfo['publish'])<1){
            return ['code'=>100,'msg'=>'卡券已经被领完'];
        }
        $data = [
            'member_id'         =>$member_id,
            'member'            =>$member,
            'item_coupon_id'    =>$itemBonusInfo['id'],
            'item_coupon'       =>$itemBonusInfo['coupon'],
            'status'            =>1,
            'coupon_number'     =>getTID($member_id),
        ];

        $itemBonusMemberInfo = $this->BonusMemberModel->where(['item_coupon_id'=>$item_coupon_id,'member_id'=>$member_id,'status'=>1])->find();
        if($itemBonusMemberInfo){
            return ['code'=>100,'msg'=>'您已经领过该卡'];
        }
        $result = $this->BonusMemberModel->save($data);

        if($result){
            $this->BonusModel->where(['id'=>$item_coupon_id])->setInc('publish',1);
            if(($itemBonusInfo['max']-$itemBonusInfo['publish']) == 1){
                $this->BonusModel->where(['id'=>$item_coupon_id])->save(['is_max'=>2]);
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
    public function createBonusMemberList($member_id,$member,$item_coupon_ids){

        $itemBonusList = $this->BonusModel->where(['id'=>['in',$item_coupon_ids]])->select();
        // echo $this->BonusModel->getlastsql();
        $data = [];
        $ids = [];
        foreach ($itemBonusList as $key => $value) {
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
        $result = $this->BonusMemberModel->saveAll($data);

        if($result){
            $this->BonusModel->where(['id'=>['in',$ids]])->setInc('publish',1);
            // $this->BonusModel->save(['is_max'=>1],['id'=>['in',$ids]]);
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
    public function getBonusMemberListByPage($map = [],$paginate = 10){
        $result = $this->BonusMemberModel->with('itemBonus')->where($map)->paginate($paginate);
        // echo $this->BonusMemberModel->getlastsql();
        return $result;
    }


}

