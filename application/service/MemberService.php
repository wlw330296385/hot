<?php 
namespace app\service;
use app\model\Member;
class MemberService{

	public static function getMemberInfo($memberID){
		// $member = new Member;
		// $memberInfo = $member->where('id',$memberID)->find()->toArray();
		$memberInfo = Member::get(1)->toArray();
		return $memberInfo;
	}


}