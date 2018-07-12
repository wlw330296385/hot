<?php 
namespace app\api\controller;
use app\service\MessageService;
use app\api\controller\Base;
use think\Exception;

class Message extends Base{
	private $MessageService;
	public function _initialize(){
        parent::_initialize();
		$this->MessageService = new MessageService;
	}

    // 获取全部个人消息和系统消息列表
    public function getMessageListApi(){
        try{
            $status = input('param.status');
            $messageList = $this->MessageService->getMessageList(['status'=>$status]);
            if($messageList){
                return json(['code'=>200,'msg'=>'OK','data'=>$messageList]);
            }else{
                return json(['code'=>100,'msg'=>'OK']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取系统消息列表
    public function getMessageListByPageApi(){
        try{
            $status = input('param.status');
            //$page = input('param.page', 1);
            $map['member_id'] = $this->memberInfo['id'];
//            $map = [];
            $messageList = $this->MessageService->getMessageList($map);
            if($messageList){
                return json(['code'=>200,'msg'=>'OK','data'=>$messageList]);
            }else{
                return json(['code'=>100,'msg'=>'OK']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取全部个人消息getMessageListByPageApi带page
    public function getMessageMemberListByPageApi(){
        try{
            $status = input('param.status');
            // 管家类型
            $steward_type = input('param.steward_type', 1);
            if($status){
                $messageMemberList = $this->MessageService->getMessageMemberListByPage(['member_id'=>$this->memberInfo['id'],'status'=>$status, 'steward_type' => $steward_type]);
            }else{
                $messageMemberList = $this->MessageService->getMessageMemberListByPage(['member_id'=>$this->memberInfo['id'], 'steward_type' => $steward_type]);
            }
            
            if($messageMemberList){
                return json(['code'=>200,'msg'=>'OK','data'=>$messageMemberList]);
            }else{
                return json(['code'=>100,'msg'=>'OK']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 获取消息详情
    public function getMessageInfoApi(){
    	try{
    		$message_id = input('param.message_id');
    		$messageInfo = $this->MessageService->getMessageInfo(['id'=>$message_id]);
    		if($messageInfo){
    			return json(['code'=>200,'msg'=>'','data'=>$messageInfo]);
    		}else{
    			return json(['code'=>100,'msg'=>'没有这条消息']);
    		}
    	}catch (Exception $e){
    		return json(['code'=>100,'msg'=>$e->getMessage()]);
    	}
    }

    // 获取消息详情
    public function getMessageMemberInfoApi(){
        try{
            $message_id = input('param.message_id');
            $messageInfo = $this->MessageService->getMessageMemberInfo(['id'=>$message_id]);
            if($messageInfo){
                return json(['code'=>100,'msg'=>'','data'=>$messageInfo]);
            }else{
                return json(['code'=>200,'msg'=>'没有这条消息']);
            }
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    // 设置个人消息状态（1）
    public function setMessageMemberStatusApi(){
        try{
            $message_id = input('param.message_id');
            $status = input('param.status');
            $result = db('message_member')->where(['id'=>$message_id,'member_id'=>$this->memberInfo['id']])->update(['status'=>$status]);
            if($result){
                return json(['code'=>200,'msg'=>'设置成功']);
            }else{
                return json(['code'=>100,'msg'=>'没有这条消息']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 全部已读（all）
    public function setMessageMemberStatusAllApi(){
        try{
  
            $status = input('param.status');
            $steward_type = intpu('param.steward_type',1);
            $result = db('message_member')->where(['member_id'=>$this->memberInfo['id'],'steward_type'=>$steward_type])->update(['status'=>$status]);
            if($result){
                return json(['code'=>200,'msg'=>'设置成功']);
            }else{
                return json(['code'=>100,'msg'=>'没有这条消息']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 发送个人消息
    public function sendMessageApi(){
        try{

            $messageDataStr = input('post.messageData');
            $saveDataStr = input('post.saveData');
            $member_id = input('param.member_id');
            $messageData = json_decode($messageDataStr,true);
            $saveData = json_decode($saveDataStr,true);
            $result = $this->MessageService->sendMessageMember($member_id,$messageData,$saveData);
            if($result){
                return json(['code'=>200,'msg'=>'发送成功']);
            }else{
                return json(['code'=>100,'msg'=>'发送失败']);
            }

        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    //设置系统消息已读
    public function setMessageStatus(){
        try{
            $message_id = input('param.message_id');
            $status = input('param.status');
//             $result = db('message_read')->where(['id'=>$message_id,'member_id'=>$this->memberInfo['id']])->update(['isread'=>$status, 'update_time' => time()]);
            $result = db('message_read')->insert([
                'message_id' => $message_id,
                'member_id' => $this->memberInfo['id'],
                'isread' => 2,
                'create_time' => time()
            ]);
            if($result){
                return json(['code'=>200,'msg'=>'设置成功']);
            }else{
                return json(['code'=>100,'msg'=>'没有这条消息']);
            }

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 删除消息
    public function removeMessageMemberApi(){
        try{
            $message_id = input('param.message_id');
            $result = $this->MessageService -> removeMessageMember(['id'=>$message_id,'member_id'=>$this->memberInfo['id']]);
            if($result){
                return json(['code'=>200,'msg'=>'删除成功']);
            }else{
                return json(['code'=>100,'msg'=>'没有这条消息']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //获取个人消息列表
    public function getMessageMmeberCountApi()
    {
        try {
            $map = input('post.');
            $map['member_id'] = $this->memberInfo['id'];
            $MessageMember = new \app\model\MessageMember;
            $result = $MessageMember->where($map)->count();
            if ($result) {
                return json(['code' => 200, 'msg' => '获取成功', 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => '没有这条消息']);
            }

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    // 申请加入训练营 发送消息
    public function campjoinaudit() {
        try {
            $id = input('param.id');
            $campmemberObj = \app\model\CampMember::get($id);
            if (!$campmemberObj) {
                return json(['code' => 100, 'msg' => __lang('MSG_401')]);
            }
            $campmember = $campmemberObj->toArray();
            $campmember['type_num'] = $campmemberObj->getData('type');
            if ($campmember['type_num'] == -1 || ($campmember['type_num'] > 0 && $campmember['type_num'] < 4)) {
                if ($campmember['type_num'] == 3) {
                    $baseurl = 'frontend/camp/teachlistofcamp';
                } else {
                    $baseurl = 'frontend/camp/coachlistofcamp';
                }
                $data = [
                    'title' => '加入训练营申请',
                    'content' => '会员 ' . $campmember['member'] . '申请加入' . $campmember['camp'] . ' 成为 ' . $campmember['type'] . '，请及时处理',
                    'baseurl' => $baseurl,
                    'member' => $campmember['member'],
                    'jointime' => $campmember['create_time']
                ];

                $messageS = new MessageService();
                $messageS->campJoinAudit($data, $campmember['camp_id']);
                return json(['code'=>100, 'msg'=>'操作成功']);
            }
        }catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 加入训练营
    public function campjoinauditresult() {
        try {
            $id = input('param.id');
            $campmemberObj = \app\model\CampMember::get($id);
            if (!$campmemberObj) {
                return json(['code' => 100, 'msg' => __lang('MSG_401')]);
            }
            $campmember = $campmemberObj->toArray();
            $campmember['type_num'] = $campmemberObj->getData('type');
            $campmember['status_num'] = $campmemberObj->getData('status');
            if ($campmember['type_num'] == -1 || ($campmember['type_num'] > 0 && $campmember['type_num'] < 4)) {
                $url = '';
                $checkstr = '';
                switch ($campmember['status_num']) {
                    case "1" : {
                        $url = url('frontend/camp/powercamp', ['camp_id' => $campmember['camp_id']], '', true);
                        $checkstr = '审核通过';
                        break;
                    }
                    case "-2": {
                        $url = url('frontend/message/index', '', '', true);
                        $checkstr = '被拒绝';
                        break;
                    }
                }

                $data = [
                    'title' => '加入训练营申请结果',
                    'content' => '您好，您申请加入'. $campmember['camp'] .' 成为 '. $campmember['type'] . $checkstr,
                    'url' => $url,
                    'member' => $campmember['member'],
                    'audittime' => $campmember['update_time'],
                    'checkstr' => $checkstr
                ];

                $messageS = new MessageService();
                $messageS->campJoinAuditResult($data, $campmember['member_id']);
            }
        }catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    public function applyleavecamp() {
        try {
            $applyid = input('param.id', 0);
            if (!$applyid) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }

            $applydata = db('camp_leaveapply')->where('id', $applyid)->find();
            if (!$applydata) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }

            $messageData = [
                'template_id' => config('wxTemplateID.checkPend'),
                'url' => url('frontend/student/studentlistofcamp', ['camp_id' => $applydata['camp_id'], 'type' => 1], '', true),
                'data' => [
                    'first' => ['value' => $applydata['camp'] . '的学员 ' . $applydata['username'] . '申请退出训练营。'],
                    'keyword1' => '申请退出训练营',
                    'keyword2' => ['value' => $applydata['username']],
                    'keyword3' => ['value' => date("Y-m-d H:i", $applydata['create_time'])],
                    'remark' => ['value' => '点击进入查看更多']
                ]
            ];
            $saveData = [
                'title' => '学员申请退出训练营',
                'content' => $applydata['camp'] . '的学员 ' . $applydata['username'] . '申请退出训练营。提交申请时间：' . date("Y-m-d H:i", $applydata['create_time']),
                'status' => 1,
                'url' => url('frontend/student/studentlistofcamp', ['camp_id' => $applydata['camp_id'], 'type' => 1], '', true)
            ];
            $messageS = new MessageService();
            $messageS->sendCampMessage($applydata['camp_id'], $messageData, $saveData);
        }catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}