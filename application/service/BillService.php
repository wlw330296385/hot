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

    public function createBill($data){
        $validate = validate('BillVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->Bill->save($data);
        if($result){
            if($data['goods_type'] == 1){
                $is_student = db('camp_member')->where(['type'=>1,'member_id'=>$data['member_id'],'camp_id'=>$data['camp_id'],'status'=>1])->find();
                if(!$is_student){
                    $res = db('camp_member')->where()->save(['camp_id'=>$data['camp_id'],'camp'=>$data['camp'],'member_id'=>$data['member_id'],'member'=>$data['member'],'type'=>1,'status'=>1]);
                    if(!$res){
                        db('log_camp_member')->save(['member_id'=>$data['member_id','member'=>$data['member'],'data'=>$data]);
                    }
                }
                $is_student2 = db('grade_member')->where(['camp_id'=>$data['camp_id'],'lesson_id'=>$data['goods_id'],'status'=>1])->find();
                if(!$is_student2){
                    $re = db('camp_member')->where()->save(['camp_id'=>$data['camp_id'],'camp'=>$data['camp'],'member_id'=>$data['member_id'],'member'=>$data['member'],'type'=>1,'status'=>1,'student_id'=>$data['student_id'],'student'=>$data['student'],'lesson_id'=>$data['goods_id'],'lesson'=>$data['goods']]);
                    if(!$re){
                        db('log_grade_member')->save(['member_id'=>$data['member_id','member'=>$data['member'],'data'=>$data]);
                    }
                }
            }
            
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
        $memberInfo = session('memberInfo','','think');
        $is_pay = $this->is_pay(['id'=>$id]);
        $validate = validate('BillVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        if($is_pay>0){
            $result = $this->Bill->save($data,['id'=>$id]);
             if($result){
                return ['code'=>100,'msg'=>'修改成功','data'=>$result];
            }else{
                return ['code'=>200,'msg'=>$this->Bill->getError()];
            }            
        }else{
            
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



    // 订单支付
    public function billPay($bill_order,$callback_str){
        
        $data = ['is_pay'=>1,'pay_time'=>time(),'callback_str'=>$callback_str];
        dump($data);
        $result = $this->Bill->where(['bill_order'=>$bill_order])->update($data);
        // echo $this->Bill->getlastsql();die;
        if($result){
            $billInfo = $this->getBill(['bill_order'=>$bill_order]);
            if($billInfo){
                $balance_pay = $billInfo['balance_pay'];
                // 返现返积分
                $res = $this->hpReturn($billInfo['member_id'],$balance_pay);
                return ['code'=>100,'msg'=>'支付成功'];
            }else{
                file_put_contents(ROOT_PATH.'data/bill/'.date('Y-m-d',time()),json_encode(['info'=>'找不到订单信息','data'=>$data,'memberInfo'=>$billInfo['member_id']]));
                return ['code'=>200,'msg'=>'找不到订单信息'];
            }
        }else{
            file_put_contents(ROOT_PATH.'data/bill/'.date('Y-m-d',time()),json_encode(['info'=>'支付失败,请联系客服','data'=>$data,]));
            return ['code'=>200,'msg'=>'支付失败,请联系客服'];
        }
    }

    // 递归返回hp业绩
    public function hpReturn($member_id,$score = 0, $times = 0,$level = 2){
        $times++;
        $res = db('member')->where(['id'=>$member_id])->inc('score',$score)->inc('hp',$score)->update();
            if($res){
                if($times<= $level){
                    $pid = db('member')->where(['id'=>$member_id])->value('pid');
                    if($pid!=0){
                        $this->hpReturn($pid,$score,$times);
                    }else{
                        return 1;
                    }
                }else{
                    return 2;
                }
            }else{
                file_put_contents(ROOT_PATH.'data/bill/'.date('Y-m-d',time()),json_encode(['info'=>'返现积分失败','data'=>$data,'memberInfo'=>$billInfo['member_id']]));
                return false;
            }
    }

    // 订单退款
}