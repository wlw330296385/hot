<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\MessageService;
use app\service\ScheduleService;
use think\Exception;

/**
* 课时表类
*/
class Schedule extends Base
{
	
	protected $ScheduleService;

	function _initialize()
	{
		parent::_initialize();
		$this->ScheduleService = new ScheduleService;
	}

	public function index(){
		echo  "11";

	}



	//判断录课冲突,规则:同一个训练营课程班级,在某个时间点左右2个小时之内只允许一条数据;
	public function recordScheduleClashApi(){
		try{
			$lesson_id = input('param.lesson_id');
			$lesson_time = input('param.lesson_time');
			$grade_id = input('param.grade_id');
			$camp_id = input('param.camp_id');
			$lesson_time = strtotime($lesson_time);		
			//前后2个小时
			$start_time = $lesson_time-7200;
			$end_time = $lesson_time+7200;
			$scheduleList = db('schedule')->where([
									'camp_id'=>$camp_id,
									'grade_id'=>$grade_id,
									'lesson_id'=>$lesson_id,
									'lesson_time'=>['BETWEEN',[$start_time,$end_time]]
									])->select();
		
			$result = 1;
			if(!$scheduleList){
				$result = 0;
			}else{
				foreach ($scheduleList as $key => $value) {
					if($value['lesson_time']>$start_time && $value['lesson_time']<$end_time){
						$result = 1;
					}
				}
			}

			return $result;
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}
	
	// 判断是否有录课权限|审核
	public function recordSchedulePowerApi(){
		try{
			// 只要是训练营的教练都可以跨训练营录课
			$camp_id = input('param.camp_id');
			$member_id = $this->memberInfo['id'];
			$result = $this->ScheduleService->isPower($camp_id,$member_id);
			return $result;
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}


	//课时审核
	public function recordScheduleCheckApi(){
		try{
			$camp_id = input('param.camp_id');
			$isPower = $this->recordSchedulePowerApi();
			if($isPower <3){
				return json(['code'=>100,'msg'=>__lang('MSG_403')]);
			}
			$schedule_id = input('param.schedule_id');
			$result = db('schedule')->save(['status'=>1],$schedule_id);
			if($result){
				return json(['code'=>200,'msg'=>'审核成功']);
			}else{
				return json(['code'=>100,'msg'=>'审核失败']);
			}
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}


	// 录课Api
	public function recordScheduleApi(){
		try{
			$data = input('post.');
			$data['member_id'] = $this->memberInfo['id'];
			$data['member'] = $this->memberInfo['member'];
			$data['lesson_time'] = strtotime($data['lesson_time']);
			$data['student_str'] = serialize($data['studentList']);
			if (isset($data['expstudentList'])) {
                $data['expstudent_str'] = serialize($data['expstudentList']);
            }
			$result = $this->ScheduleService->createSchedule($data);
			return json($result);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}

	// 编辑课时Api
	public function updateScheduleApi(){
		try{
			$schedule_id = input('param.schedule_id');
			$data = input('post.');
			$data['member_id'] = $this->memberInfo['id'];
			$data['member'] = $this->memberInfo['member'];
			$data['lesson_time'] = strtotime($data['lesson_time']);
			$data['student_str'] = serialize($data['studentList']);
            if (isset($data['expstudentList'])) {
                $data['expstudent_str'] = serialize($data['expstudentList']);
            }
			$result = $this->ScheduleService->updateSchedule($data,$schedule_id);
			return json($result);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}

	}


	// 课时评分
	public function starScheduleApi(){
		try{
			$camp_id = input('param.camp_id');
			$is_power = $this->recordSchedulePowerApi();
			if($is_power >1){
				return json(['code'=>100,'msg'=>__lang('MSG_403')]);
			}
			$data = input('post.');
			$data['member_id'] = $this->memberInfo['id'];
			$data['member'] = $this->memberInfo['member'];
			$data['star'] = $data['attitude']+$data['profession']+$data['teaching_attitude']+$data['teaching_quality'];
			$result = $this->ScheduleService->starSchedule($data);
			if($result){
				return json(['code'=>200,'msg'=>'审核成功']);
			}else{
				return json(['code'=>100,'msg'=>'审核失败']);
			}
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
	}


	//获取列表有page
	public function getScheduleListByPageApi(){
		try{
			$map = input('post.');
			$result = $this->ScheduleService->getScheduleListByPage($map);
			return json(['code' => 200, 'msg'=> __lang('MSG_201'),'data'=>$result]);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
	}

	//获取教练的课时列表有page
	public function getScheduleListOfCoachByPageApi(){
		try{
			$coach_id = input('param.coach_id');
			$map = function ($query) use ($coach_id){
                $query->where(['schedule.coach_id'=>$coach_id])->whereOr('schedule.assistant_id','like',"%\"$coach_id\"%");
            };
			$result = $this->ScheduleService->getScheduleListByPage($map);
			return json(['code' => 200, 'msg'=> __lang('MSG_201'),'data'=>$result]);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
	}



	//获取开始时间和结束时间的列表带page
	public function getScheduleListBetweenTimeByPageApi(){
		try{
			$begin = input('param.begin');
			$end = input('param.end');
			$map = input('post.');
			$beginINT = strtotime($begin);
			$endINT = strtotime($end);
			$map['lesson_time'] = ['BETWEEN',[$beginINT,$endINT]];
			$result = $this->ScheduleService->getScheduleListByPage($map);
			return json(['code' => 200, 'msg'=> __lang('MSG_201'),'data'=>$result]);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
	}

	// 操作课时 设为已申/删除
	public function removeschedule() {
	    try {
            $scheduleid = input('scheduleid');
            $action = input('action');
            if (!$scheduleid || !$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }

            $scheduleS = new ScheduleService();
            $schedule = $scheduleS->getScheduleInfo(['id' => $scheduleid]);
            if (!$schedule) {
                return json(['code' => 100, 'msg' => '课时' . __lang('MSG_404')]);
            }
            //dump($schedule);
            if ($schedule['status'] != 0) {
                return ['code' => 100, 'msg' => '该课时记录已审核，不能操作了'];
            }

            if ($action == 'editstatus') {
                // 审核课时
                $res = $scheduleS->saveScheduleMember($scheduleid);
                return json($res);
//            if ($res) {
//                $response = ['code' => 200, 'msg' => __lang('MSG_200')];
//            } else {
//                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
//            }
//            return json($response);
            } else {
                $res = $scheduleS->delSchedule($scheduleid);
                if ($res) {
                    $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                } else {
                    $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                }
                return json($response);
            }
        }catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 发送课时结果消息给学员
    public function sendschedule() {
	    try {
            $scheduleid = input('scheduleid');
            $scheduleS = new ScheduleService();
            $members = $scheduleS->getScheduleStudentMemberList($scheduleid);
//            dump($members);
            $schedule = $scheduleS->getScheduleInfo(['id' => $scheduleid]);
//        dump($schedule);

            $templateData = [
                'title' => $schedule['grade'].'最新课时',
                'content' => '您参加的'.$schedule['camp'].'-'.$schedule['lesson'].'-'.$schedule['grade'].'班级 发布最新课时',
                'lesson_time' => date('Y-m-d H:i', $schedule['lesson_time']),
                'url' => url('frontend/schedule/scheduleinfo', ['schedule_id' => $schedule['id'], 'camp_id' => $schedule['camp_id']], '', true)
            ];
            //dump($templateData);
            $messageS = new MessageService();
            $res = $messageS->sendschedule($templateData, $members);
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
            return json($response);
        }catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 购买赠送课时
    public function buygift() {
	    try {
            $request = input('param.');
            $camp_id = $request['camp_id'];
            $camppower = getCampPower($camp_id, $this->memberInfo['id']);
            if ($camppower < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').'不能操作']);
            }
            $request['member_id'] = $this->memberInfo['id'];
            $request['member'] = $this->memberInfo['member'];
            $scheduleS = new ScheduleService();
            $res = $scheduleS->buygift($request);
            if ($res['code'] == 200) {
                // 更新课程赠送课时字段
                $updateLesson = db('lesson')->where('id', $request['lesson_id'])->setInc('resi_giftschedule', $request['quantity']);
                if (!$updateLesson) {
                    return json(['code' => 100, 'msg' => '更新课程赠送课时'.__lang('MSG_400')]);
                }
            }
            return json($res);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 购买赠送课时列表
    public function buygiftlist()  {
	    try {
            $camp_id = input('param.camp_id', 0);
            $page = input('param.page', 1);
            $scheduleS = new ScheduleService();
            $map['camp_id'] = $camp_id;
            $res = $scheduleS->buygiftpage($map, $page);
            return json($res);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 赠送课时给学员
    public function recordgift() {
	    try {
            $request = input('param.');
            $camp_id = $request['camp_id'];
            $camppower = getCampPower($camp_id, $this->memberInfo['id']);
            if ($camppower < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').'不能操作']);
            }
            $request['member_id'] = $this->memberInfo['id'];
            $request['member'] = $this->memberInfo['member'];
            $request['status'] = 1;
            if (!empty($request['studentList'])) {
                $request['student_str'] = serialize($request['studentList']);
            }

            $scheduleS = new ScheduleService();
            $res = $scheduleS->recordgift($request);
            return json($res);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 赠送课时列表
    public function giftlist() {
	    try {
            $camp_id = input('param.camp_id', 0);
            $page = input('param.page', 1);
            $scheduleS = new ScheduleService();
            $map['camp_id'] = $camp_id;
            $res = $scheduleS->giftpage($map, $page);
            return json($res);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}