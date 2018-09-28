<?php
namespace app\system\controller;
use app\model\Coach;
use app\service\ScheduleService;
use app\model\SalaryIn;
use app\model\Output;
use app\model\CampFinance;
use think\Db;
use app\system\controller\Base;
/**
 * 课时结算
 * @param  正式
 */
class Crontabwoo extends Base {
    public $setting;


    public function _initialize() {
        parent::_initialize();
    }


    public function delayedTask(){
        try{
            $campList = db('camp')->where('delete_time',null)->select();
            foreach ($campList as $key => $value) {
                if($value['rebate_type'] == 1){
                    $this->schedulesalaryin1($value);
                }elseif ($value['rebate_type'] == 2) {
                    $this->schedulesalaryin2($value);
                }
            }
            $data = ['crontab'=>'每日结算','status'=>1];
            $this->record($data);
        } catch (Exception $e) {
            // 记录日志：错误信息
            $data = ['crontab'=>'每日结算','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
        
    }

    // 结算可结算已申课时工资收入&扣减课时学员课时数
    private function schedulesalaryin1($campInfo) {
            // 获取可结算课时数据列表
            // 赠课记录，有赠课记录先抵扣
            // 91分 9进入运算 1平台收取
            // 结算主教+助教收入，剩余给营主
            // 上级会员收入提成(90%*5%,90%*3%)
            $map['status'] = 1;
            $map['is_settle'] = 0;
            // // 当前时间日期
            $nowDate = date('Ymd', time());
            $map['camp_id'] = $campInfo['id'];

            $map['can_settle_date'] = $nowDate;
            $map['questions'] = 0;
            $map['is_school'] = -1;
            Db::name('schedule')->where($map)->whereNull('delete_time')->chunk(50, function ($schedules){
                foreach ($schedules as $key=> $schedule) {

                    // 训练营的支出 = (教练薪资+人头提成)
                    $campInfo = db('camp')->where(['id'=>$schedule['camp_id']])->find();
                    // 扣减课时学员课时数 start
                    // 课时相关学员剩余课时-1
                    $scheduleS = new ScheduleService();
                    $students = unserialize($schedule['student_str']);
                    $decStudentRestscheduleResult = $scheduleS->decStudentRestschedule($students, $schedule);
                    // 扣减课时学员课时数 end

                    // 课时工资收入结算 start
                    // 课时正式学员人数
                    $numScheduleStudent = count($students);
                    $lesson = $lesson = Db::name('lesson')->where('id', $schedule['lesson_id'])->find();
                    
                    // 课时总收入
                    $incomeSchedule = ($lesson['cost'] * $numScheduleStudent);
                    // 课时工资提成
                    $pushSalary = $schedule['salary_base'] * $numScheduleStudent;
                    $coachMember = $this->getCoachMember($schedule['coach_id']);
                    $totalCoachSalary = 0;
                    $s_balance = (float)$coachMember['member']['balance'];
                    // 主教练薪资
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
                        'rebate_type' => $campInfo['rebate_type'],
                        'students'=>$schedule['students'],
                        'status' => 1,
                        'type' => 1,
                    ];
                    $totalCoachSalary = $schedule['coach_salary']+$pushSalary;
                    $this->insertSalaryIn($incomeCoach,0,1);
                    $MemberFinanceData1 = [
                                'member_id' => $coachMember['member']['id'],
                                'member' => $coachMember['member']['member'],
                                's_balance'=>$s_balance,
                                'e_balance'=>($s_balance+$schedule['coach_salary']+$pushSalary),
                                'money' =>$schedule['coach_salary']+$pushSalary,
                                'type'=>1,
                                'system_remarks'=>'课时主教练总薪资收入',
                                'f_id'=>$schedule['id'],
                                'remarks'=>$schedule['lesson_time'],
                            ];
                    $this->insertMemberFinance($MemberFinanceData1,0,1);
                    // 助教薪资
                    $totalAssistantSalary = 0;
                    $incomeAssistant = [];
                    if (!empty($schedule['assistant_id']) && ($schedule['assistant_salary']>0 || $schedule['salary_base']>0)) {
                        $assistantMember = $this->getAssistantMember($schedule['assistant_id']);
                        $totalCoachSalary += $schedule['assistant_salary'];
                        $totalCoachSalary += $pushSalary;
                        $totalAssistantSalary += $schedule['assistant_salary']; 
                        $totalAssistantSalary += $pushSalary;
                        foreach ($assistantMember as $k => $val) {
                            $incomeAssistant[$k] = [
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
                                'students'=>$schedule['students'],
                                'rebate_type' => $campInfo['rebate_type'],
                                'status' => 1,
                                'type' => 2,
                            ];
                            $MemberFinanceData2[$k] = [
                                'member_id' => $val['member']['id'],
                                'member' => $val['member']['member'],
                                's_balance'=>(float)$val['member']['balance'],
                                'e_balance'=>((float)$val['member']['balance']+$schedule['assistant_salary']+$pushSalary),
                                'money' =>$schedule['assistant_salary']+$pushSalary,
                                'type'=>1,
                                'system_remarks'=>'课时助理教练总薪资收入',
                                'f_id'=>$schedule['id'],
                                'remarks'=>$schedule['lesson_time'],
                            ];
                        }
                        $this->insertSalaryIn($incomeAssistant,1,1);
                        $this->insertMemberFinance($MemberFinanceData2,1,1);
                    }

                    // 剩余为训练营所得 课时收入*抽取比例-主教底薪-助教底薪-课时工资提成*教练人数。教练人数 = 助教人数+1（1代表主教人数）
                    // 抽取比例：训练营有特定抽取比例以(1-特定抽取比例)计算|否则以(1-平台抽取比例)计算
                    $campScheduleRebate = $schedule['schedule_rebate'];
                    $incomeCampSalary = ($incomeSchedule * (1-$campScheduleRebate)) - $schedule['coach_salary'] - $schedule['assistant_salary'] - ($pushSalary * (count($incomeAssistant) + 1));
                    $incomeCamp = [
                        'income' => $incomeCampSalary,
                        'schedule_id'=>$schedule['id'],
                        'lesson_id' => $schedule['lesson_id'],
                        'lesson' => $schedule['lesson'],
                        'camp_id' => $schedule['camp_id'],
                        'camp' => $schedule['camp'],
                        'schedule_time' => $schedule['lesson_time'],
                        'students'=>$schedule['students'],
                        'f_id'=> $schedule['id'],
                        'schedule_income'=>$incomeSchedule,
                        'e_balance' => (float)$campInfo['balance']+$incomeSchedule,
                        's_balance'=>(float)$campInfo['balance'],
                        'rebate_type' => $campInfo['rebate_type'],
                        'schedule_rebate' => $campInfo['rebate_type'],
                        'status' => 1,
                        'type' => 3,
                        'schedule_rebate'=>$campScheduleRebate,
                        'system_remarks' => '',
                    ];
                    $this->insertIncome($incomeCamp,0,1);


                    // 保存训练营财务支出信息
                    $dataOutput[0] = [
                        'output'    => $totalCoachSalary,
                        'camp_id'   => $schedule['camp_id'],
                        'camp'      => $schedule['camp'],
                        'member'    =>'system',
                        'member_id' =>0,
                        'type'      =>3,
                        's_balance' =>(float)$campInfo['balance'],
                        'e_balance' =>(float)$campInfo['balance'],
                        'system_remarks'=>'营业额结算',
                        'status'    =>1,
                        'remarks'   =>'课时教练总薪资支出',
                        'schedule_time'=>$schedule['lesson_time'],
                        'rebate_type' => $campInfo['rebate_type'],
                        'schedule_rebate' => $campInfo['rebate_type'],
                        'f_id'=>$schedule['id'],
                        'system_remarks'=>$schedule['lesson_time'],
                    ];
                    $dataOutput[1] = [
                        'output'    => ($incomeSchedule * $campScheduleRebate),
                        'camp_id'   => $schedule['camp_id'],
                        'camp'      => $schedule['camp'],
                        'member'    =>'system',
                        'member_id' =>0,
                        'type'      =>4,
                        's_balance' =>(float)$campInfo['balance'],
                        'e_balance' =>(float)$campInfo['balance'],
                        'system_remarks'=>'课时结算',
                        'schedule_time'=>$schedule['lesson_time'],
                        'rebate_type' => $campInfo['rebate_type'],
                        'schedule_rebate' => $campInfo['rebate_type'],
                        'status'    =>1,
                        'remarks'   =>'平台分成',
                        'f_id'=>$schedule['id'],
                        'system_remarks'=>$schedule['lesson_time'],
                    ];
                    $this->insertOutput($dataOutput,1,1);
                    // 保存训练营财务收入支出信息
                    $dataCampFinance = [
                        'camp_id' => $schedule['camp_id'],
                        'camp' => $schedule['camp'],
                        'money'=>$incomeCampSalary,
                        'type' => 3,
                        'e_balance' => (float)($campInfo['balance']+$incomeCampSalary),
                        's_balance'=>(float)$campInfo['balance'],
                        'rebate_type' => $campInfo['rebate_type'],
                        'schedule_rebate' => $campInfo['schedule_rebate'],
                        'f_id' => $schedule['id'],
                        'date' => date('Ymd', $schedule['lesson_time']),
                        'datetime' => $schedule['lesson_time'],
                        'date_str'=>date('Ymd',time()),

                    ];
                    $this->insertcampfinance($dataCampFinance,0,1);
                    // 结算增加到camp表的balancc;
                    db('camp')->where(['id'=>$schedule['camp_id']])->inc('balance',$incomeCampSalary)->update();
                    // 更新课时数据
                    Db::name('schedule')->where(['id' => $schedule['id']])->update(['is_settle' => 1, 'schedule_income' => $incomeSchedule, 'finish_settle_time' => time(),'s_coach_salary'=>($schedule['coach_salary']+$pushSalary),'s_assistant_salary'=>$totalAssistantSalary]);
                    db('schedule_member')->where(['schedule_id' => $schedule['id']])->update(['status' => 1, 'update_time' => time()]);
                    // 课时工资收入结算 end
                }

            });
        
    }

    // 结算可结算已申课时工资收入&扣减课时学员课时数
    private function schedulesalaryin2($campInfo) {
        // 获取可结算课时数据列表   
        $map['status'] = 1;
        $map['is_settle'] = 0;
        // 当前时间日期
        $nowDate = date('Ymd', time());
        $map['camp_id'] = $campInfo['id'];
        $map['can_settle_date'] = $nowDate;
        $map['questions'] = 0;
        $map['is_school'] = -1;
        db('schedule')->where($map)->whereNull('delete_time')->chunk(50, function ($schedules){
            foreach ($schedules as $key => $schedule) {
                // 训练营的支出 = (教练薪资+人头提成)
                $campInfo = db('camp')->where(['id'=>$schedule['camp_id']])->find();
            //扣减课时学员课时数 start----------------------------
                // 课时相关学员剩余课时-1
                $scheduleS = new ScheduleService();
                $students = unserialize($schedule['student_str']);
                $decStudentRestscheduleResult = $scheduleS->decStudentRestschedule($students, $schedule);
            //扣减课时学员课时数 end------------------------------

            //课时工资收入结算 start------------------------------
                // 课时正式学员人数
                $totalScheduleStudent = count($students);
                $totalCoachSalary = 0;
                $MemberFinanceData = [];
                // 主教练课时人头工资提成
                $pushSalary = $schedule['salary_base'] * $totalScheduleStudent;
                $coachMember = $this->getCoachMember($schedule['coach_id']);
                $s_balance = (float)$coachMember['member']['balance'];
                if($coachMember){
                    // 主教练薪资
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
                        'rebate_type'=>$campInfo['rebate_type'],
                        'students'=>$schedule['students'],
                        'status' => 1,
                        'type' => 1,
                    ];
                    $MemberFinanceData = [
                            'member_id' => $coachMember['member']['id'],
                            'member' => $coachMember['member']['member'],
                            's_balance'=>$s_balance,
                            'e_balance'=>(float)($s_balance+$schedule['coach_salary']+$pushSalary),
                            'money' =>$schedule['coach_salary']+$pushSalary,
                            'type'=>1,
                            'system_remarks'=>'课时主教练总薪资收入',
                            'f_id'=>$schedule['id'],
                            'remarks'=>$schedule['lesson_time'],
                        ];
                    $this->insertSalaryIn($incomeCoach,0,2);
                    $totalCoachSalary = $schedule['coach_salary'] + $pushSalary;
                    $this->insertMemberFinance($MemberFinanceData,0,2);
                }
                
                // 助教薪资
                $totalAssistantSalary = 0;
                if (!empty($schedule['assistant_id']) && ($schedule['assistant_salary']>0 || $schedule['salary_base']>0)) {
                    
                    $MemberFinanceData = [];
                    $assistantMember = $this->getAssistantMember($schedule['assistant_id']);
                    foreach ($assistantMember as $k => $val) {
                        $totalAssistantSalary += $schedule['assistant_salary']; 
                        $totalAssistantSalary += $pushSalary;
                        $totalCoachSalary += $schedule['assistant_salary']; 
                        $totalCoachSalary += $pushSalary;
                        $incomeAssistant[$k] = [
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
                            'students'=>$schedule['students'],
                            's_balance'=>$val['member']['balance'],
                            'e_balance'=>$val['member']['balance']+$schedule['assistant_salary']+$pushSalary,
                            'rebate_type'=>$campInfo['rebate_type'],
                            'status' => 1,
                            'type' => 2,
                            'f_id'=>$schedule['id'],
                        ];
                        $MemberFinanceData[$k] = [
                            'member_id' => $val['member']['id'],
                            'member' => $val['member']['member'],
                            's_balance'=>(float)$val['member']['balance'],
                            'e_balance'=>((float)$val['member']['balance']+$schedule['assistant_salary']+$pushSalary),
                            'money' =>$schedule['assistant_salary']+$pushSalary,
                            'type'=>1,
                            'system_remarks'=>'课时助理教练总薪资收入',
                            'f_id'=>$schedule['id'],
                            'remarks'=>$schedule['lesson_time'],
                        ];
                    }
                    $this->insertSalaryIn($incomeAssistant,1,2);
                    $this->insertMemberFinance($MemberFinanceData,1,2);
                }
                
                // 保存训练营财务支出信息
                $dataOutput = [
                    'output'    => $totalCoachSalary,
                    'camp_id'   => $schedule['camp_id'],
                    'camp'      => $schedule['camp'],
                    'member'    =>'system',
                    'member_id' =>0,
                    'type'      =>3,
                    's_balance' =>$campInfo['balance'],
                    'e_balance' =>$campInfo['balance'],
                    'system_remarks'=>'营业额结算',
                    'schedule_time'=>$schedule['lesson_time'],
                    'rebate_type' => $campInfo['rebate_type'],
                    'schedule_rebate' => $campInfo['rebate_type'],
                    'status'    =>1,
                    'remarks'   =>'课时教练总薪资支出',
                    'f_id'=>$schedule['id'],
                    'system_remarks'=>$schedule['lesson_time'],
                ];
                $this->insertOutput($dataOutput,0,2);
                // 保存训练营财务收入支出信息
                $dataCampFinance = [
                    'camp_id' => $schedule['camp_id'],
                    'camp' => $schedule['camp'],
                    'money'=>$totalCoachSalary,
                    'type' => -1,
                    'e_balance' => $campInfo['balance'],
                    's_balance'=>$campInfo['balance'],
                    'rebate_type' => $campInfo['rebate_type'],
                    'schedule_rebate' => $campInfo['schedule_rebate'],
                    'f_id' => $schedule['id'],
                    'date' => date('Ymd', $schedule['lesson_time']),
                    'datetime' => $schedule['lesson_time']
                ];
                $this->insertcampfinance($dataCampFinance,2);
                
                // 更新课时数据
                Db::name('schedule')->where(['id' => $schedule['id']])->update(['is_settle' => 1, 'schedule_income' => $schedule['cost']*$schedule['students']-$totalCoachSalary, 'finish_settle_time' =>  time(),'s_coach_salary'=>($schedule['coach_salary'] + $pushSalary),'s_assistant_salary'=>$totalAssistantSalary]);
                db('schedule_member')->where(['schedule_id' => $schedule['id']])->update(['status' => 1, 'update_time' => time()]);
                // 课时工资收入结算 end --------------------------------------
            }
        });
    }


