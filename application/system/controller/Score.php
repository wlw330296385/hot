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
            $map = ['schedule_member.status'=>1,'schedule_member.is_score'=>0];
            $memberList = db('schedule_member')
            ->field('schedule.students,schedule_member.*')
            ->join('schedule','schedule.id = schedule_member.schedule_id')
            ->where($map)
            ->whereNull('schedule.delete_time')
            ->chunk(50,function($list){
                $stduent_memebr_ids = [];
                $score_rule_str = db('setting')->value('score_rule');
                $score_rule = json_decode($score_rule_str,true);
                $student_score = $score_rule['schedule_student'];
                $coach_score = $score_rule['schedule_coach'];
                foreach ($list as $key => $value) {
                    if($value['type']==1){
                        $stduent_memebr_ids[] = $value['member_id'];
                        db('score')->insert([
                            'member_id'=>$value['member_id'],
                            'member'=>$value['user'],
                            'score'=>$student_score,
                            'score_des'=>'上课送积分',
                            'create_time'=>time()
                        ]);
                    }else{
                        db('member')->where(['id'=>$value['member_id']])->inc('score',$value['students']*$coach_score)->update();
                        db('score')->insert([
                            'member_id'=>$value['member_id'],
                            'member'=>$value['user'],
                            'score'=>$value['students']*$coach_score,
                            'score_des'=>'授课送积分',
                            'create_time'=>time()
                        ]);
                    }
                }
                // 给学生加积分
                db('member')->where(['id'=>['in',$stduent_memebr_ids]])->inc('score',$student_score)->update();
                // sleep(5);
            },'schedule_member.id');
            
            db('schedule_member')->where(['status'=>1,'is_score'=>0])->update(['is_score'=>1]);
	    	$data = ['crontab'=>'教练和学生上课积分赠送'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'教练和学生上课积分赠送','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }
    

    
}