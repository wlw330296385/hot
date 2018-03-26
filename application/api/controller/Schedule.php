<?php

namespace app\api\controller;

use app\api\controller\Base;
use app\service\MessageService;
use app\service\ScheduleService;
use think\Db;
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

    //判断录课冲突,规则:同一个训练营课程班级,在某个时间点左右2个小时之内只允许一条数据;
    public function recordScheduleClashApi()
    {
        try {
            $lesson_id = input('param.lesson_id');
            $lesson_time = input('param.lesson_time');
            $grade_id = input('param.grade_id');
            $camp_id = input('param.camp_id');
            $lesson_time = strtotime($lesson_time);
            //前后2个小时
            $start_time = $lesson_time - 7200;
            $end_time = $lesson_time + 7200;
            $model = new \app\model\Schedule();
            $scheduleList = $model->where([
                'camp_id' => $camp_id,
                'grade_id' => $grade_id,
                'lesson_id' => $lesson_id,
                'lesson_time' => ['BETWEEN', [$start_time, $end_time]]
            ])->select()->toArray();

            $result = 1;
            if (!$scheduleList) {
                $result = 0;
            } else {
                foreach ($scheduleList as $key => $value) {
                    if ($value['lesson_time'] > $start_time && $value['lesson_time'] < $end_time) {
                        $result = 1;
                    }
                }
            }

            return $result;
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }

    // 判断是否有录课权限|审核
    public function recordSchedulePowerApi()
    {
        try {
            // 只要是训练营的教练都可以跨训练营录课
            $camp_id = input('param.camp_id');
            $member_id = $this->memberInfo['id'];
            $result = $this->ScheduleService->isPower($camp_id, $member_id);
            return $result;
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }


    //课时审核
    public function recordScheduleCheckApi()
    {
        try {
            $camp_id = input('param.camp_id');
            $isPower = $this->recordSchedulePowerApi();
            if ($isPower < 3) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }
            $schedule_id = input('param.schedule_id');
            $result = db('schedule')->save(['status' => 1], $schedule_id);
            if ($result) {
                return json(['code' => 200, 'msg' => '审核成功']);
            } else {
                return json(['code' => 100, 'msg' => '审核失败']);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }


    // 录课Api
    public function recordScheduleApi()
    {
        try {
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['lesson_time'] = strtotime($data['lesson_time']);
            $data['student_str'] = serialize($data['studentList']);
            if (isset($data['expstudentList'])) {
                $data['expstudent_str'] = serialize($data['expstudentList']);
            }
            // 训练时间不能大于当前时间
            if ($data['lesson_time'] > time()) {
                return json(['code' => 100, 'msg' => '训练时间不能大于当前时间']);
            }

            $result = $this->ScheduleService->createSchedule($data);
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }

    // 编辑课时Api
    public function updateScheduleApi()
    {
        try {
            $schedule_id = input('param.schedule_id');
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['lesson_time'] = strtotime($data['lesson_time']);
            $data['student_str'] = serialize($data['studentList']);
            if (isset($data['expstudentList'])) {
                $data['expstudent_str'] = serialize($data['expstudentList']);
            }
            
            // 训练时间不能大于当前时间
            if ($data['lesson_time'] > time()) {
                return json(['code' => 100, 'msg' => '训练时间不能大于当前时间']);
            }

            $result = $this->ScheduleService->updateSchedule($data, $schedule_id);
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }


    // 创建课时评分
    public function starScheduleApi()
    {
        try {
            $request = input('param.');
            $request['score_item1'] = ($request['score_item1'] == 0) ? 5 : $request['score_item1'];
            $request['score_item2'] = ($request['score_item2'] == 0) ? 5 : $request['score_item2'];
            $request['score_item3'] = ($request['score_item3'] == 0) ? 5 : $request['score_item3'];
            $request['score_item4'] = ($request['score_item4'] == 0) ? 5 : $request['score_item4'];
            $request['star'] = $request['score_item1']+$request['score_item2']+$request['score_item3']+$request['score_item4'];
            $request['avg_star'] = ceil($request['star']/4);
            $request['member_id'] = $this->memberInfo['id'];
            $request['member'] = $this->memberInfo['member'];
            $request['anonymous'] = 1;
            $request['member_avatar'] = $this->memberInfo['avatar'];
//            dump($request);
            $scheduleS = new ScheduleService();
            $canStar = $scheduleS->canStarSchedule($request['schedule_id'], $this->memberInfo['id']);
            if (!$canStar) {
                return json(['code' => 100, 'msg' => '您不是此课时的上课学员，不能评论']);
            }
            $res = $scheduleS->starSchedule($request);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 课时评价列表
    public function scheduleCommentList() {
        try {
            $schedule_id = input('param.schedule_id', 0);
            if (!$schedule_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            //$page = input('param.page', 1);
            $scheduleS = new ScheduleService();
            $commentlist = $scheduleS->getCommentList($schedule_id);
            if ($commentlist) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $commentlist];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    //获取列表有page
    public function getScheduleListByPageApi()
    {
        try {
            $map = input('post.');
            if(isset($map['grade_id'])){
                $map['grade_id'] = json_decode($map['grade_id']);
            }
            if(isset($map['grade_id']) && is_array($map['grade_id'])) {
                $map['grade_id'] = ['in',$map['grade_id']];
            }
            $result = $this->ScheduleService->getScheduleListByPage($map, 'lesson_time desc');
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    //获取教练的课时列表有page
    public function getScheduleListOfCoachByPageApi()
    {
        try {
            $map = input('post.');
            $y = input('param.y');
            $m = input('param.m');
            $d = input('param.d');
            $coach_id = input('param.coach_id');
            unset($map['coach_id']);
            if($y&&$m){
                $betweenTime = getStartAndEndUnixTimestamp($y,$m);
                $map['lesson_time'] = ['BETWEEN',[$betweenTime['start'],$betweenTime['end']]];
            }
            $mapAnd = function ($query) use ($map,$coach_id) {
                $query->where($map)->where('schedule.assistant_id', 'like', "%\"$coach_id\"%");
            };

            $mapOr = function ($query) use ($map,$coach_id) {
                $query->where($map)->where(['schedule.coach_id'=>$coach_id]);
            };
            $Schedule = new \app\model\Schedule;
            $result = $Schedule->where($mapAnd)->whereOr($mapOr)->paginate(10);
            if($result){
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result->toArray()]);
            }else{
                return json(['code' => 100, 'msg' => '无数据','data'=>[]]);
            }
            
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    //获取开始时间和结束时间的列表带page
    public function getScheduleListBetweenTimeByPageApi()
    {
        try {
            $begin = input('param.begin');
            $end = input('param.end');
            $map = input('post.');
            $beginINT = strtotime($begin);
            $endINT = strtotime($end);
            $map['lesson_time'] = ['BETWEEN', [$beginINT, $endINT]];
            $result = $this->ScheduleService->getScheduleListByPage($map);
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 操作课时 设为已申/删除
    public function removeschedule()
    {
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
            // 获取会员在训练营角色
            $power = getCampPower($schedule['camp_id'], $this->memberInfo['id']);
            if ($power < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').'不能操作']);
            }
            // 兼职教练不能审课
            if ($power == 2) {
                $level = getCampMemberLevel($schedule['camp_id'], $this->memberInfo['id']);
                if ($level == 1) {
                    return json(['code' => 100, 'msg' => __lang('MSG_403').'不能操作']);
                }
            }

            if ($schedule['status'] != -1) {
                return ['code' => 100, 'msg' => '该课时记录已审核，不能操作了'];
            }

            if ($action == 'editstatus') {
                // 审核课时
                $res = $scheduleS->saveScheduleMember($scheduleid);
                return json($res);
            } else {
                if ($schedule['status'] == 1) {
                    return ['code' => 100, 'msg' => '该课时记录已审核，不能删除'];
                }
                $res = $scheduleS->delSchedule($scheduleid);
                if ($res) {
                    $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                } else {
                    $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                }
                return json($response);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 发送课时结果消息给学员
    public function sendschedule()
    {
        try {
            $scheduleid = input('scheduleid');
            $scheduleS = new ScheduleService();
            // 获取课时学员数据
            $scheduleStudents = $scheduleS->getScheduleStudentMemberList($scheduleid);

            // 获取课时数据
            $schedule = $scheduleS->getScheduleInfo(['id' => $scheduleid]);

            // 推送消息组合
            // 推送消息接收会员member_ids集合
            $member_ids = [];
            if ($scheduleStudents) {
                foreach ($scheduleStudents as $k => $student) {
                    $member_ids[$k]['id'] = $student['student']['member_id'];
                }
            }
            /*$templateData = [
                'title' => $schedule['grade'] . '最新课时',
                'content' => '您参加的' . $schedule['camp'] . '-' . $schedule['lesson'] . '-' . $schedule['grade'] . '班级 发布最新课时',
                'lesson_time' => $schedule['lesson_time'],
                'url' => url('frontend/schedule/scheduleinfo', ['schedule_id' => $schedule['id'], 'camp_id' => $schedule['camp_id']], '', true)
            ];*/
            $templateData = [
                'title' => $schedule['grade'] . '最新课时',
                'content' => '您参加的' . $schedule['camp'] . '-' . $schedule['lesson'] . '-' . $schedule['grade'] . '班级 发布最新课时',
                'url' => url('frontend/schedule/scheduleinfo', ['schedule_id' => $schedule['id'], 'camp_id' => $schedule['camp_id']], '', true),
                'keyword1' => $schedule['grade'] . '最新课时',
                'keyword2' => $schedule['lesson_time'],
                'remark' => '点击进入查看详细，如有疑问可进行留言'
            ];
            $messageS = new MessageService();
            $res = $messageS->sendMessageToMembers($member_ids, $templateData, config('wxTemplateID.sendSchedule'));
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 购买赠送课时
    public function buygift()
    {
        try {
            $request = input('param.');
            $camp_id = $request['camp_id'];
            $camppower = getCampPower($camp_id, $this->memberInfo['id']);
            if ($camppower < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403') . '不能操作']);
            }
            $lessonInfo =  db('lesson')->where(['id'=>$request['lesson_id']])->find();
            if(!$lessonInfo){
                return json(['code' => 100, 'msg' =>'找不到课程信息']);
            }
            $totalCost = $request['quantity'] * $lessonInfo['cost'];
            $campInfo = db('camp')->where(['id'=>$camp_id])->find();
            if($campInfo['balance_true']<$totalCost){
                return json(['code' => 100, 'msg' =>'训练营余额不足']);
            }
            $request['member_id'] = $this->memberInfo['id'];
            $request['member'] = $this->memberInfo['member'];
            $scheduleS = new ScheduleService();
            $res = $scheduleS->buygift($request);
            if ($res['code'] == 200) {
                // 更新课程赠送课时字段
                $updateLesson = db('lesson')->where('id', $request['lesson_id'])->setInc('resi_giftschedule', $request['quantity']);
                if (!$updateLesson) {
                    return json(['code' => 100, 'msg' => '更新课程赠送课时' . __lang('MSG_400')]);
                }
                // 扣除训练营的余额
                db('camp')->where(['id'=>$camp_id])->dec('balance_true',$totalCost)->updaet();
            }
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 购买赠送课时列表
    public function buygiftlist()
    {
        try {
            $camp_id = input('param.camp_id', 0);
            $page = input('param.page', 1);
            $scheduleS = new ScheduleService();
            $map['camp_id'] = $camp_id;
            $res = $scheduleS->buygiftpage($map, $page);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 赠送课时给学员
    public function recordgift()
    {
        try {
            $request = input('param.');
            $camp_id = $request['camp_id'];
            $camppower = getCampPower($camp_id, $this->memberInfo['id']);
            if ($camppower < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403') . '不能操作']);
            }
            $request['member_id'] = $this->memberInfo['id'];
            $request['member'] = $this->memberInfo['member'];
            $request['status'] = 1;
            $scheduleS = new ScheduleService();
            $numChangegiftschedule = $request['gift_schedule'] * $request['student_num'];
            $lessonDb = Db::name('lesson');
            $lesson = $lessonDb->where('id', $request['lesson_id'])->find();
            if ($lesson['resi_giftschedule'] < $numChangegiftschedule) {
                return json(['code' => 100, 'msg' => '课程剩余赠送数量不足，点击"购买课量"进入购买']);
            } else {
                //学员剩余课时更新
                if (!empty($request['student_str'])) {
                    $studentList = json_decode($request['student_str'], true);
                    //dump($studentList);
                    $lessonMemberMap = [];
                    $dataSaveScheduleGiftStudent = [];
                    foreach ($studentList as $k => $student) {
                        $lessonMemberMap['camp_id'] = $request['camp_id'];
                        $lessonMemberMap['student_id'] = $student['student_id'];
                        $lessonMemberMap['lesson_id'] = $request['lesson_id'];
                        $saveStudentRestschedule = $scheduleS->saveStudentRestschedule($lessonMemberMap, $request['gift_schedule']);
                        if (!$saveStudentRestschedule) {
                            return json(['code' => 100, 'msg' => '学员剩余课时更新' . $student['student'] . __lang('MSG_400')]);
                        }
                        $dataSaveScheduleGiftStudent[$k] = [
                            'member' => $this->memberInfo['member'],
                            'member_id' => $this->memberInfo['id'],
                            'student' => $student['student'],
                            'student_id' => $student['student_id'],
                            'lesson_id' => $request['lesson_id'],
                            'lesson' => $request['lesson'],
                            'camp' => $request['camp'],
                            'camp_id' => $request['camp_id'],
                            'grade_id' => isset($request['grade_id']) ? $request['grade_id'] : 0,
                            'grade' => isset($request['grade']) ? $request['grade'] : '',
                            'gift_schedule' => $request['gift_schedule'],
                            'status' => 1
                        ];
                    }
                    // 保存赠课与学员关系记录
                    $saveScheduleGiftStudentResult = $scheduleS->saveAllScheduleGiftStudent($dataSaveScheduleGiftStudent);
                }
                $res = $scheduleS->recordgift($request);
                if (!$res) {
                    $response = json(['code' => 100, 'msg' => '赠送课时' . __lang('MSG_400')]);
                } else {
                    // 课程赠送课程更新
                    $updateLesson = $lessonDb->where('id', $request['lesson_id'])
                        ->inc('total_giftschedule', $numChangegiftschedule)
                        ->dec('resi_giftschedule', $numChangegiftschedule)
                        ->inc('unbalanced_giftschedule', $numChangegiftschedule)
                        ->update();
                    if (!$updateLesson) {
                        return json(['code' => 100, 'msg' => '更新课时信息' . __lang('MSG_400')]);
                    }
                    $response = json(['code' => 200, 'msg' => '赠送课时' . __lang('MSG_200')]);
                }
                return $response;
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 赠送课时列表
    public function giftlist()
    {
        try {
            $camp_id = input('param.camp_id', 0);
            $page = input('param.page', 1);
            $scheduleS = new ScheduleService();
            $map['camp_id'] = $camp_id;
            $res = $scheduleS->giftpage($map, $page);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 2018-01-26 删除已申课时
    public function delcheckedschedule() {
        try {
            // 接收请求变量
            $schedule_id = input('param.schedule_id');
            if (!isset($schedule_id)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $scheduleS = new ScheduleService();
            // 获取课时数据
            $scheduleInfo = $scheduleS->getScheduleInfo(['id' => $schedule_id]);
            if (!$scheduleInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            //dump($scheduleInfo);
            // 课时学员名单
            if ($scheduleInfo['student_str']) {
                // 更新课时学员剩余课时+1、完成课时-1
                $scheduleStudents = unserialize($scheduleInfo['student_str']);
                //dump($scheduleStudents);
                $dataUpdateLessonMember = [];
                $dataUpdateStudent = [];
                $modelLessonMember = new \app\model\LessonMember();
                $modelStudent = new \app\model\Student();
                // 系统备注文字
                $systemRemarks = '|'.date('Ymd').'已申课时记录id:'. $schedule_id .'删除,补回剩余课时';
                foreach ($scheduleStudents as $k => $student) {
                    // 获取课时学员的lesson_member数据
                    $studentLessonMember = $modelLessonMember->where(['student_id' => $student['student_id'], 'camp_id' => $scheduleInfo['camp_id'], 'lesson_id' => $scheduleInfo['lesson_id']])->find()->toArray();
                    //dump($studentLessonMember);
                    // 课时学员剩余课时+1 批量更新组合
                    $dataUpdateLessonMember[$k]['id'] = $studentLessonMember['id'];
                    $dataUpdateLessonMember[$k]['rest_schedule'] = $studentLessonMember['rest_schedule']+1;
                    $dataUpdateLessonMember[$k]['system_remarks'] = $studentLessonMember['system_remarks'].$systemRemarks;

                    // 获取课时学员的student数据
                    $studentInfo = $modelStudent->where(['id' => $student['student_id']])->find()->toArray();
                    $dataUpdateStudent[$k]['id'] = $studentInfo['id'];
                    $dataUpdateStudent[$k]['finished_schedule'] = $studentInfo['finished_schedule']-1;
                    $dataUpdateStudent[$k]['system_remarks'] = $studentInfo['system_remarks'].$systemRemarks;
                    // 课时学员完成课时-1 批量更新组合
                }
                //dump($dataUpdateLessonMember);
                //$resUpdateLessonMember = $modelLessonMember->saveAll($dataUpdateLessonMember);
                //$resUpdateStudent = $modelStudent->saveAll($dataUpdateStudent);
                // 更新课时学员剩余课时+1、完成课时-1 end
            }

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}