     // 保存课时收入记录
    private function insertIncome($data, $saveAll=0,$is_balance = 1) {
        $model = new \app\model\Income();
        if ($saveAll == 1) {
            $execute = $model->allowField(true)->saveAll($data);
        } else {
            $execute = $model->allowField(true)->save($data);
        }
        if ($execute) {
            if($is_balance == 1){
                $campDb = db('camp');
                if ($saveAll ==1) {
                    foreach ($data as $val) {
                        $campDb->where('id', $val['camp_id'])->inc('balance_true', $val['income'])->update();
                    }
                } else {
                    $campDb->where('id', $data['camp_id'])->inc('balance_true', $data['income'])->update();
                }
                file_put_contents(ROOT_PATH.'data/income/'.date('Y-m-d',time()).'.txt', json_encode(['time'=>date('Y-m-d H:i:s',time()), 'success'=>$data], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND );
                return true;
            }elseif ($is_balance == 2) {
                // 训练营的余额不会变动
            }
            
        } else {
            file_put_contents(ROOT_PATH.'data/income/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'error'=>$data], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND  );
            return false;
        }
    }

    // 获取教练会员
    private function getCoachMember($coach_id) {
        $coachM = new Coach();
        $member = $coachM->with('member')->where(['id' => $coach_id])->find();
        if ($member) {
            return $member->toArray();
        }else{
            return [];
        }
    }


    // 获取助教会员
    private function getAssistantMember($assistant_id) {
        $assistant_ids = unserialize($assistant_id);
        $member = [];
        $coachM = new Coach();
        $member = $coachM->with('member')->where(['id' =>['in',$assistant_ids]])->select();
        if($member){
            return $member->toArray();
        }else{
            return [];
        }
        
    }

    // 保存收入记录
    private function insertSalaryIn($data, $saveAll=0,$is_balance = 1) {
        $model = new \app\model\SalaryIn();
        if ($saveAll == 1) {
            $execute = $model->allowField(true)->saveAll($data);
        } else {
            $execute = $model->allowField(true)->save($data);
        }
        if ($execute) {
            if($is_balance == 1){
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
            }elseif ($is_balance == 2) {
                //个人余额不变
            }
            
        } else {
            file_put_contents(ROOT_PATH.'data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'error'=>$data], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND  );
            return false;
        }
    }


    // 保存收入总记录
    private function insertMemberFinance($data, $saveAll=0,$is_balance = 1) {
        $model = new \app\model\MemberFinance();
        if ($saveAll == 1) {
            $execute = $model->allowField(true)->saveAll($data);
        } else {
            $execute = $model->allowField(true)->save($data);
        }
    }

    

    // 保存训练营财务记录
    private function insertcampfinance($data, $saveAll=0,$is_balance = 1) {
        $model = new CampFinance();
        if ($saveAll == 1) {
            $model->allowField(true)->saveAll($data);
        } else {
            $model->allowField(true)->save($data);
        }
    }

    // 保存训练营财务记录
    private function insertOutput($data, $saveAll=0,$is_balance = 1) {
        $model = new Output();
        if ($saveAll == 1) {
            $model->allowField(true)->saveAll($data);
        } else {
            $model->allowField(true)->save($data);
        }
    }


}