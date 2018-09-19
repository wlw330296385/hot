<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use think\Db;
class Withdraw extends Backend{
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {

        return view('CampWithdraw/index');
    }


   
    // 提现列表
    public function campWithdrawList(){
        $keyword = input('param.keyword');
        $status = input('param.status');
        $camp_type = input('param.camp_type');
        $camp_id = input('param.camp_id');
        $map = [];
        if($status){
            $map['status'] = $status;
        }
        if($camp_type){
            $map['camp_type'] = $camp_type;
        }
        if($camp_id){
            $map['camp_id'] = $camp_id;
        }
        $CampWithdraw = new \app\model\CampWithdraw;
        if($keyword){
            $hasWhere['camp'] = ['like',"%$keyword%"];
            $campWithdrawList = $CampWithdraw->with('bank')->where($map)->paginate(10);
        }else{
            $campWithdrawList = $CampWithdraw->with('bank')->where($map)->paginate(10);
        }
         
        $this->assign('campWithdrawList',$campWithdrawList);
        return $this->fetch('Withdraw/campWithdrawList');
    }

    // 提现处理
    public function campWithdrawDeal(){
        // Db::startTrans();
        try{
            $campWithdraw_id = input('param.campWithdraw_id');

            $system_remarks = input('param.system_remarks','略');
            $action = input('param.action');//2=同意,3=已打款,4=同意并已打款,-1=拒绝;
            
            $CampWithdraw = new \app\model\CampWithdraw;
            $campWithdrawInfo = db('camp_withdraw')->where(['id'=>$campWithdraw_id])->find();
            // -2:个人取消(解冻)|-1:拒绝(解冻)|1:申请中(冻结)|2:已同意(并解冻)|3:已打款
            if(!$campWithdrawInfo){
                $this->error('传参错误,找不到提现信息');
            }
            if($campWithdrawInfo['status']>= $action && $action>0){
                // 如果提现状态大于操作状态,返回错误;
                $this->error('违规操作');
            }

            if($campWithdrawInfo['status']<>1 && $action<0){
                $this->error('不是申请中的提现不可以拒绝');
            }
            $campInfo = db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->find();

            if($action == 2){
                // 同意提现
                $res = $CampWithdraw->save(['status'=>$action,'buffer'=>0,'system_remarks'=>$system_remarks],['id'=>$campWithdraw_id]);
                if(!$res){
                    $this->error('操作失败,请务必截图并联系woo,117行');
                }
                $member_id = $campWithdrawInfo['member_id'];
                $openid = db('member')->where(['id'=>$member_id])->value('openid');
                $messageData = [
                    "touser" => $openid,
                    "template_id" => config('wxTemplateID.withdraw'),
                    "url" => "https://m.hot-basketball.com/frontend/camp/campwallet/camp_id/{$campWithdrawInfo['camp_id']}",
                    "topcolor"=>"#FF0000",
                    "data" => [
                        'first' => ['value' => '您的提现申请已被同意'],
                        'keyword1' => ['value' => "{$campWithdrawInfo['withdraw']}"],
                        'keyword2' => ['value' => "{$campWithdrawInfo['camp_withdraw_fee']}"],
                        'keyword3' => ['value' => ($campWithdrawInfo['withdraw'] - $campWithdrawInfo['camp_withdraw_fee'])],
                        'keyword4' => ['value' => "篮球管家公众号"],
                        'remark' => ['value' => "该笔提现预计在1-2个工作日处理，若有疑问,请联系篮球管家工作人员。"]
                    ]
                ];
                $saveData = [
                    'title'=>"提现已同意",
                    'content'=>"该笔提现￥{$campWithdrawInfo['withdraw']}预计在1-2个工作日处理，若有疑问,请联系篮球管家工作人员。",
                    'url'=>url('frontend/camp/campwallet',['camp_id'=>$campWithdrawInfo['camp_id']],'',true),
                    'member_id'=>$member_id
                ];
                $MessageService = new \app\service\MessageService;
                $MessageService->sendMessageMember($member_id,$messageData,$saveData);

                $this->record("{$this->admin['username']}同意了{$campWithdrawInfo['camp']}的提现申请");
            }elseif ($action == -1) {
                // 拒绝操作,解冻资金
                $res = $CampWithdraw->save(['status'=>$action,'buffer'=>0,'e_balance'=>($campInfo['balance']+$campWithdrawInfo['buffer']),'system_remarks'=>$system_remarks],['id'=>$campWithdraw_id]);
                if(!$res){
                    $this->error('操作失败,请务必截图并联系woo,124行');
                }
                $res = db('camp')->where(['id'=>$campWithdrawInfo['camp_id']])->inc('balance',$campWithdrawInfo['buffer'])->update();
                if(!$res){
                    $this->error('操作失败,请务必截图并联系woo,128行');
                }
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
                        'system_remarks'=>$system_remarks,
                        'create_time'   => time(),
                        'update_time'   => time(),
                    ]);
                    if(!$res){
                        $this->error('操作失败,请务必截图并联系woo,87行');
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
                        'system_remarks'=>$system_remarks,
                        'create_time'   => time(),
                        'update_time'   => time(),
                    ]);
                    if(!$res){
                        $this->error('操作失败,请务必截图并联系woo,106行');
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
                        'system_remarks'=>$system_remarks,
                        'create_time'   => time(),
                        'update_time'   => time(),
                    ]);
                    if(!$res){
                        $this->error('操作失败,请务必截图并联系woo,100行');
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
                $member_id = $campWithdrawInfo['member_id'];
                $openid = db('member')->where(['id'=>$member_id])->value('openid');
                $messageData = [
                    "touser" => $openid,
                    "template_id" => config('wxTemplateID.withdraw'),
                    "url" => "https://m.hot-basketball.com/frontend/camp/campwallet/camp_id/{$campWithdrawInfo['camp_id']}",
                    "topcolor"=>"#FF0000",
                    "data" => [
                        'first' => ['value' => '您的提现申请已被拒绝'],
                        'keyword1' => ['value' => "{$campWithdrawInfo['withdraw']}"],
                        'keyword2' => ['value' => "{$campWithdrawInfo['camp_withdraw_fee']}"],
                        'keyword3' => ['value' => ($campWithdrawInfo['withdraw'] - $campWithdrawInfo['camp_withdraw_fee'])],
                        'keyword4' => ['value' => "篮球管家公众号"],
                        'remark' => ['value' => "拒绝理由:{$system_remarks}, 若有疑问,请联系篮球管家工作人员。"]
                    ]
                ];
                $saveData = [
                    'title'=>"您的提现申请已被拒绝",
                    'content'=>"拒绝理由:{$system_remarks}, 若有疑问,请联系篮球管家工作人员。",
                    'url'=>url('frontend/camp/campwallet',['camp_id'=>$campWithdrawInfo['camp_id']],'',true),
                    'member_id'=>$member_id
                ];
                $MessageService = new \app\service\MessageService;
                $MessageService->sendMessageMember($member_id,$messageData,$saveData);        
                $this->record("{$this->admin['username']}拒绝了{$campWithdrawInfo['camp']}的提现申请");
            }elseif ($action == 3) {//已打款
                $res = $CampWithdraw->save(['status'=>$action,'system_remarks'=>$system_remarks],['id'=>$campWithdraw_id]);
                if(!$res){
                    $this->error('操作失败,请务必截图并联系woo,139行');
                }

                $member_id = $campWithdrawInfo['member_id'];
                $openid = db('member')->where(['id'=>$member_id])->value('openid');
                $messageData = [
                    "touser" => $openid,
                    "template_id" => config('wxTemplateID.withdraw'),
                    "url" => "https://m.hot-basketball.com/frontend/camp/campwallet/camp_id/{$campWithdrawInfo['camp_id']}",
                    "topcolor"=>"#FF0000",
                    "data" => [
                        'first' => ['value' => '平台工作人员已给您的提现申请进行打款,请您注意查收'],
                        'keyword1' => ['value' => "{$campWithdrawInfo['withdraw']}"],
                        'keyword2' => ['value' => "{$campWithdrawInfo['camp_withdraw_fee']}"],
                        'keyword3' => ['value' => ($campWithdrawInfo['withdraw'] - $campWithdrawInfo['camp_withdraw_fee'])],
                        'keyword4' => ['value' => "篮球管家公众号"],
                        'remark' => ['value' => "该笔提现预计在1-2个工作日内到达您绑定的银行卡账户内，请您注意查收。"]
                    ]
                ];
                $saveData = [
                    'title'=>"提现已打款",
                    'content'=>"该笔提现￥{$campWithdrawInfo['withdraw']}预计在1-2个工作日内到达您绑定的银行卡账户内，请您注意查收。",
                    'url'=>url('frontend/camp/campwallet',['camp_id'=>$campWithdrawInfo['camp_id']],'',true),
                    'member_id'=>$member_id
                ];
                $MessageService = new \app\service\MessageService;
                $MessageService->sendMessageMember($member_id,$messageData,$saveData);
                $this->record("{$this->admin['username']}打款{$campWithdrawInfo['camp']}的提现申请");
            }
            // Db::commit();
            $this->success('操作成功');
            
        }catch(Exception $e){
            // Db::rollback();
            dump($e->getMessage());
        }

    }


}