<?php
namespace app\system\controller;
use app\system\controller\Base;

class Dailysys extends Base{
 
    public function _initialize(){
    	parent::_initialize();
    }

   //每月最后一天最后一分钟执行,如2018年3月29日23:59:00 ->每月1号00:00:00
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