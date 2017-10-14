<?php 
namespace app\api\controller;
use app\service\MessageService;
use app\api\controller\Base;
class Message extends Base{
	private $MessageService;
	public function _initialize(){
        parent::_initialize();
		$this->MessageService = new MessageService;
	}

    public function index() {
        
    }



    // 获取全部个人消息和系统消息列表
    public function getMessageListApi(){
    	try{
            $status = input('param.status');
    		$campIDs = db('camp_member')
                  ->where(['member_id'=>$this->memberInfo['id'],'status'=>1])
                  ->where('type','gt',2)
                  ->where('delete_time',null)
                  ->column('camp_id');
            $messageList = $this->MessageService->getMessageList(['camp_id'=>['in',$campIDs]]);
            if($status){
                $messageMemberList = $this->MessageService->getMessageMemberList(['member_id'=>$this->memberInfo['id'],'status'=>$status]);
            }else{
                $messageMemberList = $this->MessageService->getMessageMemberList(['member_id'=>$this->memberInfo['id']]);
            }
            
	    	if($messageList){
	    		return json(['code'=>100,'msg'=>'OK','data'=>['messagelist'=>$messageList,'messageMemberList'=>$messageMemberList]]);
	    	}else{
	    		return json(['code'=>200,'msg'=>'OK']);
	    	}
	    }catch(Exception $e){
	    	return json(['code'=>200,'msg'=>$e->getMassege()]);
	    }
    }


    // 获取消息详情
    public function getMessageInfoApi(){
    	try{
    		$message_id = input('param.message_id');
    		$messageInfo = $this->MessageService->getMessageInfo(['id'=>$message_id]);
    		if($messageInfo){
    			return json(['code'=>100,'msg'=>'','data'=>$messageInfo]);
    		}else{
    			return json(['code'=>200,'msg'=>'没有这条消息']);
    		}
    	}catch (Exception $e){
    		return json(['code'=>200,'msg'=>$e->getMassege()]);
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
            return json(['code'=>200,'msg'=>$e->getMassege()]);
        }
    }

    // 设置消息状态
    public function setMessageMemberStatus(){
        try{
            $message_id = input('param.message_id');
            $status = input('param.status');
            $result = db('message_member')->where(['id'=>$message_id,'member_id'=>$this->memberInfo['id']])->update(['status'=>$status]);
            if($result){
                return json(['code'=>100,'msg'=>'设置成功']);
            }else{
                return json(['code'=>200,'msg'=>'没有这条消息']);
            }
            
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMassege()]);
        }
    }

    // 删除消息
    public function removeMessageMemberApi(){
        try{
            $message_id = input('param.message_id');
            $result = $this->MessageService -> removeMessageMember(['id'=>$message_id,'member_id'=>$this->memberInfo['id']]);
            if($result){
                return json(['code'=>100,'msg'=>'删除成功']);
            }else{
                return json(['code'=>200,'msg'=>'没有这条消息']);
            }
            
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMassege()]);
        }
    }

    //获取个人消息列表
    public function getUnReadMessageMmeberListApi()
    {
        try {
            $map = input('post.');
            $map['member_id'] = $this->memberInfo['id'];
            $result = $this->MessageService->getMessageMemberListByPage($map);
            if ($result) {
                return json(['code' => 100, 'msg' => '获取成功', 'data' => $result]);
            } else {
                return json(['code' => 200, 'msg' => '没有这条消息']);
            }

        } catch (Exception $e) {
            return json(['code' => 200, 'msg' => $e->getMassege()]);
        }
    }


    //
    public function campjoinaudit() {
        $id =input('param.id');
        $campmemberObj = \app\model\CampMember::get($id);
        if (!$campmemberObj) {
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
        $campmember = $campmemberObj->toArray();
        $campmember['type_num'] = $campmemberObj->getData('type');
        if ($campmember['type_num'] > 1) {
            if ($campmember['type_num'] == 3) {
                $baseurl = 'frontend/camp/teachlistofcamp';
            } else  {
                $baseurl = 'frontend/camp/coachlistofcamp';
            }
            $data = [
                'title' => '加入训练营申请',
                'content' => '会员 '.$campmember['member'].'申请加入'. $campmember['camp'] .' 成为 '. $campmember['type'] .', 请及时处理',
                'baseurl' => $baseurl,
                'member' => $campmember['member'],
                'jointime' => $campmember['create_time']
            ];

            $messageS = new MessageService();
            $messageS->campJoinAudit($data, $campmember['camp_id']);
        }
       
    }
}