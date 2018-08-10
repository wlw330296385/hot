<?php
namespace app\service;
use app\model\Charge;
use think\Db;
class ChargeService {
    private $ChargeModel;
    public function __construct(){
        $this->ChargeModel = new Charge;
    }
    // 充值记录列表
    public function getChargeList($map=[],$page = 1,$paginate = 10, $order='', $field='*'){
        $result = $this->ChargeModel->where($map)->field($field)->order($order)->page($page,$paginate)->select();
        
        return $result;
    }

    // 充值记录分页
    public function getChargeListbyPage($map=[], $order='', $field='*', $paginate=10){
        $result = $this->ChargeModel->where($map)->field($field)->order($order)->paginate($paginate);
        
        return $result;
    }

    // 充值记录详情
    public function getChargeInfo($map=[]) {
        $result = $this->ChargeModel->get($map);
        return $result;
        
        
    }
}