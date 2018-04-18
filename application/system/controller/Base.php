<?php 
namespace app\system\controller;
use think\Controller;
use think\Exception;
class Base extends Controller{
	public function _initialize() {
    }



    protected function record($data){
    	
    	$data['create_time'] = time();
    	dump($data);
    	db('crontab_record')->insert($data);
    }
}	