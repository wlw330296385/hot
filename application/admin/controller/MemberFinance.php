<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
class MemberFinance extends Backend{

	public function _initialize(){
		parent::_initialize();
	}

	public function index(){
		echo 1;
	}

	public function memberFinanceList(){
		
		$map = [];
		$keyword = input('param.keyword');
		$member_id = input('param.member_id');
		if($keyword == 'woo'){
			cookie('amfk',null);
		}elseif (!$keyword) {
			$keyword = cookie('amfk');
			$map['member'] = ['like',"%{$keyword}%"];
		}else{
			cookie('amfk',$keyword);
			$map['member'] = ['like',"%{$keyword}%"];
		}
		if($member_id){
			$map['member_id'] = $member_id;
		}

		// 模板变量赋值
        $MemberFinance = new \app\model\MemberFinance();
		$memberFinanceList = $MemberFinance->where($map)->paginate(30);
		$this->assign('keyword',$keyword);
		$this->assign('memberFinanceList', $memberFinanceList);
		return view('MemberFinance/MemberFinanceList');
	}


}