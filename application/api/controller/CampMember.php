<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\model\MessageMember;
use app\service\CampService;
use app\service\CoachService;
use app\service\WechatService;
use think\Db;
use think\Exception;

class CampMember extends Base{
    protected $CampService;
	public function _initialize(){
		parent::_initialize();
        $this->CampService = new CampService;
	}

    // 关注训练营
    public function focusApi(){
        $camp_id = input('param.camp_id');
        $remarks = input('param.remarks');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        if(!$campInfo){
            return json(['code'=>100,'msg'=>'不存在此训练营']);
        }
        //是否已存在身份
        $isType = db('camp_member')->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>$camp_id,'status'=>1])->find();
        if($isType){
            return json(['code'=>100,'msg'=>'你已经是训练营的一员']);
        }
        $result = db('camp_member')->insert(['camp_id'=>$campInfo['id'],'camp'=>$campInfo['camp'],'member_id'=>$this->memberInfo['id'],'member'=>$this->memberInfo['member'],'type'=>-1,'status'=>1,'create_time'=>time()]);
        $msg = '你已经成为该训练营的粉丝!';
        if($result){
            return json(['code'=>200,'msg'=>$msg]);
        }else{
            return json(['code'=>100,'msg'=>'申请失败']);
        }
    }

    // 申请成为训练营的某个身份
    public function applyApi(){
        try{
            $type = input('param.type');
            $camp_id = input('param.camp_id');
            $remarks = input('param.remarks');
            $campInfo = $this->CampService->getCampInfo($camp_id);
            if(!$campInfo){
                return json(['code'=>100,'msg'=>'不存在此训练营']);
            }
            if(!$type ||$type>3 || $type<-1){
                return json(['code'=>100,'msg'=>'不存在这个身份']);
            }
            //是否已存在身份
            $isType = db('camp_member')->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>$camp_id])->find();
            if($isType){
                if($isType['status'] == 1) {
                    return json(['code'=>100,'msg'=>'你已经是训练营的一员']);
                } else {
                    return json(['code'=>100,'msg'=>'你已申请加入训练营,请等待审核']);
                }
            }
            $status = 0;
            if($type == -1){
                $status = 1;
            }
            $result = db('camp_member')->insert([
                'camp_id'=>$campInfo['id'],
                'camp'=>$campInfo['camp'],
                'member_id'=>$this->memberInfo['id'],
                'member'=>$this->memberInfo['member'],
                'remarks' => $remarks,
                'type'=>$type,
                'status'=>$status,
                'create_time'=>time()]);
            if($result){
                return json(['code'=>200,'msg'=>'申请成功']);
            }else{
                return json(['code'=>100,'msg'=>'申请失败']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 训练营人员审核
    public function ApproveApplyApi(){
        try{
            $id = input('param.id');
            $status = input('param.status');
            if(!$id || !$status){
                return json(['code'=>100,'msg'=>__lang('MSG_402')]);
            }
            $campMemberInfo = db('camp_member')->where(['id'=>$id,'status'=>0])->find();
            if(!$campMemberInfo){
                return json(['code'=>100,'msg'=>'不存在该申请']);
            }
            $isPower = $this->CampService->isPower($campMemberInfo['camp_id'],$this->memberInfo['id']);

            if($isPower<3){
                return json(['code'=>100,'msg'=>__lang('MSG_403')]);
            }

            $result = db('camp_member')->where(['id'=>$id])->update(['status'=>$status, 'update_time' => time()]);
            if($result){
                return json(['code'=>200,'msg'=>__lang('MSG_200')]);
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_400')]);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }  
    }



    //训练营人员变更
    public function modifyApi(){
        try{
            $id = input('param.id');
            $type = input('param.type');
            if(!$id || !$type || ($type!=2|| $type!=5||$type!=3)){
                return json(['code'=>200,'msg'=>__lang('MSG_402')]);
            }

            $campMemberInfo = db('camp_member')->where(['id'=>$id,'status'=>1])->find();
            if(!$campMemberInfo){
                return json(['code'=>100,'msg'=>'不存在该人员']);
            }
            $isPower = $this->CampService->isPower($campMemberInfo['camp_id'],$this->memberInfo['id']);

            if($isPower<4){
                return json(['code'=>100,'msg'=>__lang('MSG_403')]);
            }

            $result = db('camp_member')->where(['id'=>$id])->update(['type'=>$type]);
            if($result){
                return json(['code'=>200,'msg'=>__lang('MSG_200')]);
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_400')]);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }  
    }
   
    // 获取一条记录
    public function getCampMemberApi(){
        try{
            $camp_id = input('param.camp_id');
            $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
            $CampMember =new  \app\model\CampMember;
            $result = $CampMember->where(['member_id'=>$member_id,'camp_id'=>$camp_id])->find();
            if($result){
                return json(['code'=>200,'msg'=>'OK','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_402').__lang('MSG_403')]);
            }
            
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
    }


    // 获取有教练身份的训练营员工（没分页、可模糊查询）
    public function getCoachListApi(){
        try{
            $camp_id = input('param.camp_id');
            $keyword = input('param.keyword');
            $status = input('param.status', 1);
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['coach.coach'] = ['LIKE','%'.$keyword.'%'];
                $map['coach.status'] = 1;
            }

            $map['camp_id'] = $camp_id;
            $map['camp_member.status'] = $status;
            $map['camp_member.type'] = ['egt', 2];
            $list= Db::view('camp_member',['id' => 'campmemberid','camp_id'])
                ->view('coach','*','coach.member_id=camp_member.member_id')
                ->where($map)
                ->select();
            return ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list];
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //自定义获取训练营身份列表分页（有页码）
    public function getCampMemberListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $CampMember = new  \app\model\CampMember;
            $result = $CampMember->with('coach')->where($map)->paginate(10);
            if($result){
                return json(['code'=>200,'msg'=>'OK','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_402').__lang('MSG_403')]);
            }
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    //自定义获取训练营身份列表有分页
    public function getCampMemberListApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            }
            $page = input('param.page');
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $CampMember = new  \app\model\CampMember;
            $result = $CampMember->with('coach')->where($map)->page($page,10)->select();
            if($result){
                return json(['code'=>200,'msg'=>'OK','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_402').__lang('MSG_403')]);
            }
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    /** 解除训练营-人员关联 2017/09/27
     * $id: input('campmemberid') camp_member表主键
     * @return array|\think\response\Json
     */
    public function removerelationship() {
        try {
            $id = input('campmemberid');
            $model = new \app\model\CampMember();
            $campmember = $model->where(['id' => $id])->find();
            if ($campmember->getData('type')==4 && $campmember->member_id == $this->memberInfo['id']) {
                return json(['code' => 100, 'msg' => '你是营主不能删除自己']);
            }
            
            $campS = new CampService();
            // 操作权限
            $power = $campS->isPower($campmember['camp_id'], $this->memberInfo['id']);
            if ($power < 3) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }

            // 删教练 检查是否在营有在线班级
            if ($campmember->getData('type') == 2) {
                $coachS = new CoachService();
                $grade = $coachS->onlinegradelist($campmember['member_id'], $campmember['camp_id']);
                if ($grade) {
                    return json(['code' => 100, 'msg' => '该教练有在线班级,需先下架或删除班级记录']);
                }
            }

            $campmember->status = -1;
            $result = $campmember->save();
            if ($result) {
                $memberopenid = getMemberOpenid($campmember['member_id']);
                // 发送模板消息
                $sendTemplateData = [
                    'touser' => $memberopenid,
                    'template_id' => 'anBmKL68Y99ZhX3SVNyyX6hrtzhlDW3RrB-vB6_GmqM',
                    'url' => url('frontend/index/index', '', '', true),
                    'data' => [
                        'first' => ['value' => '您好, 您所在的'. $campmember['camp'] .'的'. $campmember['type'].'身份被移除了'],
                        'keyword1' => ['value' => $campmember['member']],
                        'keyword2' => ['value' => '训练营营主或管理员移除'],
                        'keyword3' => ['value' => date('Y年m月d日 H时i分')]
                    ]
                ];
                $wechatS = new WechatService();
                $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
                $log_sendTemplateData = [
                    'wxopenid' => $memberopenid,
                    'member_id' => $campmember['member_id'],
                    'url' => $sendTemplateData['url'],
                    'content' => serialize($sendTemplateData),
                    'create_time' => time()
                ];
                if ($sendTemplateResult) {
                    $log_sendTemplateData['status'] = 1;
                } else {
                    $log_sendTemplateData['status'] = 0;
                }
                db('log_sendtemplatemsg')->insert($log_sendTemplateData);

                // 发送站内消息
                $modelMessageMember = new MessageMember();
                $modelMessageMember->save([
                    'title' => $sendTemplateData['data']['first']['value'],
                    'content' => $sendTemplateData['data']['first']['value'],
                    'member_id' => $campmember['member_id'],
                    'status' => 1,
                    'url' => $sendTemplateData['url']
                ]);

                $response = json(['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $result]);
            } else {
                $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            return $response;
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    // 邀请加入训练营
    public function invate(){
        $data = input('post.');
        $isMember = $this->CampService->getCampMemberInfo($data);
        if($isMember){
            return json(['msg'=>'他已经申请加入训练题']);
        }
    }



}
