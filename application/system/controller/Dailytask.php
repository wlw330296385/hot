<?php
namespace app\system\controller;
use app\system\controller\Base;
/**
 * 每日学生数\场地数
 * @param  
 */
class Dailytask extends Base{
 
    public function _initialize(){
    	parent::_initialize();
    }

   //每月最后一天最后一分钟执行,如2018年3月29日23:59:00 ->每月1号00:00:00
    public function dailyStudents(){
    	try{
    		$campList = db('camp')->where('delete_time',null)->select();
	    	$data = [];
            $date_str = date('Ymd',time());
            
	    	foreach ($campList as $key => $value) {
	    		$online_students = 0;
	    		$offline_students = 0;
	    		$onlesson_students = 0;
	    		$offlesson_students = 0;
	    		$refund_students = 0;
	    		$lessonMemberList = db('lesson_member')->where(['camp_id'=>$value['id'],'type'=>1])->where('delete_time',null)->group('student_id')->select();
	    		foreach ($lessonMemberList as $k => $val) {
	    			if($val['status'] == 1){//上课学生
	    				$onlesson_students++;
	    			}elseif ($val['status'] == 4) {//毕业学生
	    				$offlesson_students++;
	    			}elseif($val['status'] == -1){//离营学生
	    				$offline_students++;
	    			}elseif ($val['status'] == 2) {//退款学生
	    				$refund_students++;
	    			}elseif ($val['status'] == 3) {//被开除学生
	    				$offlesson_students++;
	    			}
	    			$online_students = $onlesson_students+$offlesson_students;
	    		}

	    		$data[] = [
	    			'camp'=>$value['camp'],
	    			'camp_id'=>$value['id'],
	    			'online_students'=>$online_students,
	    			'offline_students'=>$offline_students,
	    			'onlesson_students'=>$onlesson_students,
	    			'offlesson_students'=>$offlesson_students,
	    			'date_str'=>$date_str,
	    		];
	    	}
	    	$MonthlyStudents = new \app\model\MonthlyStudents;
	    	$MonthlyStudents->saveAll($data);
	    	$data = ['crontab'=>'每日学生流动'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'每日学生流动','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }



    // 每月学员训练点分布
    public function monthlyCourtStudents(){
    	try{
            $m = date('m',time());
            if($m == 01){
                $date_str = (date('Y',time())-1)*100+12;
            }else{
                $date_str = date('Ym',time())-1;
            }
    		$campList = db('camp')->where('delete_time',null)->select();
    		$CourtStudentData = [];
    		foreach ($campList as $key => $value) {
    			$gradeCourt = db('grade')->field('sum(students) as s_students,court,court_id')->where(['status'=>1,'camp_id'=>$value['id']])->group('court_id')->select();
    			foreach ($gradeCourt as $k => $val) {
    				$CourtStudentData[] = [
    					'camp'=>$value['camp'],
    					'camp_id'=>$value['id'],
    					'court'=>$val['court'],
    					'court_id'=>$val['court_id'],
    					'students'=>$val['s_students'],
    					'date_str'=>$date_str,
    				];
    			}
    		}
    		
    		$monthlyCourtStudent = new \app\model\monthlyCourtStudents;
	    	$monthlyCourtStudent->saveAll($CourtStudentData);
	    	$data = ['crontab'=>'每月学员训练点分布'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'每月学员训练点分布','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    }


    // 把过期时间的学生status设置为3,并且吞掉钱财,运行时间:每日05:05
    public function dropStudent(){
        try{
            $list = db('lesson_member')->join('camp','camp.id = ')->where(['lesson_member.expire'=>['lt',time()]])->select();
            if($list){
                db('lesson_member')->where(['expire'=>['lt',time()]])->update(['status'=>3,'system_remarks'=>"过期清除"]);

            }
            $data = ['crontab'=>'清除过期学生'];
            $this->record($data);
        }catch(Exception $e){
            $data = ['crontab'=>'清除过期学生','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
    }




    

    
}