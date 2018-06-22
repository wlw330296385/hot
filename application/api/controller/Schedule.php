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
            $lesson_time_date = input('param.lesson_time_date');
            $grade_id = input('param.grade_id');
            $camp_id = input('param.camp_id');
            $lesson_time = strtotime($lesson_time_date);
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
            $schedule_id = input('param.schedule_id');
            if (!$schedule_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $schedule = db('schedule')->where(['id' => $schedule_id])->find();
            $isPower = $this->ScheduleService->isPower($schedule['camp_id'],$this->memberInfo['id']);
            if ($isPower < 3) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }
            if ($schedule['status'] != -1) {
                return ['code' => 100, 'msg' => '该课时记录已审核，不能操作了'];
            }
            // 课时学员名单
            $students = unserialize($schedule['student_str']);
            if($schedule['is_school'] == -1){
                // 课时结算方式的训练营 教练、训练营课时所得工资金额与平台抽取金额的总和不能大于课时收入金额（课时学员*课程单价）
                if ($schedule['rebate_type'] == 1) {
                    // 课时工资
                    $numScheduleStudent = count($students);
                    $lessonCost = $schedule['cost'];
                    $scheduleIncome = $lessonCost * $numScheduleStudent;
                    // 平台抽取金额：课时工资*抽取比例（注意训练营有单独的比例）
                    if (!empty($schedule['schedule_rebate'])) {
                        // 以训练营独有平台抽取比例
                        $scheduleRebate = ($schedule['schedule_rebate'] == 0) ? 0 : $schedule['schedule_rebate'];
                    } else {
                        $SystemS = new SystemService();
                        $setting = $SystemS::getSite();
                        $scheduleRebate = $setting['sysrebate'];
                    }
                    // 平台抽取金额
                    $systemExtractionAmount = $scheduleIncome * $scheduleRebate;
                    // 助教练（多个）底薪总
                    $assistantIncomeSum = 0;
                    $assistantCount = 0;
                    if (!empty($schedule['assistant'])) {
                        $assistantCount = count(unserialize($schedule['assistant']));
                        $assistantIncomeSum = $schedule['assistant_salary'] * $assistantCount;
                    }
                    // 课时工资提成
                    $pushSalary = $schedule['salary_base'] * $numScheduleStudent;
                    // 金额总和 = 主教练工资+副教练工资+平台抽成+教练提成;
                    $salaryInSum = $schedule['coach_salary'] + $assistantIncomeSum + $systemExtractionAmount + ($pushSalary*(1+$assistantCount));
                    if ( $salaryInSum > $scheduleIncome ) {
                        return json(['code' => 100, 'msg' => '课时支出给教练的工资超过课时收入，请修改信息']);
                    }
                }
                // 检查课时相关学员剩余课时
                $checkStudentRestscheduleResult = $this->ScheduleService->checkstudentRestschedule($schedule, $students);
                if ($checkStudentRestscheduleResult['code'] == 100) {
                    return json($checkStudentRestscheduleResult);
                }
            }
            //写入学生课时数据
            $res = $this->ScheduleService->saveScheduleMember($schedule,$students);
  
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }

    // 删除课时
    public function delScheduleApi(){
        try {
            $schedule_id = input('param.schedule_id');
            $schedule = $this->ScheduleService->getScheduleInfo(['id' => $schedule_id]);
            // 获取会员在训练营角色
            $power = getCampPower($schedule['camp_id'], $this->memberInfo['id']);
            if ($power < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').'不能操作']);
            }
            // 兼职教练不能操作
            if ($power == 2) {
                $level = getCampMemberLevel($schedule['camp_id'], $this->memberInfo['id']);
                if ($level == 1) {
                    return json(['code' => 100, 'msg' => __lang('MSG_403').',不能操作']);
                }
            }
            if ($schedule['status'] == 1) {
                return ['code' => 100, 'msg' => '该课时记录已过审核，不能删除'];
            }
            if ($schedule['is_settle'] == 1) {
                return ['code' => 100, 'msg' => '该课时记录已结算，不能删除'];
            }
            $res = $this->ScheduleService->delSchedule($schedule_id);
            if ($res) {
                db('schedule_member')->where(['schedule_id'=>$schedule_id])->delete();
                $response = ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
            return json($response);
        }catch(Exception $e){
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
            $data['lesson_time'] = strtotime($data['lesson_time_date']);
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
            $data['lesson_time'] = strtotime($data['lesson_time_date']);
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
            $canStar = $this->ScheduleService->canStarSchedule($request['schedule_id'], $this->memberInfo['id']);
            if (!$canStar) {
                return json(['code' => 100, 'msg' => '您不是此课时的上课学员，不能评论']);
            }
            $res = $this->ScheduleService->starSchedule($request);
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
            $commentlist = $this->ScheduleService->getCommentList($schedule_id);
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
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['grade|lesson|coach|assistant'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
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

    // // 操作课时 设为已申/删除
    // public function removeschedule()
    // {
    //     try {
    //         $schedule_id = input('schedule_id');
    //         $action = input('action');
    //         if (!$schedule_id || !$action) {
    //             return json(['code' => 100, 'msg' => __lang('MSG_402')]);
    //         }
    //         $schedule = db('schedule')->where(['id' => $schedule_id])->find();
    //         if (!$schedule) {
    //             return json(['code' => 100, 'msg' => '课时' . __lang('MSG_404')]);
    //         }
    //         // 获取会员在训练营角色
    //         $power = getCampPower($schedule['camp_id'], $this->memberInfo['id']);
    //         if ($power < 2) {
    //             return json(['code' => 100, 'msg' => __lang('MSG_403').'不能操作']);
    //         }
    //         // 兼职教练不能操作
    //         if ($power == 2) {
    //             $level = getCampMemberLevel($schedule['camp_id'], $this->memberInfo['id']);
    //             if ($level == 1) {
    //                 return json(['code' => 100, 'msg' => __lang('MSG_403').',不能操作']);
    //             }
    //         }


    //         if ($action == 'editstatus') {
    //             if ($schedule['status'] != -1) {
    //                 return ['code' => 100, 'msg' => '该课时记录已审核，不能操作了'];
    //             }
    //             // 审核课时
    //             // 课时学员名单
    //             $students = unserialize($schedule['student_str']);
    //             // 课时结算方式的训练营 教练、训练营课时所得工资金额与平台抽取金额的总和不能大于课时收入金额（课时学员*课程单价）
    //             $campInfo = db('camp')->where('id',$schedule['camp_id'])->whereNull('delete_time')->find();
    //             if ($campInfo['rebate_type'] == 1) {
    //                 // 课时工资
    //                 $numScheduleStudent = count($students);
    //                 $lessonCost = db('lesson')->where('id', $schedule['lesson_id'])->value('cost');
    //                 $scheduleIncome = $lessonCost * $numScheduleStudent;
    //                 // 平台抽取金额：课时工资*抽取比例（注意训练营有单独的比例）
    //                 if (!empty($campInfo['schedule_rebate'])) {
    //                     // 以训练营独有平台抽取比例
    //                     $scheduleRebate = ($campInfo['schedule_rebate'] == 0) ? 0 : $campInfo['schedule_rebate'];
    //                 } else {
    //                     $SystemS = new SystemService();
    //                     $setting = $SystemS::getSite();
    //                     $scheduleRebate = $setting['sysrebate'];
    //                 }
    //                 // 平台抽取金额
    //                 $systemExtractionAmount = $scheduleIncome * $scheduleRebate;
    //                 // 助教练（多个）底薪总
    //                 $assistantIncomeSum = 0;
    //                 if (!empty($schedule['assistant'])) {
    //                     $assistantCount = count(unserialize($schedule['assistant']));
    //                     $assistantIncomeSum = $schedule['assistant_salary'] * $assistantCount;
    //                 }
    //                 // 课时工资提成
    //                 $pushSalary = $schedule['salary_base'] * $numScheduleStudent;
    //                 // 金额总和大于课时收入金额，抛出提示
    //                 $salaryInSum = $schedule['coach_salary'] + $assistantIncomeSum + $systemExtractionAmount + $pushSalary;
    //                 if ( $salaryInSum > $scheduleIncome ) {
    //                     return json(['code' => 100, 'msg' => '课时支出给教练的工资超过课时收入，请修改信息']);
    //                 }
    //             }
    //             // 检查课时相关学员剩余课时
    //             $checkStudentRestscheduleResult = $this->ScheduleService->checkstudentRestschedule($schedule, $students);
    //             if ($checkStudentRestscheduleResult['code'] == 100) {
    //                 return json($checkStudentRestscheduleResult);
    //             }
    //             $res = $this->ScheduleService->saveScheduleMember($schedule, $students);
    //             return json($res);
    //         } else {
    //             if ($schedule['is_settle'] == 1) {
    //                 return ['code' => 100, 'msg' => '该课时记录已结算，不能删除'];
    //             }
    //             $res = $this->ScheduleService->delSchedule($schedule_id);
    //             if ($res) {
    //                 $response = ['code' => 200, 'msg' => __lang('MSG_200')];
    //             } else {
    //                 $response = ['code' => 100, 'msg' => __lang('MSG_400')];
    //             }
    //             return json($response);
    //         }
    //     } catch (Exception $e) {
    //         return json(['code' => 100, 'msg' => $e->getMessage()]);
    //     }
    // }

    // 发送课时结果消息给学员
    public function sendschedule()
    {
        try {
            $schedule_id = input('schedule_id');
            $this->ScheduleService = new ScheduleService();
            // 获取课时学员数据
            $this->ScheduleServicetudents = $this->ScheduleService->getScheduleStudentMemberList($schedule_id);

            // 获取课时数据
            $schedule = $this->ScheduleService->getScheduleInfo(['id' => $schedule_id]);

            // 推送消息组合
            // 推送消息接收会员member_ids集合
            $member_ids = [];
            if ($this->ScheduleServicetudents) {
                foreach ($this->ScheduleServicetudents as $k => $student) {
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
            $res = $this->ScheduleService->buygift($request);
            if ($res['code'] == 200) {
                // 更新课程赠送课时字段
                $updateLesson = db('lesson')->where('id', $request['lesson_id'])->inc('resi_giftschedule', $request['quantity'])->update();
                if (!$updateLesson) {
                    return json(['code' => 100, 'msg' => '更新课程赠送课时' . __lang('MSG_400')]);
                }
                // 扣除训练营的余额
                if($campInfo['rebate_type'] == 1){
                    db('camp')->where(['id'=>$camp_id])->dec('balance',$totalCost)->update();
                    db('output')->insert([
                        'camp'=>$campInfo['camp'],
                        'camp_id'=>$campInfo['id'],
                        'f_id'=>$res['insid'],
                        'type'=>1,
                        'create_time'=>time(),
                        'e_balance'=>($campInfo['balance']-$totalCost),
                        's_balance'=>$campInfo['balance'],
                        'rebate_type'=>$campInfo['rebate_type'],
                        'shcedule_rebate'=>$campInfo['shcedule_rebate'],
                        'output'=>$totalCost,
                        'member'=>$this->memberInfo['member'],
                        'member_id'=>$this->memberInfo['member_id']
                    ]);
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
            $this->ScheduleService = new ScheduleService();
            $map['camp_id'] = $camp_id;
            $res = $this->ScheduleService->buygiftpage($map, $page);
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
                    $lessonMemberMap['camp_id'] = $request['camp_id'];
                    $studentIDs = [];
                    $lessonMemberMap['lesson_id'] = $request['lesson_id'];
                    foreach ($studentList as $k => $student) {
                        
                        $studentIDs[] = $student['student_id'];
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

                    $lessonMemberMap['student_id'] = ['in',$studentIDs];
                    $studentMap = ['id'=>['in',$studentIDs]];
                    $saveStudentRestschedule = $this->ScheduleService->saveStudentRestschedule($lessonMemberMap, $request['gift_schedule'],$studentMap);
                    if (!$saveStudentRestschedule) {
                        return json(['code' => 100, 'msg' => '学员剩余课时更新' . $student['student'] . __lang('MSG_400')]);
                    }
                    // 保存赠课与学员关系记录
                    $billMap['student_id'] = ['in',$studentIDs];
                    $billMap['camp_id'] = $request['camp_id'];
                    $billMap['goods_id'] = $request['lesson_id'];
                    $billMap['status'] = 1;
                    $saveScheduleGiftStudentResult = $this->ScheduleService->saveAllScheduleGiftStudent($dataSaveScheduleGiftStudent,$billMap,$request['gift_schedule']);
                }
                $res = $this->ScheduleService->recordgift($request);
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
            $this->ScheduleService = new ScheduleService();
            $map['camp_id'] = $camp_id;
            $res = $this->ScheduleService->giftpage($map, $page);
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
            $this->ScheduleService = new ScheduleService();
            // 获取课时数据
            $scheduleInfo = $this->ScheduleService->getScheduleInfo(['id' => $schedule_id]);
            if (!$scheduleInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            //dump($scheduleInfo);
            // 课时学员名单
            if ($scheduleInfo['student_str']) {
                // 更新课时学员剩余课时+1、完成课时-1
                $this->ScheduleServicetudents = unserialize($scheduleInfo['student_str']);
                //dump($this->ScheduleServicetudents);
                $dataUpdateLessonMember = [];
                $dataUpdateStudent = [];
                $modelLessonMember = new \app\model\LessonMember();
                $modelStudent = new \app\model\Student();
                // 系统备注文字
                $systemRemarks = '|'.date('Ymd').'已申课时记录id:'. $schedule_id .'删除,补回剩余课时';
                foreach ($this->ScheduleServicetudents as $k => $student) {
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

    // 赠课记录-学员列表
    public function studentgiftschedulelist() {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            if ( input('?param.page') ) {
                unset($map['page']);
            }
            $res = $this->ScheduleService->getScheduleGiftStudentList($map, $page);
            if (!$res) {
                $response = ['code' => 100, 'msg'=> __lang('MSG_000'), 'data' => [], 'sum' => 0];
            } else {
                // 受赠课总数和
                $sum = $this->ScheduleService->getSchedleGiftStudentNumSum($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res, 'sum' => $sum];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 赠课记录-学员列表
    public function studentgiftschedulepage() {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            if ( input('?param.page') ) {
                unset($map['page']);
            }
            $res = $this->ScheduleService->getScheduleGiftStudentPagintor($map);
            if (!$res) {
                $response = ['code' => 100, 'msg'=> __lang('MSG_000'), 'data' => [], 'sum' => 0];
            } else {
                // 受赠课总数和
                $sum = $this->ScheduleService->getSchedleGiftStudentNumSum($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res, 'sum' => $sum];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}