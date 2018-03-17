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


	public function memberlist(){
		$field = '请选择搜索关键词';
		$map = [];

		$field = input('param.field');
		$keyword = input('param.keyword');
		if($keyword==''){
			$map = [];
			$field = '请选择搜索关键词';
		}else{
			if($field){
				$map = [$field=>['like',"%$keyword%"]];
			}else{
				$field = '请选择搜索关键词';
				$map = function($query) use ($keyword){
					$query->where(['member'=>['like',"%$keyword%"]])->whereOr(['telephone'=>['like',"%$keyword%"]])->whereOr(['nickname'=>['like',"%$keyword%"]])->whereOr(['hot_id'=>['like',"%$keyword%"]]);
				};
			}
		}
			
		

		$memberList = $this->MemberService->getMemberListByPage($map);
		// dump($memberList->toArray());die;
		// 模板变量赋值


		$this->assign('field',$field);
		$this->assign('memberList', $memberList);
		return view('member/memberList');
	}


	public function createMember(){

		if(request()->isPost()){
			$data = input('post.');
			$data['password'] = $data['repassword'] = $data['system_remarks'] = rand(100000,999999);
			$result = $this->MemberService->saveMemberInfo($data);
			if($result['code'] == 100){
				echo '<script type="text/javascript">alert("'.$result["msg"].'")</script>';
			}else{
				// 判断是否有添加学生
				if($data['student']){
					$data['member_id'] = $result['data'];
					$Student = new \app\model\Student;
					$Student->save($data);
				}
				echo '<script type="text/javascript">alert("'.$result["msg"].'")</script>';
			}
		}

		return	$this->fetch('member/createMember');
	}
}