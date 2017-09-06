<?php
namespace app\api\controller;
use think\Controller;
use app\service\MemberService;

class Index extends Controller{
	
    public function index() {
    	$Member = new MemberService();
    	$member = $Member->getMemberInfo(1);
    	dump($member);
    }

    
    
}
