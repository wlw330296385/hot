<?php
namespace app\service;
use app\model\Bill;
use app\common\validate\BillVal;
use think\Db;
class BillService {

    public $Bill;
    public function __construct()
    {
        $this->Bill = new Bill;
    }

    // 关联lesson获取订单详情
    public function getBill($map){
        $result = $this->Bill->with('lesson')->where($map)->find();
        return $result;
    }


    // 获取订单列表
    public function getBillList($map,$p = 10){
        $result = $this->Bill->where($map)->paginate($p);
        return $result->toArray();
    }


    
}