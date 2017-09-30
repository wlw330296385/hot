<?php
namespace app\service;
use app\model\Bill;
use app\common\validate\BillVal;
use think\Db;
use app\model\GradeMember;
use app\model\CampMember;
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
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        // grade_member操作
        $GradeMember = new GradeMember;
        $is_student2 = $GradeMember->where(['camp_id'=>$data['camp_id'],'lesson_id'=>$data['goods_id'],'student_id'=>$data['student_id'],'status'=>1])->find();
        if(!$is_student2){
            $re = $GradeMember->save(['camp_id'=>$data['camp_id'],'camp'=>$data['camp'],'member_id'=>$data['member_id'],'member'=>$data['member'],'type'=>1,'status'=>1,'student_id'=>$data['student_id'],'student'=>$data['student'],'lesson_id'=>$data['goods_id'],'lesson'=>$data['goods'],'rest_schedule'=>$data['total'],'type'=>$data['type']]);
            if(!$re){
                db('log_grade_member')->insert(['member_id'=>$data['member_id'],'member'=>$data['member'],'data'=>json_encode($data)]);
            }
        }else{
            $re = $GradeMember->where(['camp_id'=>$data['camp_id'],'lesson_id'=>$data['goods_id'],'student_id'=>$data['student_id'],'status'=>1])->setInc('rest_schedule',$data['total']);
            if(!$re){
                db('log_grade_member')->insert(['member_id'=>$data['member_id'],'member'=>$data['member'],'data'=>json_encode($data)]);
            }
        }
        $result = $this->Bill->save($data);
        if($result){
            if($data['goods_type'] == 1){
                //购买人数+1;
                db('lesson')->where(['id'=>$data['goods_id']])->setInc('students');
                $CampMember = new CampMember;
                $is_student = $CampMember->where(['type'=>1,'member_id'=>$data['member_id'],'camp_id'=>$data['camp_id'],'status'=>1])->find();
                if(!$is_student){
                    $res = $CampMember->save(['camp_id'=>$data['camp_id'],'camp'=>$data['camp'],'member_id'=>$data['member_id'],'member'=>$data['member'],'type'=>1,'status'=>1]);
                    if(!$res){
                        db('log_camp_member')->insert(['member_id'=>$data['member_id'],'member'=>$data['member'],'data'=>json_encode($data)]);
                    }
                }

            }
            // 训练营的余额增加
            $setting = db('setting')->find();
            $campBlance = ($data['balance_pay']*(1-$setting['sysrebate']));
            $ress = db('camp')->where(['id'=>$data['camp_id']])->setInc('balance',$campBlance);
            if($ress){
                db('income')->insert(['lesson_id'=>$data['goods_id'],'lesson'=>$data['goods'],'camp_id'=>$data['camp_id'],'camp'=>$data['camp_id'],'income'=>$data['balance_pay']*(1-$setting['sysrebate']),'member_id'=>$data['member_id'],'member'=>$data['member'],'create_time'=>time()]);
            }
            return ['code'=>200,'msg'=>'新建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>$this->Bill->getError()];
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

    // 用户编辑订单
    public function updateBill($data,$id){
        $memberInfo = session('memberInfo','','think');
        $is_pay = $this->is_pay(['id'=>$id]);
        $validate = validate('BillVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        if($is_pay == 0){
            $result = $this->Bill->save($data,['id'=>$id]);
             if($result){
                return ['code'=>200,'msg'=>'修改成功','data'=>$result];
            }else{
                return ['code'=>100,'msg'=>$this->Bill->getError()];
            }            
        }else{
            // file_put_contents('/data/bill/'.date('Y-m-d',time()),json_encode(['data'=>$data,'memberInfo'=>$memberInfo]));
            return ['code'=>100,'msg'=>'非法操作'];
        }

    }


    /**
     * 返回权限
     */
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
                    ->value('type');
                    // echo db('camp_member')->getlastsql();die;
        return $is_power?$is_power:0;
    }



    // 订单支付
    public function billPay($bill_order,$callback_str){
        
        $data = ['is_pay'=>1,'pay_time'=>time(),'callback_str'=>$callback_str];
        // dump($data);
        $result = $this->Bill->where(['bill_order'=>$bill_order])->update($data);
        if($result){
            $billInfo = $this->getBill(['bill_order'=>$bill_order]);
            if($billInfo){
                $balance_pay = $billInfo['balance_pay'];
                // 返现返积分
                return ['code'=>200,'msg'=>'支付成功'];
            }else{
                return ['code'=>100,'msg'=>'找不到订单信息'];
            }
            
        }else{
            return ['code'=>100,'msg'=>'支付失败,请联系客服'];
        }
    }

}