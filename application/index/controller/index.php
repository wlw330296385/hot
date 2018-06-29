<?php 
namespace app\index\controller;
use think\Controller;
/**
* 
*/
class Index extends Controller
{
	
	function __construct()
	{
		
	}

    public function index(){
        echo "<p><a href='/frontend/index'><h1>欢迎来到篮球管家</h1></p>";
    }

    public function index1(){
    	$testService = new \app\service\TestService(['otion'=>'a']);
    	$testService->test();
    }

    public function index2(){
        $list = db('item_coupon_member')->field('item_coupon_member.id,member.telephone,member.avatar')->join('member','member.id=item_coupon_member.member_id')->select();
        dump($list);
        return view();
        
    }


}