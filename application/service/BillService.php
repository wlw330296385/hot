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
        // $result = $this->Bill->with('lesson')->where($map)->find();
        $result = $this->Bill->where($map)->find();
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }


    // 获取订单列表
    public function getBillList($map,$p = 1){
        $result = $this->Bill->where($map)->page($p,10)->select();
        
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    public function billCount($map){
        $result = $this->Bill->where($map)->count();
        return $result?$result:0;
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


    /**
     * 返回权限
     */
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
                    // ->where(function ($query) {
                            // $query->where('type', 2)->whereor('type', 3)->whereor('type',4);})
                    ->value('type');
                    // echo db('camp_member')->getlastsql();die;
        return $is_power?$is_power:0;
    }
}