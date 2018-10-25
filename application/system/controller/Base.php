<?php 
namespace app\system\controller;
use think\Controller;
use think\Exception;
class Base extends Controller{
	public function _initialize() {
		if(request()->ip()!="127.0.0.1" || request()->ip()!="14.215.112.29"){
            echo "非法操作";exit(1);
        }
    }



    protected function record($data){
    	
    	$data['create_time'] = time();
    	$data['date_str'] = date('Y-m-d H:i:s',time());
    	db('crontab_record')->insert($data);
    }
}	