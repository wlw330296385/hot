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
		$result = $this->memberModel->where($map)->find()->toArray();
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



	// 获取组织列表
	public function getMyGroup($member_id){
		$result = [];
		$pidArr = $this->memberModel->where(['pid'=>$member_id])->select();
		if($pidArr){
			$arr = $pidArr->toArray();
			$result = $this->getGroupTree($arr,0);
		}
		return $result;
	}


	private function getGroupTree($arr,$times){
		$times++;
		if($times < 4) {
			foreach ($arr as $key => $value) {
				$result = $this->memberModel->where(['pid'=>$value['id']])->select();
				$arr[$key]['groupList'] = $result->toArray();
				$arr[$key]['count'] = count($result->toArray());
				// if($times<3){
				// 	foreach ($arr[$key]['groupList'] as $k => $val) {
				// 	$result = $this->memberModel->where(['pid'=>$val['id']])->select();
				// 	$arr[$key]['groupList'][$key]['groupList'] = $result->toArray();
				// 	}
				// }
				$arr[$key]['groupList'] = $this->getGroupTree($arr[$key]['groupList'],$times);
			}
		}	
		return $arr;
	}
}