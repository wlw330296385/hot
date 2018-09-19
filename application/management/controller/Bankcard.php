<?php 
namespace app\management\controller;
use app\management\controller\Camp;
use app\model\CampBankcard;
// 按课时结算的训练营财务页面
class Bankcard extends Camp{
	public function _initialize(){
		
		parent::_initialize();
	}

	public function index(){
					
	}


	// 添加银行卡
	public function createBankcard(){

		$campBankcard = [];
		$CampBankcard = new CampBankcard;
		if(request()->isPost()){

			$data = input('post.');
			$data['camp_id'] = $this->campInfo['id'];
			$data['camp'] = $this->campInfo['camp'];
			$data['member_id'] = $this->memberInfo['id'];
			$data['member'] = $this->memberInfo['member'];
			$result = $CampBankcard->save($data);
			if($result){
				$this->success('创建成功');
			}else{
				$this->error('创建失败');
			}
		}else{
			$campbankcard_id = input('param.campbankcard_id');
			$campBankcard = $CampBankcard->where(['id'=>$campbankcard_id])->find();
		}

		$this->assign('campBankcard',$campBankcard);
		return $this->fetch();
	}
}