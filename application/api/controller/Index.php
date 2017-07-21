<?php
namespace app\api\controller;
use think\Controller;
use app\service\MemberService;

class Index extends Controller{
	
    public function index() {
    	$memberInfo = MemberService::getMemberInfo(1);
    	dump($memberInfo);
        echo 111;
    }

    
    
}
