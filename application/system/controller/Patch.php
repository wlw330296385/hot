<?php
// 数据补丁
namespace app\system\controller;


use app\model\Apply;
use app\model\Bill;
use app\model\CampFinance;
use app\model\Follow;
use app\model\LessonMember;
use app\model\Schedule;
use app\model\ScheduleGiftStudent;
use app\model\ScheduleMember;
use app\model\Student;
use app\model\Coach;
use app\model\Rebate;
use app\service\MemberService;
use app\service\SystemService;
use app\service\WechatService;
use think\Controller;
use think\Db;
use think\Exception;

class Patch extends Controller {
    public $setting;
    public function _initialize() {
        $SystemS = new SystemService();
        $this->setting = $SystemS::getSite();
    }

    // 重新统计学员剩余课时
    public function countstudentrestschedule() {
        // 遍历lesson_member数据
        $modelLessonMember = new LessonMember();
        $modelBill = new Bill();
        $modelScheduleGiftStudent = new ScheduleGiftStudent();
        $modelScheduleMember = new ScheduleMember();
        $modelStudent = new Student();
        $lessonmembers = $modelLessonMember->order('id desc')->select();
        //dump($lessonmembers);
        $dataLessonMemberSaveAll = [];
        $dataStudentSaveAll = [];
        foreach ($lessonmembers as $k => $lessonmember) {
            //dump($lessonmember);
            // 学员购买课程
            $buylessonum = $modelBill->where(['goods_type' => 1, 'is_pay' => 1, 'status' => 1, 'student_id' => $lessonmember['student_id']])->distinct(true)->field('goods')->count();
            //dump($lessonmember['student_id'].'---'.$buylessonum);
            
            // 学员总课时统计
            // 学员课程订单购买课时数
            $buyschedulenum = $modelBill->where(['camp_id' => $lessonmember['camp_id'], 'goods_id' => $lessonmember['lesson_id'], 'student_id' => $lessonmember['student_id'], 'is_pay' => 1, 'status' => 1 ])->sum('total');
            if (!$buyschedulenum) { $buyschedulenum = 0 ;}
            //dump($buyschedulenum);
            // 学员课程赠课数
            $giftschedulenum = $modelScheduleGiftStudent->where(['camp_id' => $lessonmember['camp_id'], 'lesson_id' => $lessonmember['lesson_id'], 'student_id' => $lessonmember['student_id'], 'status' => 1 ])->sum('gift_schedule');
            if (!$giftschedulenum) { $giftschedulenum = 0; }
            //dump($giftschedulenum);
            $total_schedule = $buyschedulenum+$giftschedulenum;
            //dump($total_schedule);

            // 学员剩余课时统计
            // 已上课课时数
            $schedulenum = $modelScheduleMember->where(['camp_id' => $lessonmember['camp_id'], 'type' => 1, 'user_id' => $lessonmember['student_id']])->count();
            $restschedulenum = 0;
            // 没有课时记录 剩余课时数为学员总课时数
            if ($schedulenum) {
                $restschedulenum = $total_schedule-$schedulenum;
            } else {
                $restschedulenum = $total_schedule;
            }
            //dump($schedulenum);
            
            // 组合批量保存数据数组
            $dataLessonMemberSaveAll[$k] = [
                'id' => $lessonmember['id'],
                'rest_schedule' => $restschedulenum,
                'total_schedule' => $total_schedule
            ];
            $dataStudentSaveAll[$k] = [
                'id' => $lessonmember['student_id'],
                'total_schedule' => $total_schedule,
                'finished_schedule' => $schedulenum,
                'total_lesson' => $buylessonum
            ];
        }
        //dump($dataLessonMemberSaveAll);
//        dump($dataStudentSaveAll);
        $res1 = $modelLessonMember->saveAll($dataLessonMemberSaveAll);
        $res2 = $modelStudent->saveAll($dataStudentSaveAll);
        if ($res1 && $res2) {
            echo 'ok';
        }
    }

