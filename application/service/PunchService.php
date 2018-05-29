<?php
// 证件 service
namespace app\service;

use app\model\Punch;
use think\Db;
class PunchService {
    protected $Punch;
    public function __construct(){
        $this->Punch = new Punch;
    }

    public function getPunchInfo($map) {
        $result = $this->Punch->where($map)->find();
        return $result;
    }

    public function getPunchList($map,$page = 1,$p= 10){
    	$result = $this->Punch->where($map)->page($page,$p)->select();
    	return $result;
    }


    public function getPunchListByPage($map,$paginate = 10){
        $result = $this->Punch->where($map)->paginate($paginate);
        return $result;
    }

    // 新增打卡
    public function createPunch($data){
        $stakes = ceil($data['stakes']);
        if($stakes < $this->memberInfo['hot_coin']){
            return json(['code'=>100,'msg'=>'热币不足']);
        }
        $res = db('member')->where(['id'=>$data['member_id']])->dec('hot_coin',$stakes)->update();
        if(!$res){
            return ['code'=>100,'msg'=>'热币扣除失败,请重试'];
        }

        $result = $this->Punch->save($data);
        if($result){
            db('hotcoin_finance')->insert(
                [
                    'member_id' =>$data['member_id'],
                    'member'    =>$data['member'],
                    'member'    =>$data['member'],
                    'hot_coin'  =>-$stakes,
                    'type'      =>-1,
                    'status'    =>1,
                    'f_id'      =>$this->Punch->id,
                    'create_time'=>time();
                ]
            );
            return ['code'=>200,'msg'=>'创建成功','data'=>$this->Punch->id];
        }else{
            return ['code'=>100,'msg'=>'创建失败'];
        }

    }



    public function getGroupPunchListByPage($map,$paginate = 10){
        $GroupPunch = new \app\model\GroupPunch;
        $result = $GroupPunch->with('punch')->where($map)->paginate($paginate);
        return $result;
    }
}