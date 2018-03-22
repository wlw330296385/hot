<?php
namespace app\management\service;

class AuthService {



	public function login($map,$keeptime = 3600){

		$Member = new \app\model\Member;
		$memberInfo = $Member->where($map)->find();
		if($memberInfo){
			$memberInfo = $memberInfo->toArray();
			$data['logintime'] = $memberInfo['logintime'] ++;
	        $data['lastlogin_at'] = time();
	        $data['lastlogin_ip'] = request()->ip();
	        $data['lastlogin_ua'] = request()->header('user-agent');
	        $Member->save($data);
			cookie('member_id',$memberInfo['id'],$keeptime);
			cache('memberInfo',$memberInfo);
			return true;
		}else{
			return false;
		}

	}
}