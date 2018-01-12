<?php
namespace app\system\controller;
use app\model\Coach;
use app\model\Rebate;
use app\service\SystemService;
use app\service\MemberService;
use app\model\SalaryIn;
use app\model\CampFinance;
use think\Controller;
use think\Db;
use think\helper\Time;

class Crontab extends Controller {
    public $setting;


    public function _initialize() {
        $SystemS = new SystemService();
        $this->setting = $SystemS::getSite();
    }

    // 结算前一天已申课时工资收入
    public function schedulesalaryin() {
        // 获取课时列表
        // 赠课记录，有赠课记录先抵扣
        // 91分 9进入运算 1平台收取
        // 结算主教+助教收入，剩余给营主
        // 上级会员收入提成(90%*5%,90%*3%)
        list($start, $end) = Time::yesterday();
        $map['status'] = 1;
        $map['create_time'] = ['between', [$start, $end]];
        $map['is_settle'] = 0;
        Db::name('schedule')->where($map)->where('delete_time',null)->chunk(50, function($schedules) {
            foreach ($schedules as $schedule) {
                // 课时正式学员人数
                $numScheduleStudent = count(unserialize($schedule['student_str']));
                $lesson = $lesson = Db::name('lesson')->where('id', $schedule['lesson_id'])->find();
                // 抵扣赠送课时数
                $numGiftSchedule=0;
                $systemRemarks = '';
                if ($lesson['unbalanced_giftschedule'] > 0) {
                    // 课程有未结算赠课数,  抵扣赠课课时：上课正式学员人数/2取整
                    $numGiftSchedule = ceil($numScheduleStudent/2);
                    if ($lesson['unbalanced_giftschedule'] > $numGiftSchedule) {
                        Db::name('lesson')->where('id', $schedule['lesson_id'])->setDec('unbalanced_giftschedule', $numGiftSchedule);
                        $systemRemarks = $lesson['lesson'].'抵扣赠课数：'.$numGiftSchedule;   
                    } else {
                        $numGiftSchedule = 0;
                    }
                }
                // 课时总收入
                $incomeSchedule = ($lesson['cost'] * ($numScheduleStudent-$numGiftSchedule));
                //$incomeScheulde1 = $incomeSchedule * (1-$this->setting['sysrebate']);
                // 课时工资提成
                $pushSalary = $schedule['salary_base']*$numScheduleStudent;
                $coachMember = $this->getCoachMember($schedule['coach_id']);

                // 主教练薪资
                if ($schedule['coach_salary'] > 0) {
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
                    ];
//                        dump($incomeCoach);
                    $this->insertSalaryIn($incomeCoach);
                }
                // 助教薪资
                $incomeAssistant = [];
                if (!empty($schedule['assistant_id']) && $schedule['assistant_salary'] ) {
                    $assistantMember = $this->getAssistantMember($schedule['assistant_id']);
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
                            'status' => 1,
                            'type' => 1,
                        ];
                    }
                    //dump($incomeAssistant);
                    $this->insertSalaryIn($incomeAssistant, 1);
                }

                // 营主所得 课时收入*(1-平台抽取比例)-主教底薪-助教底薪-课时工资提成*教练人数。教练人数 = 助教人数+1（1代表主教人数）
                $incomeCampSalary = $incomeSchedule*(1-$this->setting['sysrebate'])-$schedule['coach_salary']-$schedule['assistant_salary']-($pushSalary*(count($incomeAssistant)+1));
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
                    'system_remarks' => $systemRemarks
                ];
                $this->insertSalaryIn($incomeCamp);
                Db::name('schedule')->where(['id' => $schedule['id']])->update(['update_time' => time(), 'is_settle' => 1, 'schedule_income' => $incomeSchedule]);

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
            }
        });
    }

    // 结算上一个月收入 会员分成
    public function salaryinrebate(){
        list($start, $end) = Time::lastMonth();
        $map['status'] = 1;
        $map['has_rebate'] = 0;
        $map['create_time'] = ['between', [$start, $end]];
        $salaryins = DB::name('salary_in')->field(['member_id', 'sum(salary)+sum(push_salary)'=>'month_salary'])->where($map)->where('delete_time', null)->select();
        foreach ($salaryins as $salaryin) {
            $res = $this->insertRebate($salaryin['member_id'], $salaryin['month_salary']);
            if (!$res) { continue; }
        }
        DB::name('salary_in')->where($map)->update(['has_rebate' => 1]);
    }

    // 获取教练会员
    private function getCoachMember($coach_id) {
        $coachM = new Coach();
        $member = $coachM->with('member')->where(['id' => $coach_id])->find();
        if ($member) {
            return $member->toArray();
        }
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

    // 保存会员分成记录
    private function insertRebate($member_id, $salary) {
        $memberS = new MemberService();
        $model = new Rebate();
        $memberPiers = $memberS->getMemberPier($member_id);
        if (!empty($memberPiers)) {
            foreach ($memberPiers as $k => $memberPier) {
                if ($memberPier['tier']==2) {
                    $memberPiers[$k]['salary'] = $salary*$this->setting['rebate'];
                } elseif ($memberPier['tier']==3){
                    $memberPiers[$k]['salary'] = $salary*$this->setting['rebate2'];
                }
            }
            //dump($memberPiers);
            $execute = $model->allowField(true)->saveAll($memberPiers);
            if ($execute) {
                //db('member')->where('id', $data['member_id'])->setInc('balance', $data['salary']);
                $memberDb = db('member');
                foreach ($memberPiers as $member) {
                    $memberDb->where('id', $member['member_id'])->setInc('balance', $member['salary']);
                }
                file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'success'=>$memberPiers], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND  );
                return true;
            } else {
                file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'error'=>$memberPiers], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND );
                return false;
            }
        }
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
}