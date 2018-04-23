<?php 
namespace app\system\controller;
use think\Controller;
use think\Exception;
class Base extends Controller{
	public function _initialize() {
    }



    protected function record($data){
    	
    	$data['create_time'] = time();
    	$data['date_str'] = date('Y-m-d H:i:s',time());
    	db('crontab_record')->insert($data);
    }
}	