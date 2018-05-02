<?php
namespace app\system\controller;
use app\system\controller\Base;

class Dailysys extends Base{
 
    public function _initialize(){
    	parent::_initialize();
    }

   //每天执行平台收支记录数据
    public function dailyInOut(){
    	try{
            $date_str = date('Ymd',time());




	    	$data = ['crontab'=>'每日平台收支'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'每日平台收支','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }





    

    
}