<?php 
namespace app\service;
use app\model\Message;
use app\model\MessageMember;
use app\common\validate\MessageVal;
class MessageService{
	private $MessageModel;	
	private $MessageMemberModel;
	public function __construct(){
		$this->MessageModel = new Message;
		$this->MessageMemberModel = new MessageMember;
	}
	// 获取Message
	public function getMessageInfo($map){
		$result = $this->MessageModel->where($map)->find();
		if($result){
			$res = $result->toArray();
			return $result;
		}else{
			return $res;
		}
		
		
	}

	//获取个人消息列表
	public function getMessageMemberList($map = [],$page = 1 ,$paginate=10){
		$result = $this->MessageMemberModel
				->where($map)
				// ->page($page,$paginate)
				->select();
		if($result){
			$res = $result->toArray();
			return $result;
		}else{
			return $res;
		}
	}

	// 发送个人消息
	public function sendMessageMember($member_id,$data){

		$res = $this->MessageMemberModel->save([
        					'title'=>$data['data']['first']['value'],
        					'content'=>'用户名:'.$data['data']['keyword1']['value'].'<br /> 订单编号:'.$data['data']['keyword2']['value'].'<br /> 金额:'.$data['data']['keyword3']['value'].'<br /> 商品信息:'.$data['data']['keyword4']['value'],
        					'member_id'=>$member_id,
        					'url'=>$data['url']
        					]
        				);
        if($res){
        	$WechatService = new \app\service\WechatService();
        	$result = $WechatService->sendTemplate($data);
        	return true;
        }
        return false;
	}

	// 给训练营的营主发送消息
	public function sendCampMessage($camp_id,$data){
		

		$res = $this->MessageModel->save([
        					'title'=>$data['data']['first']['value'],
        					'content'=>'用户名:'.$data['data']['keyword1']['value'].'<br /> 订单编号:'.$data['data']['keyword2']['value'].'<br /> 金额:'.$data['data']['keyword3']['value'].'<br /> 商品信息:'.$data['data']['keyword4']['value'],
        					'camp_id'=>$camp_id,
        					'is_system'=>2,
        					'url'=>$data['url']
        					]);
		if($res){
			// 获取训练营的营主openid
			$memberIDs = db('camp_member')->where(['camp_id'=>$camp_id,'status'=>1])->where('type','egt',3)->column('member_id');
			$memberList = db('member')->where('id','in',$memberIDs)->select();
			// 发送模板消息
			foreach ($memberList as $key => $value) {
	        	if($value['openid']){
	        		$data['touser'] = $value['openid'];
	        		$WechatService = new \app\service\WechatService();
	        		$result = $WechatService->sendTemplate($data);
	        	}
			}
			return true;
		}
		return false;
	}


	// 获取系统消息列表
	public function getMessageList($map = [],$page = 1 ,$paginate=10){
		$result = $this->MessageModel
				->where($map)
				->whereOr(['is_system'=>1])
				// ->page($page,$paginate)
				->select();
		if($result){
			$res = $result->toArray();
			return $res;
		}else{
			return $result;
		}
	}

	//修改系统Message资料
	public function updateMessageInfo($data,$id){
		$result = $this->MessageModel->save($data,['id'=>$id]);
		
		if($result ===false){
			return ['msg'=>$this->MessageModel->getError(),'code'=>100];
		}else{
			return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$result];
		}	
	}

	//新建系统Message
	public function saveMessageInfo($data){
		$validate = validate('MessageVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
		$result = $this->MessageModel->data($data)->save();
		
		if($result ===false){
			return ['msg'=>$this->MessageModel->getError(),'code'=>100];
		}else{
			return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$result];
		}	
	}
}