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
    public function scheduleScore(){
    	try{
            $date_str = date('Ymd',time());
            $setting = db('setting')->find();
            $score_rule = json_decode($setting['score_rule'],true);
            $map = ['schedule_member.status'=>-1,'schedule_member.is_ccore'=>-1];
            $memberList = db('schedule_member')->field('schedule.students,schedule_member.*')->join('schedule','schedule.id = schedule_member.schedule_id')->where($map)->whereNull('delete_time')->select();
            $stduent_memebr_ids = [];
            $coach_member_ids = [];
            $coach_score = [];
            foreach ($memberList as $key => $value) {
                if($value['type']==1){
                    $stduent_memebr_ids[] = $value['member_id'];
                }else{
                    $coach_member_ids[] = $value['member_id'];
                    $
                }
            }

	    	$data = ['crontab'=>'教练和学生上课积分赠送'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'教练和学生上课积分赠送','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }
    

    
}