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
            $result = $this->ScheduleService->getScheduleListByPage($map);
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    //获取教练的课时列表有page
    public function getScheduleListOfCoachByPageApi()
    {
        try {
            $coach_id = input('param.coach_id');
            $map = function ($query) use ($coach_id) {
                $query->where(['schedule.coach_id' => $coach_id])->whereOr('schedule.assistant_id', 'like', "%\"$coach_id\"%");
            };
            $result = $this->ScheduleService->getScheduleListByPage($map);
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
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
            $members = $scheduleS->getScheduleStudentMemberList($scheduleid);
//            dump($members);
            $schedule = $scheduleS->getScheduleInfo(['id' => $scheduleid]);
//        dump($schedule);

            $templateData = [
                'title' => $schedule['grade'] . '最新课时',
                'content' => '您参加的' . $schedule['camp'] . '-' . $schedule['lesson'] . '-' . $schedule['grade'] . '班级 发布最新课时',
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
}