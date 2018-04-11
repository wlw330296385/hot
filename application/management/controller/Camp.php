<?php 
namespace app\management\controller;
use app\management\controller\Backend;
// 按课时结算的训练营财务页面
class Camp extends Backend{

	
	public $campInfo;
	public function _initialize(){
		parent::_initialize();
        $campInfo = db('camp')->where(['id'=>$this->camp_member['camp_id']])->find();
        $this->campInfo = $campInfo;
        $this->assign('campInfo',$campInfo);
	}
}