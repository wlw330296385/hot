<?php
// 证件 service
namespace app\service;

use app\model\Punch;

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


    public function getPunchListByPage($map,$paginate = 1,$p= 10){
        $result = $this->Punch->where($map)->paginate($paginate);
        return $result;
    }

    // 新增打卡
    public function createPunch($data){
        $result = $this->Punch->save($data);
        if($result){
            return ['code'=>200,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }

    }

    // 产生打卡-社群关系
    public function saveGroupPunch($data) {
        
    }
}