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
	public function getMessageMemberList($map,$page = 1 ,$paginate=10){
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


	// 获取系统消息列表
	public function getMessageList($map,$page = 1 ,$paginate=10){
		$result = $this->MessageModel
				->where($map)
				->whereOr(['is_system'=>1])
				// ->page($page,$paginate)
				->select();
		if($result){
			$res = $result->toArray();
			return $result;
		}else{
			return $res;
		}
	}

	//修改Message资料
	public function updateMessageInfo($data,$id){
		$result = $this->MessageModel->save($data,['id'=>$id]);
		
		if($result ===false){
			return ['msg'=>$this->MessageModel->getError(),'code'=>100];
		}else{
			return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$result];
		}	
	}

	//新建Message
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