    // 重新结算训练营课时工资收入
    public function countschedulesalaryin() {
        // 重置所有会员余额
        db('member')->whereNull('delete_time')->update(['balance' => 0]);
        $campFinanceModel = new CampFinance();
        // 遍历所有已审核课时
        $where['status'] = 1;
        $where['is_settle'] = 1;
        //$where['is_settle'] = 0;
        //$where['update_time'] = ['<', 1516723200];
        $schedules = DB::name('schedule')->where($where)->whereNull('delete_time')->chunk(50, function($schedules) {
            // 10月时间区间
            $month10 = getStartAndEndUnixTimestamp(2017, 10);
            // 11月时间区间
            $month11 = getStartAndEndUnixTimestamp(2017, 11);
            // 12月时间区间
            $month12 = getStartAndEndUnixTimestamp(2017,12);
            foreach ($schedules as $k => $schedule) {
                //dump('课时记录'.$schedule);
                dump('课时记录 grade:'.$schedule['grade'].'camp_id:'.$schedule['camp_id'].'lesson_time:'.date('Y-m-d H:i', $schedule['lesson_time']));
                // 获取课时的课程信息
                $lesson = db('lesson')->where('id', $schedule['lesson_id'])->whereNull('delete_time')->find();
                // 获取课时的班级信息
                $grade = db('grade')->where('id', $schedule['grade_id'])->whereNull('delete_time')->find();

                // 课时上课的正式学员人数
                $numScheduleStudent = count(unserialize($schedule['student_str']));

                // 抵扣赠送课时数
                $numGiftSchedule=0;
                $systemRemarks = '';
                //if ($lesson['unbalanced_giftschedule'] > 0) {
                // 查询在课时月份有无增记录
                $scheduleMonth = getStartAndEndUnixTimestamp(date('Y', $schedule['lesson_time']), date('m', $schedule['lesson_time']));
                $schedulegiftrecord = db('schedule_giftrecord')->whereNull('delete_time')
                    ->where([
                        'lesson_id' => $schedule['lesson_id'],
                        'create_time' => ['between', [ $scheduleMonth['start'], $scheduleMonth['end'] ]]
                    ])->sum('student_num*gift_schedule');
                if ($schedulegiftrecord) {
                    // 课程有未结算赠课数,  抵扣赠课课时：上课正式学员人数/2取整
                    $numGiftSchedule = ceil($numScheduleStudent/2);
                    if ($lesson['unbalanced_giftschedule'] > $numGiftSchedule) {
                        //db('lesson')->where('id', $schedule['lesson_id'])->setDec('unbalanced_giftschedule', $numGiftSchedule);
                        $systemRemarks = $lesson['lesson'].'抵扣赠课数：'.$numGiftSchedule;
                    } else {
                        $numGiftSchedule = 0;
                    }
                }
                //}

                // 课时工资收入
                $incomeSchedule = ($lesson['cost'] * ($numScheduleStudent-$numGiftSchedule));
                dump('课时工资收入'.$incomeSchedule);
                // 课时工资提成
                //$pushSalary = $schedule['salary_base']*$numScheduleStudent;
                $pushSalary = $schedule['salary_base']*$numScheduleStudent;
                dump('学生人数提成'.$pushSalary);


                // 获取课时主教练信息
                $coachMember = $this->getCoachMember($schedule['coach_id']);
                //dump($coachMember);
                // 课时主教练工资
                $incomeCoach = [
                    'salary' => $schedule['coach_salary'],
                    'push_salary' => $pushSalary,
                    'member_id' => $coachMember['member']['id'],
                    'member' => $coachMember['member']['member'],
                    'realname' => $coachMember['coach'],
                    'member_type' => 4,
                    'pid' => $coachMember['member']['pid'],
                    'level' => $coachMember['member']['level'],
                    'schedule_id' => $schedule['id'],
                    'lesson_id' => $schedule['lesson_id'],
                    'lesson' => $schedule['lesson'],
                    'grade_id' => $schedule['grade_id'],
                    'grade' => $schedule['grade'],
                    'camp_id' => $schedule['camp_id'],
                    'camp' => $schedule['camp'],
                    'schedule_time' => $schedule['lesson_time'],
                    'status' => 1,
                    'type' => 1,
                    'create_time' => $schedule['lesson_time'],
                ];
                dump('课时主教练工资'.$schedule['coach_salary'].'+'.$pushSalary);
                $this->insertSalaryIn($incomeCoach);


                // 课时助教工资
                $incomeAssistant = [];
                if (!empty($schedule['assistant_id']) && $schedule['assistant_salary'] ) {
                    $assistantMember = $this->getAssistantMember($schedule['assistant_id']);
                    foreach ($assistantMember as $k2 => $val) {
                        $incomeAssistant[$k2] = [
                            'salary' => $schedule['assistant_salary'],
                            'push_salary' => $pushSalary,
                            'member_id' => $val['member']['id'],
                            'member' => $val['member']['member'],
                            'realname' => $val['coach'],
                            'member_type' => 3,
                            'pid' => $val['member']['pid'],
                            'level' => $val['member']['level'],
                            'schedule_id' => $schedule['id'],
                            'lesson_id' => $schedule['lesson_id'],
                            'lesson' => $schedule['lesson'],
                            'grade_id' => $schedule['grade_id'],
                            'grade' => $schedule['grade'],
                            'camp_id' => $schedule['camp_id'],
                            'camp' => $schedule['camp'],
                            'schedule_time' => $schedule['lesson_time'],
                            'status' => 1,
                            'type' => 1,
                            'create_time' => $schedule['lesson_time'],
                        ];
                    }
                    dump('课时助教工资'.$schedule['assistant_salary'].'+'.$pushSalary);
                    $this->insertSalaryIn($incomeAssistant, 1);
                }

                // 10月、11月、12月 训练收入特别比例
                // camp_id 15钟声 13安凯训练营
                // 收入比例：默认平台抽取10%；
                $incomeRebate = 1-$this->setting['sysrebate'];
                // 大热训练营分成收入比例
                $incomeRebateCampId9 =0;
                if ($schedule['lesson_time'] > $month10['start'] && $schedule['lesson_time'] < $month10['end']) {
                    if ($schedule['camp_id'] == 15) {
                        $incomeRebate = 0.7;
                    } else if ($schedule['camp_id'] == 13) {
                        $incomeRebate = 0.7;
                    }
                    $incomeRebateCampId9 = 0.2;
                }
                if ($schedule['lesson_time'] > $month11['start'] && $schedule['lesson_time'] > $month11['end']) {
                    if ($schedule['camp_id'] == 15) {
                        $incomeRebate = 0.8;
                        $incomeRebateCampId9 = 0.1;
                    } else if ($schedule['camp_id'] == 13) {
                        $incomeRebate = 0.7;
                        $incomeRebateCampId9 = 0.2;
                    }
                }
                if ($schedule['lesson_time'] > $month12['start'] && $schedule['lesson_time'] > $month12['end']) {
                    if ($schedule['camp_id'] == 15) {
                        $incomeRebate = 0.8;
                        $incomeRebateCampId9 = 0.1;
                    } else if ($schedule['camp_id'] == 13) {
                        $incomeRebate = 0.7;
                        $incomeRebateCampId9 = 0.2;
                    }
                }

                // 训练营营主所得 课时收入*收入比例-主教底薪-助教底薪-学员人数提成*教练人数。教练人数 = 助教人数+1（1代表主教人数）
                $incomeCampSalary = $incomeSchedule*$incomeRebate-$schedule['coach_salary']-$schedule['assistant_salary']-($pushSalary*(count($incomeAssistant)+1));
                dump('训练营营主所得'.$incomeCampSalary);
                $campMember = $this->getCampMember($schedule['camp_id']);
                $incomeCamp = [
                    'salary' => $incomeCampSalary,
                    'push_salary' => 0,
                    'member_id' => $campMember['member_id'],
                    'member' => $campMember['member'],
                    'realname' => $campMember['realname'],
                    'member_type' => 5,
                    'pid' => $campMember['pid'],
                    'level' => $campMember['level'],
                    'schedule_id' => $schedule['id'],
                    'lesson_id' => $schedule['lesson_id'],
                    'lesson' => $schedule['lesson'],
                    'grade_id' => $schedule['grade_id'],
                    'grade' => $schedule['grade'],
                    'camp_id' => $schedule['camp_id'],
                    'camp' => $schedule['camp'],
                    'schedule_time' => $schedule['lesson_time'],
                    'status' => 1,
                    'type' => 1,
                    'system_remarks' => $systemRemarks,
                    'create_time' => $schedule['lesson_time'],
                ];
                $this->insertSalaryIn($incomeCamp);
                Db::name('schedule')->where(['id' => $schedule['id']])->update([
                    //'update_time' => time(),
                    'schedule_income' => $incomeSchedule,
                    //'is_settle' => 1
                ]);

                // 大热训练营收入金额
                if ( $incomeRebateCampId9 > 0) {
                    $incomeCampId9 = $incomeSchedule*$incomeRebateCampId9;
                    //dump($incomeCampId9);
                    $campMember9 = $this->getCampMember(9);
                    $incomeCampCampId9 = [
                        'salary' => $incomeCampId9,
                        'push_salary' => 0,
                        'member_id' => $campMember9['member_id'],
                        'member' => $campMember9['member'],
                        'realname' => $campMember9['realname'],
                        'member_type' => 5,
                        'pid' => $campMember9['pid'],
                        'level' => $campMember9['level'],
                        'schedule_id' => $schedule['id'],
                        'lesson_id' => $schedule['lesson_id'],
                        'lesson' => $schedule['lesson'],
                        'grade_id' => $schedule['grade_id'],
                        'grade' => $schedule['grade'],
                        'camp_id' => $schedule['camp_id'],
                        'camp' => $schedule['camp'],
                        'schedule_time' => $schedule['lesson_time'],
                        'status' => 1,
                        'type' => 1,
                        'system_remarks' => $systemRemarks,
                        'create_time' => $schedule['lesson_time'],
                    ];
                    $this->insertSalaryIn($incomeCampCampId9);
                }

                // 保存训练营财务支出信息
                $dataCampFinance = [
                    'camp_id' => $schedule['camp_id'],
                    'camp' => $schedule['camp'],
                    'finance_type' => 2,
                    'schedule_salary' => $incomeSchedule,
                    'schedule_id' => $schedule['id'],
                    'date' => date('Ymd', $schedule['lesson_time']),
                    'datetime' => $schedule['lesson_time']
                ];
                $this->insertcampfinance($dataCampFinance);
                dump('==========');
            }
        });

    }

