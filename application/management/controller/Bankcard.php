<?php 
namespace app\management\controller;
use app\management\controller\Camp;
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
		if(request()->isPost()){

		}else{
			$campbankcard_id = input('param.id');
		}

		$this->assign('campBankcard',$campBankcard);
		return $this->fetch();
	}
}