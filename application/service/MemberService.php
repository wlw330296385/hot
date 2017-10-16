<?php 
namespace app\service;
use app\model\Camp;
use app\model\Coach;
use app\model\Member;
use app\common\validate\MemberVal;
class MemberService{
	private $memberModel;	
	public function __construct(){
		$this->memberModel = new Member;
	}
	// 获取会员
	public function getMemberInfo($map){
		$result = $this->memberModel->where($map)->find();
		if($result){
			$res = $result->toArray();
			return $res;
		}
		return $result;
	}

	//获取资源列表
	public function getMemberList($map){
		$result = $this->memberModel->where($map)->select();
		if($result){
			$res = $result->toArray();
			return $res;
		}
		return $result;
	}

	//修改会员资料
	public function updateMemberInfo($request,$id){
		//验证规则
		$validate = validate('MemberVal');
		if(!$validate->scene('edit')->check($request)){
			return ['msg'=>$validate->getError(),'code'=>100];
		}

		$result = $this->memberModel->allowField(true)->save($request,['id'=>$id]);
		if($result ===false){
			return ['msg'=>$this->memberModel->getError(),'code'=>100];
		}else{
			return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$result];
		}	
	}

	//新建会员
	public function saveMemberInfo($request){
		// 生成一个随机id
		$hot_id = $this->getHotID();
		$MemberModel = new Member();
        $request['password'] = passwd($request['password']);
        $request['repassword'] = passwd($request['repassword']);
        $request['hot_id'] = $hot_id;
        if (!isset($request['avatar'])) {
            $request['avatar'] = '/static/default/avatar.png';
        }

        //验证规则
		$res = $MemberModel->validate('MemberVal.add')->allowField(true)->save($request);
		if ($res === false) {
		    //dump($MemberModel->getError());
            return [ 'code' => 100, 'msg' => $MemberModel->getError() ];
        } else {
		    $login = $this->saveLogin($MemberModel->id);
		    if ($login) {
		        return ['code' => 200, 'msg' => __lang('MSG_200'), ''];
            } else {
		        return ['code' => 100, 'msg' => '请重新登陆'];
            }
        }
	}

	// 生成一个随机id
	private function getHotID(){
		$hot_id = 10000000+rand(00000001,99999999);
		$MemberModel = new Member();
		$is_hot = $MemberModel->where(['hot_id'=>$hot_id])->find();
		if($is_hot){
			$this->getHotID();
		}else{
			return $hot_id;
		}
	}


	// 会员登录
	public function login($username,$password){

		$result = $this->memberModel
				->where(['password'=> passwd($password) ])
				->where(function($query) use ($username){
						$query->where('member',$username)->whereOr('telephone',$username);
					})
				->find();
		return $result['id'];
	}
	// 会员登录状态
	public function saveLogin($id){
		$member = $this->getMemberInfo(['id'=>$id]);
        unset($member['password']);
        cookie('mid', $member['id']);
        cookie('member',md5($member['id'].$member['member'].config('salekey')));
        session('memberInfo',$member,'think');
        if ( session('memberInfo', '', 'think') ) {
            return true;
        } else {
            return false;
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


	public function isFieldRegister($field,$value){
		$result = $this->memberModel->where([$field=>$value])->find();
		return $result?1:0;
	}
	
	// 查询会员是否有教练身份数据
	public function hasCoach($memberid) {
	     $model = new Coach();
	     $res = $model::get(['member_id'=>$memberid]);
	     if ($res) {
             $return = $res->toArray();
             $return['check_status'] =  $model::get(['member_id'=>$memberid])->getData('status'); //审核状态
         } else {
	         $return = 0;
         }
	     return $return;
    }

    public function hasCamp($memberid) {
        $model = new Camp();
        $res = $model::get(['member_id' => $memberid]);
        if ($res) {
            $return = $res->toArray();
            $return['check_status'] = $model::get(['member_id' => $memberid])->getData('status'); //审核状态
        }else {
            $return = 0;
        }
        return $return;
    }
}