<?php
namespace app\service;
use app\model\Bill;
use app\common\validate\BillVal;
use think\Db;
use app\model\LessonMember;
use app\model\CampMember;
class BillService {

    public $Bill;
    public function __construct()
    {
        $this->Bill = new Bill;
    }

    // 关联lesson获取订单详情
    public function getBill($map){
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

    // 获取订单列表
    public function getBillListByPage($map,$paginate = 10){
        $result = $this->Bill->where($map)->paginate($paginate);
        // dump($result);die;
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

    //生成一笔订单
    public function createBill($data){
        $validate = validate('BillVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $data['expire'] = time()+86400;
        $result = $this->Bill->save($data);
        if($result){
            return ['code'=>200,'msg'=>'新建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>$this->Bill->getError()];
        }
    }
    
    // 订单支付
    public function pay($data,$map){
        $data['pay_time'] = time();
        $data['expire'] = 0;
        $result = $this->Bill->save($data,$map);      
        if($result){
            $billInfo = $this->Bill->where($map)->find();
            $billData = $billInfo->toArray();
            $res = $this->finishBill($billData);
            return $res;
        }else{
            return false;
        }
    }




    /**
    * 订单支付完成操作
    * @param $data 一条订单记录
    **/
    private function finishBill($data){
        $MessageService = new \app\service\MessageService;
        //开始课程操作,包括(模板消息发送,camp\camp_mamber和lesson的数据更新)
        if($data['goods_type'] == '课程'){
            //购买人数+1;
            db('lesson')->where(['id'=>$data['goods_id']])->setInc('students');
            // 训练营的余额增加
            $setting = db('setting')->find();
            $campBlance = ($data['balance_pay']*(1-$setting['sysrebate']));
            $ress = db('camp')->where(['id'=>$data['camp_id']])->inc('balance',$campBlance)->inc('total_member',1)->update();
            if($ress){
                db('income')->insert(['lesson_id'=>$data['goods_id'],'lesson'=>$data['goods'],'camp_id'=>$data['camp_id'],'camp'=>$data['camp_id'],'income'=>$data['balance_pay']*(1-$setting['sysrebate']),'member_id'=>$data['member_id'],'member'=>$data['member'],'create_time'=>time()]);
            }
            // 发送个人消息           
            $MessageData = [
                "touser" => session('memberInfo.openid'),
                "template_id" => config('wxTemplateID.successBill'),
                "url" => url('frontend/bill/billInfo',['bill_order'=>$data['bill_order']],'',true),
                "topcolor"=>"#FF0000",
                "data" => [
                    'first' => ['value' => '订单支付成功通知'],
                    'keyword1' => ['value' => $data['student']],
                    'keyword2' => ['value' => $data['bill_order']],
                    'keyword3' => ['value' => $data['balance_pay'].'元'],
                    'keyword4' => ['value' => $data['goods_des']],
                    'remark' => ['value' => '大热篮球']
                ]
            ];
            $saveData = [
                            'title'=>"订单支付成功-{$data['goods']}",
                            'content'=>"订单号: {$data['bill_order']}<br/>支付金额: {$data['balance_pay']}元<br/>支付学生信息:{$data['student']}",
                            'url'=>url('frontend/bill/billInfo',['bill_order'=>$data['bill_order']],'',true),
                            'member_id'=>$data['member_id']
                        ];
            //给训练营营主发送消息
            if($data['balance_pay'] == 0){
                $MessageCampData = [
                    "touser" => '',
                    "template_id" => config('wxTemplateID.successBill'),
                    "url" => url('frontend/bill/billInfoOfCamp',['bill_order'=>$data['bill_order']],'',true),
                    "topcolor"=>"#FF0000",
                    "data" => [
                        'first' => ['value' => '体验课预约申请成功'],
                        'keyword1' => ['value' => $data['student']],
                        'keyword2' => ['value' => $data['bill_order']],
                        'keyword3' => ['value' => $data['balance_pay'].'元'],
                        'keyword4' => ['value' => $data['goods_des']],
                        'remark' => ['value' => '大热篮球']
                    ]
                ];
                $MessageCampSaveData = [
                            'title'=>"预约体验申请-{$data['goods']}",
                            'content'=>"订单号: {$data['bill_order']}<br/>支付金额: {$data['balance_pay']}元<br/>申请学生:{$data['student']}<br/>申请理由: {$data['remarks']}",
                            'member_id'=>$data['member_id'],
                            'url'=>url('frontend/bill/billInfoOfCamp',['bill_order'=>$data['bill_order']],'',true)
                        ];
            }else{
                $MessageCampData = [
                    "touser" => '',
                    "template_id" => config('wxTemplateID.successBill'),
                    "url" => url('frontend/bill/billInfoOfCamp',['bill_order'=>$data['bill_order']],'',true),
                    "topcolor"=>"#FF0000",
                    "data" => [
                        'first' => ['value' => '订单支付成功通知'],
                        'keyword1' => ['value' => $data['student']],
                        'keyword2' => ['value' => $data['bill_order']],
                        'keyword3' => ['value' => $data['balance_pay'].'元'],
                        'keyword4' => ['value' => $data['goods_des']],
                        'remark' => ['value' => '大热篮球']
                    ]
                ];
                $MessageCampSaveData = [
                            'title'=>"购买-{$data['goods']}",
                            'content'=>"订单号: {$data['bill_order']}<br/>支付金额: {$data['balance_pay']}元<br/>购买人:{$data['member']}<br/>购买理由: {$data['remarks']}",
                            'member_id'=>$data['member_id'],
                            'url'=>url('frontend/bill/billInfoOfCamp',['bill_order'=>$data['bill_order']],'',true)
                        ];
            }
            
            // camp_member操作
            $CampMember = new CampMember;
            $is_campMember = $CampMember->where(['camp_id'=>$data['camp_id'],'member_id'=>$data['member_id']])->find();
            if($is_campMember){
                // 强制更新
                 $CampMember->save(['type'=>1],['camp_id'=>$data['camp_id'],'member_id'=>$data['member_id']]);
            }else{
                $CampMember->save(['type'=>1,'camp_id'=>$data['camp_id'],'member_id'=>$data['member_id'],'camp'=>$data['camp'],'member'=>$data['member'],'status'=>1]);
            }
            // lesson_member操作
            $LessonMember = new LessonMember;
            $is_student2 = $LessonMember->where(['camp_id'=>$data['camp_id'],'lesson_id'=>$data['goods_id'],'student_id'=>$data['student_id'],'status'=>1])->find();
            
            //添加一条学生数据
            if(!$is_student2){
                if($data['balance_pay']>0){
                    $re = $LessonMember->save(['camp_id'=>$data['camp_id'],'camp'=>$data['camp'],'member_id'=>$data['member_id'],'member'=>$data['member'],'status'=>1,'student_id'=>$data['student_id'],'student'=>$data['student'],'lesson_id'=>$data['goods_id'],'lesson'=>$data['goods'],'rest_schedule'=>$data['total'],'type'=>1]);
                    if(!$re){
                        db('log_lesson_member')->insert(['member_id'=>$data['member_id'],'member'=>$data['member'],'data'=>json_encode($data)]);
                    }
                }else{
                    // 体验课学生课量为0
                   $re = $LessonMember->save(['camp_id'=>$data['camp_id'],'camp'=>$data['camp'],'member_id'=>$data['member_id'],'member'=>$data['member'],'status'=>1,'student_id'=>$data['student_id'],'student'=>$data['student'],'lesson_id'=>$data['goods_id'],'lesson'=>$data['goods'],'rest_schedule'=>0,'type'=>2]);
                    if(!$re){
                        db('log_lesson_member')->insert(['member_id'=>$data['member_id'],'member'=>$data['member'],'data'=>json_encode($data)]);
                    } 
                }
            }else{
                // 课量增加
                // 只有正式学生课量增加,并且状态强制改为正式学生
                if($data['balance_pay']>0){
                    $re = $LessonMember->where(['camp_id'=>$data['camp_id'],'lesson_id'=>$data['goods_id'],'student_id'=>$data['student_id'],'status'=>1])->setInc('rest_schedule',$data['total']);
                    $ress = db('student')->where(['id'=>$data['student_id']])->inc('total_lesson',1)->inc('total_schedule',$data['total'])->update();
                    if(!$re){
                        db('log_lesson_member')->insert(['member_id'=>$data['member_id'],'member'=>$data['member'],'data'=>json_encode($data)]);
                    }
                }
                
            }
        //结束增加学生数据
        //结束课程操作
        }elseif ($data['goods_type'] == '活动') {
            // camp_member操作
            $CampMember = new CampMember;
            $is_campMember = $CampMember->where(['camp_id'=>$data['camp_id'],'member_id'=>$data['member_id']])->find();
            if(!$is_campMember){
                //成为粉丝
                $CampMember->save(['type'=>-1,'camp_id'=>$data['camp_id'],'member_id'=>$data['member_id'],'camp'=>$data['camp'],'member'=>$data['member'],'status'=>1]);
            }
            
            
        }   
        $MessageService->sendMessageMember($data['member_id'],$MessageData,$saveData);
        $MessageService->sendCampMessage($data['camp_id'],$MessageCampData,$MessageCampSaveData);        
        return 1;
    }

    //判断订单付款金额
    public function isPay($map){
        $result = $this->Bill->where($map)->find();
        if($result){
            return $result['is_pay'];
        }else{
            return false;
        }
        
    }

    // 用户编辑订单
    public function updateBill($data,$map){
        $billInfo = $this->getBill($map);   
        $MessageService = new \app\service\MessageService;            
        switch ($data['action']) {
        // 退款操作
            case '1':
                if($billInfo['status'] != 1){
                    return ['code'=>100,'msg'=>'该订单状态不支持退款申请'];
                }else{
                    if($billInfo['goods_type'] == 1){
                        // 查询剩余课时
                        $lesson_member = db('lesson_member')->where(['lesson_id'=>$billInfo['goods_id'],'member_id'=>$billInfo['member_id'],'status'=>1])->find();
                        if($lesson_member['rest_schedule'] < 1){
                            return ['code'=>100,'msg'=>'您已上完课,不允许退款了'];
                        }
                    }
                    $updateData = ['status'=>-1,'remarks'=>$data['remarks']];
                    $result = $this->Bill->save($updateData,$map);
                    if($result){
                        // 发送消息给训练营管理员和营主
                        $MessageCampData = [
                            "touser" => '',
                            "template_id" => config('wxTemplateID.successRefund'),
                            "url" => url('frontend/bill/billInfoOfCamp',$map,'',true),
                            "topcolor"=>"#FF0000",
                            "data" => [
                                'first' => ['value' => '['.$billInfo['goods'].']收到一笔申请退款'],
                                'keyword1' => ['value' => $billInfo['bill_order']],
                                'keyword2' => ['value' => $billInfo['balance_pay'].'元'],
                                'keyword3' => ['value' => $billInfo['remarks']],
                                'remark' => ['value' => '大热篮球']
                            ]
                        ];
                        $saveData = [
                                'title'=>"退款申请-{$billInfo['goods']}",
                                'content'=>"订单号: {$billInfo['bill_order']}<br/>退款金额: {$billInfo['balance_pay']}元<br/>退款理由:{$billInfo['remarks']}",
                                'url'=>url('frontend/bill/billInfoOfCamp',$map)
                            ];
                        $MessageService->sendCampMessage($billInfo['camp_id'],$MessageCampData,$saveData);
                    }

                }
                break;
            // 修改价格和数量
                case '2':
                    if($billInfo['status'] != 0){
                        return ['code'=>100,'msg'=>'只有未付款订单才可以修改价格和数量'];
                    }else{
                        $updateData = ['remarks'=>$data['remarks'],'total'=>$data['total'],'price'=>$data['price']];
                        $result = $this->Bill->save($updateData,$map);
                        if($result){
                            // 发送消息给用户

                        }
                    }
                    break;
            //同意退款 
                case '3':
                        if($billInfo['status']!= -1){
                            return ['code'=>100,'msg'=>'该订单状态不支持该操作'];
                        }   
                        $isPower = $this->isPower($billInfo['camp_id'],session('memberInfo.id'));
                        if($isPower<3){
                            return ['code'=>100,'msg'=>'您没有这个权限'];
                        }
                        if($billInfo['goods_type'] == '课程'){
                            // 查询剩余课时
                            $lesson_member = db('lesson_member')->where(['lesson_id'=>$billInfo['goods_id'],'member_id'=>$billInfo['member_id'],'status'=>1,'type'=>1])->find();
                            if(!$lesson_member || $lesson_member['rest_schedule']<1){
                                return ['code'=>100,'msg'=>'该学生已上完课,不允许退款'];
                            }
                            $refundTotal = ($lesson_member['rest_schedule']<$billInfo['total'])?$lesson_member['rest_schedule']:$billInfo['total'];


                            $updateData = [
                                'refundamount'=>($refundTotal*$billInfo['price']),
                                'status'=>-2,
                                'remarks' => "您的剩余课时为{$lesson_member['rest_schedule']}, 您的订单总数量为{$billInfo['total']},因此退您{$refundTotal}节课的钱"
                            ]; 
                            $result = $this->Bill->save($updateData,$map);
                            if($result){
                                // 剩余课时的变化
                                $rest_schedule = $lesson_member['rest_schedule']-$refundTotal;
                                if($rest_schedule == 0){
                                    db('lesson_member')->where(['lesson_id'=>$billInfo['goods_id'],'member_id'=>$billInfo['member_id'],'status'=>1,'type'=>1])->update(['rest_schedule'=>$rest_schedule,'status'=>4]);
                                }else{
                                    db('lesson_member')->where(['lesson_id'=>$billInfo['goods_id'],'member_id'=>$billInfo['member_id'],'status'=>1,'type'=>1])->update(['rest_schedule'=>$rest_schedule]);
                                }
                            }
                        }else{
                            // 其他订单

                        }
                       
                        
                        if($result){
                            
                            //发送信息给用户
                            $MessageData = [
                                "touser" => session('memberInfo.openid'),
                                "template_id" => config('wxTemplateID.successCheck'),
                                "url" => url('frontend/bill/billInfo',['bill_id'=>$billInfo['id']],'',true),
                                "topcolor"=>"#FF0000",
                                "data" => [
                                    'first' => ['value' => "{$billInfo['goods']}退款申请已被同意"],
                                    'keyword1' => ['value' => '您的退款申请已被同意'],
                                    'keyword2' => ['value' => date('Y-m-d H:i:s',time())],
                                    'remark' => ['value' => '退款完成需要2-3个工作日到账,如有疑问,请联系客服']
                                ]
                            ];
                            $saveData = [
                                            'title'=>"{$billInfo['goods']}退款申请已被同意",
                                            'content'=>"订单号: {$billInfo['bill_order']}<br/>支付金额: {$billInfo['balance_pay']}元<br/>支付信息:{$billInfo['student']}",
                                            'url'=>url('frontend/bill/billInfo',['bill_id'=>$billInfo['id']],'',true),
                                            'member_id'=>$data['member_id']
                                        ];

                            $MessageService->sendMessageMember($billInfo['member_id'],$MessageData,$saveData); 


                        }
                    break;
            //其他   
                default:
                    return ['code'=>100,'msg'=>'非法操作'];
                    break;
            }

            if($result){
                return ['code'=>200,'msg'=>'操作成功'];
            }else{
                return ['code'=>100,'msg'=>'操作失败,请检查网络或者刷新页面重新尝试'];
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