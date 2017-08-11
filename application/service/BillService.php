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

    public function pubBill($data){
        $result = $this->Bill->validate('BillVal')->save($data);
        if($result){
            return ['code'=>100,'msg'=>'新建成功','data'=>$result];
        }else{
            return ['code'=>200,'msg'=>$this->Bill->getError()];
        }
    }
    
    //判断订单付款金额
    public function isPay($id){
        $result = $this->Bill->where($map)->find();
        if($result){
            return $result['is_pay'];
        }else{
            return false;
        }
        
    }

    // 编辑订单
    public function updateBill($data,$id){
        $is_pay = $this->is_pay(['id'=>$id]);
        if($is_pay>0){
            $result = $this->Bill->validate('BillVal')->save($data,$id);
             if($result){
                return ['code'=>100,'msg'=>'修改成功','data'=>$result];
            }else{
                return ['code'=>200,'msg'=>$this->Bill->getError()];
            }            
        }else{
            $memberInfo = session('memberInfo','think');
            file_put_contents('/data/bill/'.date('Y-m-d',time()),json_encode(['data'=>$data,'memberInfo'=>$memberInfo]));
            return ['code'=>200,'msg'=>'非法操作'];
        }

    }
}