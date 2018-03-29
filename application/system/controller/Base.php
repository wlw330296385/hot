<?php 
namespace app\system\controller;
use think\Controller;
use think\Exception;
use app\system\model\CrontabRecord;
class Base extends Controller{
	public $CrontabRecord;
	public function _initialize() {
		$this->CrontabRecord = new CrontabRecord;
    }



    protected function record($data){
    	$data['date_str'] = date('Y-m-d H:i:s',time());
    	$this->CrontabRecord->save($data);
    }
}