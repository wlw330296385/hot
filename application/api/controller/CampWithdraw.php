<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampWithdrawService;
use think\Db;
class CampWithdraw extends Base{
   protected $CampWithdrawService;
 
    public function _initialize(){
        parent::_initialize();
        $this->CampWithdrawService = new CampWithdrawService;

    }
    
    protected function isPower(){
        $isPower = $this->CampWithdrawService->isPower(input('param.camp_id'),$this->memberInfo['id']);
        return $isPower;
    }

    public function getCountApi(){
        try {
            $map = input('param.');
            $count = db('camp_withdraw')->where($map)->count();
            return json(['code'=>200,'data'=>$count?$count:0]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取提现列表
    public function getCampWithdrawListApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<3){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->CampWithdrawService->getCampWithdrawList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
    
    // 编辑提现(废弃)
    public function updateCampWithdrawApi(){
         try{
            return false;
            $isPower = $this->isPower();
            if($isPower<>4){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $data = input('post.');
            $camp_withdraw_id = input('param.camp_withdraw_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];

            $campInfo = db('camp')->where(['id'=>input('param.camp_id')])->find();
            if($campInfo['balance']<$data['withdraw']){
                return json(['code'=>100,'msg'=>'余额不足']);
            }
            $data['s_balance'] = $data['e_balance'] = $campInfo['balance'];
            $data['camp_type'] = $campInfo['type'];

            $result = $this->CampWithdrawService->updateCampWithdraw($data,['id'=>$camp_withdraw_id]);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
     }
    // 新建提现
    public function createCampWithdrawApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<>4){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['camp_id'] = input('param.camp_id');
            $campInfo = db('camp')->where(['id'=>input('param.camp_id')])->find();
            if($campInfo['balance']<$data['withdraw']){
                return json(['code'=>100,'msg'=>'余额不足']);
            }
            $data['s_balance'] = $campInfo['balance'];
            $data['e_balance'] = $campInfo['balance'] - $data['withdraw'];
            $data['camp_type'] = $campInfo['type'];
            $data['camp'] = $campInfo['camp'];
            $data['rebate_type'] = $campInfo['rebate_type'];
            $data['schedule_rebate'] = $campInfo['schedule_rebate'];
            $data['buffer'] = $data['withdraw'];
            if($campInfo['rebate_type'] == 2){
                $data['camp_withdraw_fee'] = $data['buffer']*$campInfo['schedule_rebate'];
            }else{
                $data['camp_withdraw_fee'] = 0;
            }
            $result = $this->CampWithdrawService->createCampWithdraw($data);
            if($result['code'] == 200){
                $openid = $this->memberInfo['openid'];
                $messageData = [
                    "touser" => $openid,
                    "template_id" => config('wxTemplateID.withdraw'),
                    "url" => "https://m.hot-basketball.com/frontend/camp/campwallet/camp_id/{$data['camp_id']}",
                    "topcolor"=>"#FF0000",
                    "data" => [
                        'first' => ['value' => '您的提现申请成功'],
                        'keyword1' => ['value' => "{$data['withdraw']}"],
                        'keyword2' => ['value' => "{$data['camp_withdraw_fee']}"],
                        'keyword3' => ['value' => ($data['withdraw'] - $data['camp_withdraw_fee'])],
                        'keyword4' => ['value' => "篮球管家公众号"],
                        'remark' => ['value' => "该笔提现预计在1-2个工作日内处理，如有疑问,请联系平台管理员。"]
                    ]
                ];
                $saveData = [
                    'title'=>"您的提现申请成功",
                    'content'=>"该笔提现预计在1-2个工作日内处理，如有疑问,请联系平台管理员。",
                    'url'=>url('frontend/camp/campwallet',['camp_id'=>$data['camp_id']],'',true),
                    'member_id'=>$this->memberInfo['id']
                ];
                $MessageService = new \app\service\MessageService;
                $MessageService->sendMessageMember($this->memberInfo['id'],$messageData,$saveData);
                db('camp')->where(['id'=>$data['camp_id']])->dec('balance',$data['buffer'])->update();
            }
            return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 取消提现
    public function cancelWithdrawApi(){
        // Db::startTrans();
        try{
            $isPower = $this->isPower();
            if($isPower<>4){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $camp_withdraw_id = input('param.camp_withdraw_id');
            $remarks = input('param.remarks');
            $campInfo = db('camp')->where(['id'=>input('param.camp_id')])->find();
            $CampWithdraw = new \app\model\CampWithdraw;
            $campWithdrawInfo = $CampWithdraw->where(['id'=>$camp_withdraw_id])->find();
            if($campWithdrawInfo['camp_id']<>input('param.camp_id')){
                return json(['code'=>100,'msg'=>'不可操作他人的训练营']);
            }
            if($campWithdrawInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'不可操作非本人发起的提现申请']);
            }
            if($campWithdrawInfo['status']<>1){
                return json(['code'=>100,'msg'=>'该提现状态不允许取消']);
            }
            $result = $CampWithdraw->save(['status'=>-2,'buffer'=>0,'remarks'=>$remarks],['id'=>$camp_withdraw_id]);
            // return json(['code'=>100,'msg'=>'????']);
            if($result){
                $res = db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->inc('balance',$campWithdrawInfo['buffer'])->update();
                if($res){
                    $date_str = date('Ymd',time());
                    if($campWithdrawInfo['rebate_type'] == 2){
                            
                        $res = db('output')->insert([
                            'output'        => -$campWithdrawInfo['camp_withdraw_fee'],
                            'camp_id'       => $campWithdrawInfo['camp_id'],
                            'camp'          => $campWithdrawInfo['camp'],
                            'member_id'     => $campWithdrawInfo['member_id'],
                            'member'        => $campWithdrawInfo['member'],
                            'type'          => 4,
                            'e_balance'     => $campInfo['balance'] + $campWithdrawInfo['camp_withdraw_fee'],
                            's_balance'     => $campInfo['balance'],
                            'f_id'          => $campWithdrawInfo['id'],
                            'rebate_type'   => $campWithdrawInfo['rebate_type'],
                            'schedule_rebate'   =>$campWithdrawInfo['schedule_rebate'],
                            'date_str'      =>$date_str,
                            
                            'create_time'   => time(),
                            'update_time'   => time(),
                        ]);
                        if(!$res){
                            return json(['code'=>100,'msg'=>'余额返回失败,请务必联系客服01']);
                        }
                        $res = db('output')->insert([
                            'output'        => -$campWithdrawInfo['withdraw'] + $campWithdrawInfo['camp_withdraw_fee'],
                            'camp_id'       => $campWithdrawInfo['camp_id'],
                            'camp'          => $campWithdrawInfo['camp'],
                            'member_id'     => $campWithdrawInfo['member_id'],
                            'member'        => $campWithdrawInfo['member'],
                            'type'          => -1,
                            'e_balance'     =>$campInfo['balance'] + $campWithdrawInfo['withdraw'] - $campWithdrawInfo['camp_withdraw_fee'],
                            's_balance'     =>$campInfo['balance'],
                            'f_id'          =>$campWithdrawInfo['id'],
                            'rebate_type'   =>$campWithdrawInfo['rebate_type'],
                            'schedule_rebate'   =>$campWithdrawInfo['schedule_rebate'],
                            'date_str'      =>$date_str,
                            'create_time'   => time(),
                            'update_time'   => time(),
                        ]);
                        if(!$res){
                            return json(['code'=>100,'msg'=>'余额返回失败,请务必联系客服02']);
                        }
                    }else{
                        $res = db('output')->insert([
                            'output'        => -$campWithdrawInfo['withdraw'],
                            'camp_id'       => $campWithdrawInfo['camp_id'],
                            'camp'          => $campWithdrawInfo['camp'],
                            'member_id'     => $campWithdrawInfo['member_id'],
                            'member'        => $campWithdrawInfo['member'],
                            'type'          => -1,
                            'e_balance'     =>($campInfo['balance']+$campWithdrawInfo['withdraw']),
                            's_balance'     =>($campInfo['balance']),
                            'f_id'          =>$campWithdrawInfo['id'],
                            'rebate_type'   =>$campWithdrawInfo['rebate_type'],
                            'schedule_rebate'   =>$campWithdrawInfo['schedule_rebate'],
                            'date_str'      =>$date_str,
                            'create_time'   => time(),
                            'update_time'   => time(),
                        ]);
                        if(!$res){
                            return json(['code'=>100,'msg'=>'余额返回失败,请务必联系客服03']);
                        }
                    }
                    if($res){
                        db('camp_finance')->insert([
                            'money'        => -($campWithdrawInfo['buffer']),
                            'camp_id'       => $campWithdrawInfo['camp_id'],
                            'camp'          => $campWithdrawInfo['camp'],
                            'type'          => -4,
                            'e_balance'     =>($campInfo['balance']+$campWithdrawInfo['buffer']),
                            's_balance'     =>($campInfo['balance']),
                            'f_id'          =>$campWithdrawInfo['id'],
                            'rebate_type'   =>$campWithdrawInfo['rebate_type'],
                            'schedule_rebate'   =>$campWithdrawInfo['schedule_rebate'],
                            'date_str'      =>$date_str,
                            'create_time'   => time(),
                            'update_time'   => time(),
                        ]);
                    }                    
                }else{
                    return json(['code'=>100,'msg'=>'余额返回失败,请务必联系客服']);
                }
                // Db::commit();
                return json(['code'=>200,'msg'=>'操作成功']);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            }
        
        }catch (Exception $e){
            // Db::rollback();
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}