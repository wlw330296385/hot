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

            $list = db('lesson_member')->field('lesson_member.id,camp.schedule_rebate,camp.rebate_type,lesson_member.lesson,lesson.lesson,lesson_member.lesson_id,lesson.cost,camp.balance,lesson_member.rest_schedule,lesson_member.camp,lesson_member.camp_id,lesson_member.student_id,lesson_member.student,lesson_member.member,lesson_member.member_id')->join('camp','camp.id = lesson_member.camp_id')->join('lesson','lesson.id = lesson_member.lesson_id')->where(['lesson_member.expire'=>['between',[99999,time()]],'lesson_member.status'=>1])->select();

            $incomeData = [];
            $campFinanceData = [];
            if($list){
                
                db('lesson_member')->where(['lesson_member.expire'=>['between',[99999,time()]]])->update(['status'=>3,'system_remarks'=>"超过上课期限"]);
                //训练营财务
                foreach ($list as $key => $value) {
                    if($value['rebate_type'] == 1){
                        $incomeData[] = [
                            'schedule_rebate'   =>$value['schedule_rebate'],
                            'rebate_type'       =>$value['rebate_type'],
                            'students'          =>1,
                            'system_remarks'    =>'超过上课期限',
                            'date_str'          =>date('Ymd',time()),
                            's_balance'         =>$value['balance'],
                            'e_balance'         =>$value['balance'] + ($value['cost']*$value['rest_schedule']*(1-$value['schedule_rebate'])),
                            'f_id'              =>$value['id'],
                            'income'            =>$value['cost']*$value['rest_schedule']*(1-$value['schedule_rebate']),
                            'lesson_id'         =>$value['lesson_id'],
                            'lesson'            =>$value['lesson'],
                            'camp_id'           =>$value['camp_id'],
                            'camp'              =>$value['camp'],
                            'total'             =>$value['rest_schedule'],
                            'price'             =>$value['cost'],
                            'student_id'        =>$value['student_id'],
                            'student'           =>$value['student'],
                            'member_id'         =>$value['member_id'],
                            'member'            =>$value['member'],
                            'type'              =>6,
                        ];
                        $campFinanceData[] = [
                            'schedule_rebate'   =>$value['schedule_rebate'],
                            'rebate_type'       =>$value['rebate_type'],
                            'system_remarks'    =>'超过上课期限',
                            'date_str'          =>date('Ymd',time()),
                            's_balance'         =>$value['balance'],
                            'e_balance'         =>$value['balance'] + ($value['cost']*$value['rest_schedule']*(1-$value['schedule_rebate'])),
                            'f_id'              =>$value['id'],
                            'money'             =>$value['cost']*$value['rest_schedule']*(1-$value['schedule_rebate']),
                            'camp_id'           =>$value['camp_id'],
                            'camp'              =>$value['camp'],
                            'type'              =>6,
                        ];

                    }
                }

                if(!empty($campFinanceData) && !empty($incomeData)){
                    $Income = new \app\model\Income;
                    $CampFinance = new \app\model\CampFinance;
                    $Camp = new \app\model\Camp;
                    $Income->saveAll($incomeData);
                    $CampFinance->saveAll($campFinanceData);
                    foreach ($campFinanceData as $key => $value) {

                        $Camp->where(['id'=>$value['camp_id']])->inc('balance',$value['money'])->update();
                    }
                }
            }
            $data = ['crontab'=>'清除过期学生'];
            $this->record($data);
        }catch(Exception $e){
            $data = ['crontab'=>'清除过期学生','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
    }



    // 发送学生过期提醒模板消息给家长
    public function sendMessageToParents(){
        try {
            $messageData = [
                'touser'=>'',
                'template_id'=>"squ4uaAVXJ52Dhfjtlol08cpo49FonbFwN",
                'url'=>url('frontend/student/studentinfoofcamp',['type'=>1,'student_id'=>1,'camp_id'=>1],'',true),
                'topcolor'=>"#FF0000",
                'data'=>
                    'first'=> ['value'=>"您好，您所报的（{$value['lesson']}即将过期,仍剩余$value['rest_schedule']节课,联系训练营管理员处理"],
                    'keyword1'=>['value': $total_schedule],
                    'keyword2'=> ['value': ($total_schedule - $rest_schedule)],
                    'keyword3'=> ['value': $rest_schedule] ,
                    'remark'=>['value'=>'篮球管家'] ,
                ];
            $saveData = [
                'title'=>'课时即将过期提醒',
                'content'=>"您好，您所报的（{$value['lesson']}即将过期,仍剩余$value['rest_schedule']节课,联系训练营管理员处理",
                'url'=>url('frontend/student/studentinfoofcamp',['type'=>1,'student_id'=>1,'camp_id'=>1],'',true),
                'member_id': $value['member_id']
            ];


            $data = ['crontab'=>'发送学生过期提醒模板消息给家长'];
            $this->record($data);
        } catch (Exception $e) {
            $data = ['crontab'=>'发送学生过期提醒模板消息给家长','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
    }

    
}