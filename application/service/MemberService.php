<?php 
namespace app\service;
use app\model\Member;
use app\common\validate\MemberVal;
class MemberService{
	private $memberModel;	
	public function __construct(){
		$this->memberModel = new Member;
	}
	// 获取会员
	public function getMemberInfo($map){
		$result = $this->memberModel->with('coach')->where($map)->find()->toArray();
		return $result;
	}

	//获取资源列表
	public function getMemberList($map){
		$result = $this->memberModel->where($map)->find()->toArray();
		return $result;
	}

	//修改会员资料
	public function updateMemberInfo($request,$id){
		$result = $this->memberModel->save($request,['id'=>$id]);
		
		if($result ===false){
			return ['msg'=>$this->memberModel->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}	
	}

	//新建会员
	public function saveMemberInfo($request){
		$result = $this->memberModel->validate('MemberVal')->data($request)->save();
		
		if($result ===false){
			return ['msg'=>$this->memberModel->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}	
	}
}