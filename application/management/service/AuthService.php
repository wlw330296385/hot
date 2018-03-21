<?php
namespace app\management\service;

class AuthService {



	public function login($map,$keeptime = 3600){

		$Member = new \app\model\Member;
		$memberInfo = $Member->where($map)->find();
		if($memberInfo){
			$Member->logintime++;
	        $Member->lastlogin_at = time();
	        $Member->lastlogin_ip = request()->ip();
	        $Member->lastlogin_ua = request()->header('user-agent');
	        $Member->save();
			cookie('member_id',$memberInfo['id'],$keeptime);
			cache('memberInfo',$memberInfo);
			return true;
		}else{
			return false;
		}

	}
}