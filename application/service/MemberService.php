<?php 
namespace app\service;
use app\model\Member;
use app\validate\MemberVal;
class MemberService{
	private $Member;	
	public function __construct(){
		$this->Member = new Member;
	}
	// 获取会员
	public function getMemberInfo($id){
		$result = $this->Member->where($id)->find()->toArray();
		return $result;
	}

	//获取资源列表
	public function getMemberList($map){
		$result = $this->Member->where($map)->find()->toArray();
		return $result;
	}

	//修改会员资料
	public function updateMemberInfo($request,$id){
		$result = $this->Member->save($request,['id'=>$id]);
		
		if($result ===false){
			return ['msg'=>$this->Member->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}	
	}

	//新建会员
	public function saveMemberInfo($request){
		$result = $this->Member->save($request,['id'=>$id]);
		
		if($result ===false){
			return ['msg'=>$this->Member->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}	
	}
}