    // 统计训练营课程营业额
    public function countcamplessonturnover() {
        $billModel = new Bill();
        $bills = $billModel->where(['goods_type' => 1,'is_pay' => 1, 'status' => 1, 'balance_pay' => ['>', 0]])->order('id asc')->select()->toArray();
        //dump($bills);
        $dataSaveAllCampFinance = [];
        foreach ($bills as $k => $bill) {
            $daytime = strtotime($bill['create_time']);
            $dataSaveAllCampFinance[$k] = [
                'camp_id' => $bill['camp_id'],
                'camp' => $bill['camp'],
                'finance_type' => 1,
                'lesson_turnover' => $bill['balance_pay'],
                'bill_id' => $bill['id'],
                'date' => date('Ymd', $daytime),
                'datetime' => $daytime
            ];
        }
        $campFinanceModel = new CampFinance();
        $res = $campFinanceModel->saveAll($dataSaveAllCampFinance);
        if ($res) {
            echo 'ok';
        }
    }



    // 获取教练会员
    private function getCoachMember($coach_id) {
        $coachM = new Coach();
        $member = $coachM->with('member')->where(['id' => $coach_id])->find()->toArray();
        return $member;
    }

    // 获取营主会员
    private function getCampMember($camp_id) {
        $member = Db::view('member')
            ->view('camp', '*','camp.member_id=member.id')
            ->where(['camp.id' => $camp_id])
            ->order('camp.id desc')
            ->find();
        return $member;
    }

