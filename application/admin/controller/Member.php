<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\MemberService;
class Member extends Backend{
	public $MemberService;
	public function _initialize(){
		parent::_initialize();
		$this->MemberService = new MemberService;
	}


	public function memberList(){
		$breadcrumb = ['ptitle' => '会员管理', 'title' => '会员列表'];

		$memberList = $this->MemberService->getMemberListByPage();

		// 模板变量赋值
		$this->assign('memberList', $memberList);
		$this->assign('breadcrumb',$breadcrumb);
		return view();
	}
}