<?php
// 证件 service
namespace app\service;

use app\model\Refund;

class RefundService {
    protected $Refund;
    public function __construct(){
        $this->Refund = new Refund;
    }

    public static function getRefundInfo($map) {
        $result = $this->Refund->where($map)->find();
        return $result;
    }

    public function getRefundList($map,$page = 1,$p= 10){
    	$result = $this->Refund->where($map)->page($page,$p)->select();
    	return $result;
    }


    public function getRefundListByPage($map,$paginate = 10,$p= 10){
        $result = $this->Refund->with('bill')->where($map)->paginate($paginate);
        return $result;
    }

    // 新增退款
    public function createRefund($data){
        $result = $this->Refund->save($data);
        if($result){
            return ['code'=>200,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }

    }

    // 操作退款
    public function updateRefund($data,$id){
        $result = $this->Refund->save($data,['id'=>$id]);
        if($result){
            return ['code'=>200,'msg'=>'修改成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'修改失败','data'=>$result];
        }
    }

 
    public function saveRefund($request) {
        
    }
}