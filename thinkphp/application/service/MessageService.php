<?php 
namespace app\service;
use app\model\Message;
use app\common\validate\MessageVal;
class MessageService{
	private $MessageModel;	
	public function __construct(){
		$this->MessageModel = new Message;
	}
	// 获取Message
	public function getMessageInfo($map){
		$result = $this->MessageModel->where($map)->find()->toArray();
		return $result;
	}

	//获取资源列表
	public function getMessageList($map,$paginate=10){
		$result = $this->MessageModel->where($map)->paginate();
		return $result->toArray();
	}

	//修改Message资料
	public function updateMessageInfo($request,$id){
		$result = $this->MessageModel->save($request,['id'=>$id]);
		
		if($result ===false){
			return ['msg'=>$this->MessageModel->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}	
	}

	//新建Message
	public function saveMessageInfo($request){
		$result = $this->MessageModel->validate('MessageVal')->data($request)->save();
		
		if($result ===false){
			return ['msg'=>$this->MessageModel->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}	
	}
}