    // 获取助教会员
    private function getAssistantMember($assistant_id) {
        $assistants = unserialize($assistant_id);
        $member = [];
        $coachM = new Coach();
        foreach( $assistants as $k => $assistant ) {
            $member[$k] = $coachM->with('member')->where(['id' => $assistant])->find()->toArray();
        }
        return $member;
    }

    // 保存训练营财务记录
    private function insertcampfinance($data, $saveAll=0) {
        $model = new CampFinance();
        if ($saveAll == 1) {
            $model->allowField(true)->saveAll($data);
        } else {
            $model->allowField(true)->save($data);
        }
    }

    // 保存收入记录
    private function insertSalaryIn($data, $saveAll=0) {
        $model = new \app\model\SalaryIn();
        if ($saveAll == 1) {
            $execute = $model->allowField(true)->saveAll($data);
        } else {
            $execute = $model->allowField(true)->save($data);
        }
        if ($execute) {
            $memberDb = db('member');
            if ($saveAll ==1) {
                foreach ($data as $val) {
                    $memberDb->where('id', $val['member_id'])->setInc('balance', $val['salary']+$val['push_salary']);
                }
            } else {
                $memberDb->where('id', $data['member_id'])->setInc('balance', $data['salary']+$data['push_salary']);
            }
            file_put_contents(ROOT_PATH.'data/salaryin/'.date('Y-m-d',time()).'.txt', json_encode(['time'=>date('Y-m-d H:i:s',time()), 'success'=>$data], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND );
            return true;
        } else {
            file_put_contents(ROOT_PATH.'data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'error'=>$data], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND  );
            return false;
        }
    }


    // 遍历会员头像将链接头像保存至本地
    public function memberavatardownload() {
        try {
            $memberS = new MemberService();
            $wechatS = new WechatService();
            $members = db('member')->whereNull('delete_time')->where('avatar', 'neq', '/static/default/avatar.png')->where('avatar', 'neq', '/0')->select();
            //dump($members);
            foreach ($members as $k => $member) {
                //dump($member['openid']);
                $userinfo = $wechatS->getUserInfo($member['openid']);
                // dump($userinfo);
                if ($userinfo['subscribe']) {
                    $headimgurl = str_replace("http://", "https://", $userinfo['headimgurl']);
                    //$newAvatar = $memberS->downwxavatar($headimgurl);
                } else {
                    $newAvatar = '/static/default/avatar.png';
                }
                //dump($newAvatar);
                //dump($member['avatar']);
                //$newAvatar = $memberS->downwxavatar($member['avatar']);
                //db('member')->where('id', $member['id'])->update(['avatar' => $newAvatar]);
            }
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    // 遍历follow表 完善avatar字段数据
    public function followavatars() {
        try {
            $follows = db('follow')->select();
            $modelFollow = new Follow();
            //dump($follows);
            $updateData = [];
            foreach ($follows as $k => $follow) {
                // 被关注的会员头像
                if ($follow['type'] == 1) {
                    $member = db('member')->where('id', $follow['follow_id'])->find();
                    $updateData[$k]['follow_avatar'] = $member['avatar'];
                } else if ($follow['type'] == 4) {
                    // 被关注的球队logo
                    $team = db('team')->where('id', $follow['follow_id'])->find();
                    $updateData[$k]['follow_avatar'] = $team['logo'];
                }

                // 关注会员头像
                $fansMember = db('member')->where('id', $follow['member_id'])->find();
                if (!$fansMember) {
                    $updateData[$k]['delete_time'] = time();
                }
                $updateData[$k]['member_avatar'] =$fansMember['avatar'];
                $updateData[$k]['id']= $follow['id'];
                if ($follow['create_time'] === 0) {
                    $updateData[$k]['create_time'] = time();
                }
            }
            $result = $modelFollow->saveAll($updateData);
            dump($result);
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    // 遍历salary_in 产生会员推荐人分成收入
    public function salaryinrebate() {
        try {
            // 10月时间区间
            $month10 = getStartAndEndUnixTimestamp(2017, 10);
            // 11月时间区间
            $month11 = getStartAndEndUnixTimestamp(2017, 11);
            // 12月时间区间
            $month12 = getStartAndEndUnixTimestamp(2017,12);
            dump($month10);
            dump($month11);
            dump($month12);
            $map['status'] = 1;
            // 课时时间小于2018-1
            $map['schedule_time'] = ['<', 1514736000];
            $salaryins = DB::name('salary_in')->field("member_id, sum(salary)+sum(push_salary) as month_salary, FROM_UNIXTIME(`create_time`,'%Y%m') months")->where($map)->group('member_id, months')->where('delete_time', null)->select();
            //dump($salaryins);
            foreach ($salaryins as $salaryin) {
                if ($salaryin['month_salary'] >0 ) {
                    $res = $this->insertRebate($salaryin['member_id'], $salaryin['month_salary'], $salaryin['months']);
                    if (!$res) { continue; }
                }
            }
            DB::name('salary_in')->where($map)->update(['has_rebate' => 1]);
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    // 会员推荐分成收入统计
    public function rebatetomember() {
        try {
            $rebates = db('rebate')->field("member_id, sum(salary) as salary")->group("member_id")->whereNull('delete_time')->select();
            dump($rebates);
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    // 保存会员分成记录
    private function insertRebate($member_id, $salary, $datemonth) {
        $memberS = new MemberService();
        $model = new Rebate();
        $memberPiers = $memberS->getMemberPier($member_id);
        if (!empty($memberPiers)) {
            foreach ($memberPiers as $k => $memberPier) {
                if ($memberPier['tier']==1) {
                    $memberPiers[$k]['salary'] = $salary*$this->setting['rebate'];
                } elseif ($memberPier['tier']==2){
                    $memberPiers[$k]['salary'] = $salary*$this->setting['rebate2'];
                }
                $memberPiers[$k]['datemonth'] = $datemonth;
            }
            //dump($memberPiers);
            $execute = $model->allowField(true)->saveAll($memberPiers);
            if ($execute) {
                $memberDb = db('member');
                foreach ($memberPiers as $k => $member) {
                    //$memberDb->where('id', $member['member_id'])->setInc('balance', $member['salary']);
                }
                file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'success'=>$memberPiers], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND  );
                return true;
            } else {
                file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'error'=>$memberPiers], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND );
                return false;
            }
        }
    }

    // 补全schedule_member数据
    public function schedulemember() {
        try {
            $model = new ScheduleMember();
            $list = $model->select();
            $list = $list->toArray();
            $data = [];
            foreach ($list as $k => $val) {
                $scheduleInfo = db('schedule')->where('id', $val['schedule_id'])->find();
                $data[$k]['lesson_id'] = $scheduleInfo['lesson_id'];
                $data[$k]['lesson'] = $scheduleInfo['lesson'];
                $data[$k]['grade_id'] = $scheduleInfo['grade_id'];
                $data[$k]['grade'] = $scheduleInfo['grade'];
                $data[$k]['id'] = $val['id'];
            }
            $model->saveAll($data);
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    // 整理team_member_role数据表
    public function teammemberrole() {
        try {
            // 手动清空team_member_role数据
            // 生成领队type=6，队长type=3 数据
            db('team')->chunk(50, function($teams) {
               foreach ($teams as $team) {
                   if ($team['leader']) {
                       db('team_member_role')->insert([
                           'team_id' => $team['id'],
                           'member_id' => $team['leader_id'],
                           'member' => $team['leader'],
                           'name' => $team['leader'],
                           'type' => 6,
                           'status' => 1,
                           'create_time' => time(),
                           'update_time' => time()
                       ]);
                   }
                   if ($team['captain']) {
                       db('team_member_role')->insert([
                           'team_id' => $team['id'],
                           'member_id' => $team['captain_id'],
                           'member' => $team['captain'],
                           'name' => $team['captain'],
                           'type' => 3,
                           'status' => 1,
                           'create_time' => time(),
                           'update_time' => time()
                       ]);
                   }
               }
            });

            // 补充team_member name字段
            db('team_member')->chunk(50, function($members) {
               foreach ($members as $member) {
                  $teamMemberData = [];
                  $teamMemberData['id'] = $member['id'];
                  if ($member['member_id'] == -1) {
                      $teamMemberData['member'] = null;
                  }
                  if ($member['member_id']) {
                      $teamMemberData['telephone'] = db('member')->where('id', $member['member_id'])->value('telephone');
                  }
                  db('team_member')->update($teamMemberData);
               }
            });
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    // 补充match_record_member数据
    public function matchrecordmember() {
        db('match_record_member')->chunk(50, function($members) {
            foreach ($members as $member) {
                $matchRecordMemberData = [];
                $matchRecordMemberData['id'] = $member['id'];
                // 查询team_member
                $teamMemberInfo = db('team_member')->where([
                    'team_id' => $member['team_id'],
                    'member_id' => $member['member_id'],
                    //'member' => $member['member']
                ])->find();
                if ($teamMemberInfo) {
                    $matchRecordMemberData['team_member_id'] = $teamMemberInfo['id'];
                    $matchRecordMemberData['name'] = $teamMemberInfo['name'];
                    $matchRecordMemberData['number'] = $teamMemberInfo['number'];
                }
                db('match_record_member')->update($matchRecordMemberData);
            }
        });
    }

    // 搜索课时结算产生的数据
    public function searchscheduledata() {
        $where['can_settle_date'] = '20180314';
        // 查询符合条件的课时记录，遍历纠正学员剩余课时数、已上课时数
        $schedules = db('schedule')->where($where)->select();
        foreach ($schedules as $schedule) {
            // 课时学员名单
            $studentArr = unserialize($schedule['student_str']);
            //dump($studentArr);
            if (!empty ($studentArr)) {
                $saveAllLessonMemberData = $saveAllStudentData= [];
                foreach ($studentArr as $k => $student) {
                    // 获取学员的课程-学员关系
                    if (isset($student['lmid'])) {
                        // 拼课学员
                        $lessonMember = db('lesson_member')->where([
                            'id' => $student['lmid']
                        ])->find();
                    } else  {
                        // 本班学员
                        $lessonMember = db('lesson_member')
                            ->where([
                                'student_id' => $student['student_id'],
                                'student' => $student['student'],
                                'camp_id' => $schedule['camp_id'],
                                'lesson_id' => $schedule['lesson_id']
                            ])
                            ->whereNull('delete_time')
                            ->find();
                    }
                    //dump($lessonMember);

                    // 获取学员的课时数
                    $scheduleMemberCount = db('schedule_member')
                        ->where([
                            'camp_id' => $schedule['camp_id'],
                            'user_id' => $student['student_id']
                        ])
                        ->whereNull('delete_time')
                        ->count();
                    $scheduleMemberCount = $scheduleMemberCount ? $scheduleMemberCount : 0;
                    //dump($scheduleMemberCount);

                    $saveAllLessonMemberData[$k] = [
                        'id' => $lessonMember['id'],
                        'rest_schedule' => $lessonMember['total_schedule'] - $scheduleMemberCount
                    ];
                    $saveAllStudentData[$k] = [
                        'id' => $student['student_id'],
                        'finished_schedule' => $scheduleMemberCount
                    ];
                }
                //dump($saveAllLessonMemberData);
                //dump($saveAllStudentData);
                // 批量更新学员的剩余课时数、已上课时数
                $modelLessonMember = new LessonMember();
                $modelStudent = new Student();
                if (!empty($saveAllLessonMemberData)) {
                    //$modelLessonMember->saveAll($saveAllLessonMemberData);
                }
                if (!empty($saveAllStudentData)) {
                    //$modelStudent->saveAll($saveAllStudentData);
                }
            }
        }
    }

    // 补全apply表的头像信息
    public function patchapplyavatar() {
        try {
            db('apply')->chunk(50, function($applys) {
                foreach ($applys as $apply) {
                    //dump($apply);
                    // 申请人|邀请人 会员信息
                    $memberAvatar = db('member')->where('id', $apply['member_id'])->value('avatar');
                    // 区别organization_type 1训练营|2球队
                    $orgImage = '';
                    if ($apply['organization_type'] == 1) {
                        $orgImage = db('camp')->where('id', $apply['organization_id'])->value('logo');
                    } else if ($apply['organization_type'] == 2) {
                        $orgImage = db('team')->where('id', $apply['organization_id'])->value('logo');
                    }
                    $updateData = [
                        'id' => $apply['id'],
                        'member_avatar' => ($apply['member_id'] > 0) ? $memberAvatar : '',
                        'organization_image' => $orgImage,
                        'inviter_avatar' => ($apply['inviter_id'] > 0) ? db('member')->where('id', $apply['inviter_id'])->value('avatar') : ''
                    ];
                    //dump($updateData);
                    db('apply')->update($updateData);
                }
            });
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }
}