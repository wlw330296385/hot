<?php
namespace app\api\controller;
use app\service\MemberService;
class Index{
    public function index() {
    	$memberInfo = MemberService::getMemberInfo(1);
    	dump($memberInfo);
        echo 111;
    }
}
