<?php
namespace app\management\service;

class AuthService {



	public function login($map,$keeptime = 3600){

		$Member = new \app\model\Member;
		$memberInfo = $Member->where($map)->find();
		if($memberInfo){
			$admin->logintime++;
	        $admin->lastlogin_at = time();
	        $admin->lastlogin_ip = request()->ip();
	        $admin->lastlogin_ua = request()->header('user-agent');
			cookie('member_id',$memberInfo['id'],$keeptime);
		}else{
			return false;
		}

	}
}