<?php

namespace app\admin\service;
use app\coommon\validate\BonusVal;
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


    // 获取所有礼包
    public function getBonusList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = $this->BonusModel->with('ItemCoupon')->where($map)->order($order)->page($page,$paginate)->select();
        // $result = Db::view('bonus','*')
        //         ->view('item_coupon','coupon,coupon_des,image_url,price,status as coupon_status,id as coupon_id','item_coupon.target_id = bonus.id')
        //         ->where(['item_coupon.target_type'=>-1])
        //         ->order('bonus.id desc')
        //         ->page($page,10)
        //         ->select();
        $result = $this->BonusModel->where($map)->order($order)->page($page,$paginate)->select();
        return $result;
    }

    // 分页获取礼包
    public function getBonusListByPage($map=[], $order='',$paginate=10){
        $result = $this->BonusModel->where($map)->order($order)->paginate($paginate);
        return $result;
    }


    public function getBonusListNoPage($map){
        $result = $this->BonusModel->where($map)->select();
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

    // 获取一个礼包
    public function getBonusInfo($map) {
        // $result = Db::view('bonus','*')
        //         ->view('item_coupon','coupon,coupon_des,image_url,price,status as coupon_status,id as coupon_id','item_coupon.target_id = bonus.id','LEFT')
        //         ->where($map)
        //         ->where(['item_coupon.target_type'=>-1,'item_coupon.status'=>1])
        //         ->order('bonus.id desc')
        //         ->find();
        $result = $this->BonusModel->where($map)->find();
        return $result;
    }

    // 获取一个礼包-用户
    public function getBonusMemberInfo($map) {
        $result = $this->BonusMemberModel->where($map)->find();
        if ($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 生成礼包
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


    // 编辑礼包
    public function updateBonus($data,$map){
        
        $validate = validate('BonusVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->BonusModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $map['id']];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 发放礼包
    public function createBonusMember($data){
        $result = $this->BonusMemberModel->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->BonusMemberModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 发放好几个礼包
    public function createBonusMemberAll(){

    }

    //编辑被发放的礼包
    public function updateBonusMember($data,$map){
        $result = $this->BonusMemberModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

}

