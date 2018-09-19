<?php 
namespace app\management\controller;
use app\management\controller\Backend;
// 按课时结算的训练营财务页面
class Camp extends Backend{

	
	public $campInfo;
	public function _initialize(){
		parent::_initialize();
        // 暂存campInfo
        $camp_id = $this->camp_member['camp_id'];
        $this->campInfo = session('campInfo');
        if(!$this->campInfo){
            $camp_id = $this->camp_member['camp_id'];
            $this->campInfo = db('camp')->where(['id'=>$camp_id])->find();
            cookie('camp_id',$this->campInfo['id']);
            session('campInfo',$this->campInfo);

        }
        $this->assign('campInfo',$this->campInfo);
	}
}