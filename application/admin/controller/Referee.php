<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\RefereeService;
class Referee extends Backend{
	public $RefereeService;
	public function _initialize(){
		parent::_initialize();
		$this->RefereeService = new RefereeService;
	}


	public function refereelist(){
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
					$query->where(['referee'=>['like',"%$keyword%"]])->whereOr(['realname'=>['like',"%$keyword%"]]);
				};
			}
		}
		// 模板变量赋值
		$refereeList = $this->RefereeService->getRefereeListByPage($map);
		$this->assign('field',$field);
		$this->assign('refereeList', $refereeList);
		return view('Referee/refereeList');
	}

	public function refereeInfo(){
		$referee_id = input('param.referee_id');
		$refereeInfo = $this->RefereeService->getRefereeInfo(['id'=>$referee_id]);
		// 证书
		$certList = db('cert')->where(['member_id'=>$refereeInfo['member_id'],'cert_type'=>5])->select();

		$this->assign('certList',$certList);
		$this->assign('refereeInfo',$refereeInfo);
		return view('Referee/refereeInfo');
	}

	public function updateReferee(){
		$referee_id = input('param.referee_id');
		$refereeInfo = $this->RefereeService->getRefereeInfo(['id'=>$referee_id]);
		if(request()->isPost() || input('param.status')){
			$data = input('post.');
			if(input('status')){
				// 更新证件
				$data['status'] = input('param.status');
				db('cert')->where(['member_id'=>$refereeInfo['member_id'],'cert_type'=>5])->update(['status'=>input('param.status')]);
			}
			$model = new \app\model\Referee();
			
			$result = $model->save($data,['id'=>$referee_id]);
			if($result){
				$this->success('操作成功');
			}else{
				$this->success('操作失败');
			}
		}
		$this->assign('refereeInfo',$refereeInfo);
		return	$this->fetch('Referee/updateReferee');
	}
}