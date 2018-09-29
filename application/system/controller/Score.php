<?php
namespace app\system\controller;
use app\system\controller\Base;
use think\Db;
/**
 * 补充积分和记录
 * @param  
 */
class Score extends Base{
 
    public function _initialize(){
    	parent::_initialize();
    }

   //每天执行平台收支记录数据
    public function dailyInOut(){
    	try{
            $date_str = date('Ymd',time());
            $setting = db('setting')->find();
            $score_rule = json_decode($setting['score_rule'],true);
            $map = ['can_settle_date'=>$date_str,'status'=>1,'is_settle'=>1];
            $scheduleList = db('schedule')->where($map)->whereNull('delete_time')->select();
	    	$data = ['crontab'=>'教练和学生上课积分赠送'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'教练和学生上课积分赠送','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }
    

    
}