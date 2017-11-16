<?php
namespace app\system\controller;
use app\model\Coach;
use app\service\SystemService;
use app\model\SalaryIn;
use think\Controller;
use think\Db;
use think\helper\Time;

class Crontab extends Controller {
    public $setting;


    public function _initialize() {
        $SystemS = new SystemService();
        $this->setting = $SystemS::getSite();
    }

    // 结算当天已申课时工资收入
    public function schedulesalaryin() {
        // 获取课时列表
        // 赠课记录，有赠课记录先抵扣
        // 91分 9进入运算 1平台收取
        // 结算主教+助教收入，剩余给营主
        // 上级会员收入提成(90%*5%,90%*3%)
        list($start, $end) = Time::today();
        $map['status'] = 1;
        //$map['create_time'] = ['between', [$start, $end]];
        $map['is_settle'] = 0;
        Db::name('schedule')->where($map)->chunk(50, function($schedules) {
            foreach ($schedules as $schedule) {
                // 课时正式学员人数
                $numScheduleStudent = count(unserialize($schedule['student_str']));

                $lesson = $lesson = Db::name('lesson')->where('id', $schedule['lesson_id'])->find();
                // 课程有未结算赠课数,  抵扣赠课课时
                if ($lesson['unbalanced_giftschedule']) {
                    $numGiftSchedule = ceil($numScheduleStudent/2);
                    Db::name('lesson')->where('id', $schedule['lesson_id'])->setDec('unbalanced_giftschedule', $numGiftSchedule);
                } else {
                    // 课时收入
                    $incomeSchedule = ($lesson['cost'] * $numScheduleStudent) * (1-$this->setting['sysrebate']);
                    $coachMember = $this->getCoachMember($schedule['coach_id']);
                    // 主教练薪资
                    if ($schedule['coach_salary'] > 0) {
                        $incomeCoach = [
                            'salary' => $schedule['coach_salary'],
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
                            'status' => 1,
                            'type' => 1
                        ];
                        $this->insertSalaryIn($incomeCoach);
                    }
                    // 助教薪资
                    $incomeAssistant = [];
                    if (!empty($schedule['assistant_id']) && $schedule['assistant_salary'] ) {
                        $assistantMember = $this->getAssistantMember($schedule['assistant_id']);
                        foreach ($assistantMember as $k => $val) {
                            $incomeAssistant[$k] = [
                                'salary' => $schedule['assistant_salary'],
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
                                'status' => 1,
                                'type' => 1
                            ];
                        }
                        $this->insertSalaryIn($incomeAssistant, 1);
                    }

                    // 营主所得
                    $campMember = $this->getCampMember($schedule['camp_id']);
                    $incomeCamp = [
                        'salary' => $incomeSchedule-$schedule['coach_salary']-$schedule['assistant_salary'],
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
                        'status' => 1,
                        'type' => 1
                    ];
                    $this->insertSalaryIn($incomeCamp);
                }
                //Db::name('schedule')->where(['id' => $schedule['id']])->update(['update_time' => time(), 'is_settle' => 1]);
            }
        });
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
            ->find();
        return $member;
    }

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
            //db('member')->where('id', $data['member_id'])->setInc('balance', $data['salary']);
            file_put_contents(ROOT_PATH.'data/salaryin/'.date('Y-m-d',time()).'.txt', json_encode(['time'=>date('Y-m-d H:i:s',time()), 'success'=>$data], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND );
            return true;
        } else {
            file_put_contents(ROOT_PATH.'data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'error'=>$data], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND  );
            return false;
        }
    }
}