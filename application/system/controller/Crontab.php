<?php
namespace app\system\controller;
use app\service\SystemService;
use app\model\SalaryIn;
use think\Controller;
use think\Db;


class Crontab extends Controller {
    public $setting;


    public function _initialize() {
        $SystemS = new SystemService();
        $this->setting = $SystemS::getSite();
    }

    // 结算教练课时薪资 3天前课时记录
    // 分成比例为73, 教练70%里50%为底薪 20%评分结果所得
    public function schedulesalary() {
        // 课时日后3天 生成课时薪资
        $dayafter = 3;
        // 当天开始时间&结束时间
        $t = time();
        $start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t))-(86400*$dayafter);
        $end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t))-(86400*$dayafter);
        $map['status'] = 1;
        $map['create_time'] = ['BETWEEN',[$start_time,$end_time]];
        Db::table('schedule')->field(true)->where($map)->chunk(50, function($schedules) {
            foreach ($schedules as $val) {
                $coach_id = $val['coach_id'];
                $assistant_ids = $val['assistant_ids'];
                $coach_salary = $val['coach_salary'];
                $assistant_salary = $val['assistant_salary'];
                $salary_base = $val['salary_base'];
                $students = $val['students'];
                // 课时评分提成 最大为20
                $star = $val['star'];
                // 学生人数基数薪资
                $salaryBase = $salary_base*$students;
                // 主教练薪资
                $salaryCoach = ($salaryBase+$coach_salary)*(1-$this->setting['sysrebate']-$this->setting['starrebate'])+($salaryBase+$coach_salary)*$star/100;
                // 有助教的话 主教练实际所得薪资
                if (!empty($assistant_ids)) {
                    // 助教薪资
                    $salaryAssitant = ($salaryBase+$assistant_salary)*(1-$this->setting['sysrebate']-$this->setting['starrebate'])+($salaryBase+$assistant_salary)*$star/100;
                    $salaryCoach = $salaryCoach - $salaryAssitant;

                    $assistantList = $this->assitantIdArr($assistant_ids);
                    if ($assistantList) {
                        foreach ($assistantList as $assistant) {
                            $memberAssistant = $this->getCoachMember($assistant);
                            //dump($memberAssistant);
                            if ($memberAssistant) {
                                $salaryInAssistantData = [
                                    'salary' => $salaryAssitant,
                                    'member_id' => $memberAssistant['member_id'],
                                    'member' => $memberAssistant['member'],
                                    'realname' => $memberAssistant['realname'],
                                    'pid' => $memberAssistant['pid'],
                                    'level' => $memberAssistant['level'],
                                    'lesson_id' => $val['lesson_id'],
                                    'lesson' => $val['lesson'],
                                    'grade_id' => $val['grade_id'],
                                    'grade' => $val['grade'],
                                    'camp_id' => $val['camp_id'],
                                    'camp' => $val['camp'],
                                    'create_time' => time(),
                                    'update_time' => time(),
                                    'status' => 1,
                                    'type' => 1,
                                    'member_type' => 4
                                ];
                                $this->insertSalaryIn($salaryInAssistantData);
                            }
                        }
                    }
                }

                // 教练所得薪资 salary_in
                $memberCoach = $this->getCoachMember($coach_id);
                if ($memberCoach) {
                    $salaryInCoach = [
                        'salary' => $salaryCoach,
                        'member_id' => $memberCoach['member_id'],
                        'member' => $memberCoach['member'],
                        'realname' => $memberCoach['realname'],
                        'pid' => $memberCoach['pid'],
                        'level' => $memberCoach['level'],
                        'lesson_id' => $val['lesson_id'],
                        'lesson' => $val['lesson'],
                        'grade_id' => $val['grade_id'],
                        'grade' => $val['grade'],
                        'camp_id' => $val['camp_id'],
                        'camp' => $val['camp'],
                        'create_time' => time(),
                        'update_time' => time(),
                        'status' => 1,
                        'type' => 1,
                        'member_type' => 1
                    ];
                    $this->insertSalaryIn($salaryInCoach);
                }

            }
        });
    }

    // 每天结算 当天内
    // 推荐人收入提成 实际收入*返利比例(5%/3%)
    public function salaryinrebate() {
        // 当天开始时间&结束时间
        $t = time();
        $start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $map['status'] = 1;
        $map['create_time'] = ['BETWEEN',[$start_time,$end_time]];
        DB::name('salary_in')->field(true)->where($map)->chunk(50, function($salaryins) {
            foreach ($salaryins as $salaryin) {
                if ($salaryin['pid']) {
                    $memberRebates = $this->getMemberTier($salaryin);
                    foreach ($memberRebates as $k => $memberRebate) {
                        unset($memberRebates[$k]['pid']);
                        $memberRebates[$k]['salary_id'] =  $salaryin['id'];
                        $memberRebates[$k]['create_time'] = time();
                        $memberRebates[$k]['update_time'] = time();
                        if ($memberRebate['tier'] == 2) { //5%
                            $memberRebates[$k]['salary'] = $salaryin['salary']*$this->setting['rebate'];
                        } else if ($memberRebate['tier'] == 3) { //3%
                            $memberRebates[$k]['salary'] = $salaryin['salary']*$this->setting['rebate2'];
                        }
                        $this->insertRebate($memberRebates[$k]);
                    }
                    //dump($memberRebates);
                }
            }
        });
    }

    // 每天结算 当天内
    // HP业绩返利 3层返利100%
    public function hprebate() {
        // 当天开始时间&结束时间
        $t = time();
        $start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $map['status'] = 1;
        $map['create_time'] = ['BETWEEN',[$start_time,$end_time]];
        $map['is_pay'] = 1;
        Db::name('bill')->where($map)->chunk(50, function($bills){
            foreach ($bills as $bill) {
                $member = db('member')->where('id', $bill['member_id'])->find();
                // 消费会员 HP
                $memberHPRebateData = [
                    'member_id' => $member['id'],
                    'member' => $member['member'],
                    'tier' => 1,
                    'bill_id' => $bill['id'],
                    'bill_order' => $bill['bill_order'],
                    'rebate_hp' => ceil($bill['balance_pay']),
                    'paymoney' => $bill['balance_pay'],
                    'status' => 1,
                    'create_time' => time(),
                    'update_time' => time()
                ];
                $this->insertRebateHP($memberHPRebateData);

                // 上线会员 HP
                $memberPiersHPRebateData = $this->getMemberTier($member);
                foreach ($memberPiersHPRebateData as $k => $val) {
                    unset($memberPiersHPRebateData[$k]['pid']);
                    $memberPiersHPRebateData[$k]['bill_id'] =  $bill['id'];
                    $memberPiersHPRebateData[$k]['bill_order'] = $bill['bill_order'];
                    $memberPiersHPRebateData[$k]['rebate_hp'] = ceil($bill['balance_pay']);
                    $memberPiersHPRebateData[$k]['paymoney'] = $bill['balance_pay'];
                    $memberPiersHPRebateData[$k]['status'] = 1;
                    $memberPiersHPRebateData[$k]['create_time'] = time();
                    $memberPiersHPRebateData[$k]['update_time'] = time();
                    $this->insertRebateHP($memberPiersHPRebateData[$k]);
                }
            } 
        });
    }

    // 每天结算 当天内
    // 消费返回积分 上线50%/30%
    public function scorerebate() {
        // 当天开始时间&结束时间
        $t = time();
        $start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $map['status'] = 1;
        $map['create_time'] = ['BETWEEN',[$start_time,$end_time]];
        $map['is_pay'] = 1;
        Db::name('bill')->where($map)->chunk(50, function($bills){
            foreach ($bills as $bill) {
                $member = db('member')->where('id', $bill['member_id'])->find();
                // 消费会员 HP
                $memberScoreRebateData = [
                    'member_id' => $member['id'],
                    'member' => $member['member'],
                    'tier' => 1,
                    'bill_id' => $bill['id'],
                    'bill_order' => $bill['bill_order'],
                    'rebate_score' => ceil($bill['balance_pay']),
                    'paymoney' => $bill['balance_pay'],
                    'status' => 1,
                    'create_time' => time(),
                    'update_time' => time()
                ];
                $this->insertRebateScore($memberScoreRebateData);

                // 上线会员 HP
                $memberPiersScoreRebateData = $this->getMemberTier($member);
                foreach ($memberPiersScoreRebateData as $k => $val) {
                    unset($memberPiersScoreRebateData[$k]['pid']);
                    $memberPiersScoreRebateData[$k]['bill_id'] =  $bill['id'];
                    $memberPiersScoreRebateData[$k]['bill_order'] = $bill['bill_order'];
                    if ($val['tier'] ==2) {
                        $memberPiersScoreRebateData[$k]['rebate_score'] = ceil($bill['balance_pay']*0.5);
                    } else if ($val['tier'] ==3) {
                        $memberPiersScoreRebateData[$k]['rebate_score'] = ceil($bill['balance_pay']*0.3);
                    }
                    $memberPiersScoreRebateData[$k]['paymoney'] = $bill['balance_pay'];
                    $memberPiersScoreRebateData[$k]['status'] = 1;
                    $memberPiersScoreRebateData[$k]['create_time'] = time();
                    $memberPiersScoreRebateData[$k]['update_time'] = time();
                    $this->insertRebateScore($memberPiersScoreRebateData[$k]);
                }
            }
        });
    }



    // 循环当天课时记录,并且执行教练课量
    public function schedulerebatecoach(){
        // 获取当天课时
        // 当天开始时间&结束时间
        $t = time();
        $start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $map['status'] = 1;
        $map['create_time'] = ['BETWEEN',[$start_time,$end_time]];
        Db::name('schedule')->where($map)->chunk(10,function($schedules){
            foreach ($schedules as $key => $value) {
                // 主教练的课量+1
                $this->coachInc($value['coach_id'],'schedule_flow',1);
                $this->coachInc($value['coach_id'],'student_flow',$value['students']);
                // 副教练的课量+1
                $assistant_ids = unserialize($value['assistant_id']);
                foreach ($assistant_ids as $k => $val) {
                    $this->coachInc($val,'schedule_flow',1);
                    $this->coachInc($val,'student_flow',$value['students']);
                }
            }
        });
    }

    // 循环当天schedule_member记录,并且执行学生课量
    public function schedulerebatestudent(){
        // 获取当天课时
        // 当天开始时间&结束时间
        $t = time();
        $start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $map['status'] = 1;
        $map['create_time'] = ['BETWEEN',[$start_time,$end_time]];
        Db::name('schedule_member')->where($map)->chunk(10,function($schedules){
            foreach ($schedules as $key => $value) {
                if($value['type'] == 1){
                    $this->studentInc($value['user_id'],'finished_scheduel',1);

                }
                if($value['type'] == 2){
                    // 主教练的课量+1
                    $this->coachInc($value['coach_id'],'schedule_flow',1);
                    $this->coachInc($value['coach_id'],'student_flow',$value['students']);
                }
                

            }
        });
    }

    // 循环课程评价的评分


    // 获取教练信息
    protected function getCoachMember($coach_id) {
        $member = Db::view('coach', ['id' => 'coach_id', 'member_id'])
                    ->view('member','id,member,realname,pid,level', 'member.id=coach.member_id')
                    ->where('coach.id', $coach_id)->find();
        return $member ? $member : false;
    }

    protected function assitantIdArr($ids) {
        $assitantArr = explode(',', $ids);
        return $assitantArr ? $assitantArr : false;
    }

    // 插入salary_in表
    protected function insertSalaryIn($data) {
        $execute = db('salary_in')->insert($data);
        if ($execute) {
            db('member')->where('id', $data['member_id'])->setInc('balance', $data['salary']);
            file_put_contents(ROOT_PATH.'data/salaryin/'.date('Y-m-d',time()).'.txt', json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND );
        } else {
            file_put_contents(ROOT_PATH.'data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        }
    }

    // 插入rebate表
    protected function insertRebate($data) {
        $execute = db('rebate')->insert($data);
        if ($execute) {
            db('member')->where('id', $data['member_id'])->setInc('balance', $data['salary']);
            file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        } else {
            file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND );
        }
    }

    // 插入rebate_hp表
    protected function insertRebateHP($data) {
        $execute = db('rebate_hp')->insert($data);
        if ($execute) {
            db('member')->where('id', $data['member_id'])->setInc('hp', $data['rebate_hp']);
            file_put_contents(ROOT_PATH.'data/rebate_hp/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        } else {
            file_put_contents(ROOT_PATH.'data/rebate_hp/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        }
    }

    // 插入rebate_score表
    protected function insertRebateScore($data) {
        $execute = db('rebate_score')->insert($data);
        if ($execute) {
            db('member')->where('id', $data['member_id'])->setInc('score', $data['rebate_score']);
            file_put_contents(ROOT_PATH.'data/rebate_score/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        } else {
            file_put_contents(ROOT_PATH.'data/rebate_score/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        }
    }

    // 获取会员上下线层级
    protected function getMemberTier($member) {
        $tree = [];
        $parent_member = db('member')->field(['id' => 'member_id','member','pid'])->where('id', $member['pid'])->find();
        //dump($parent_member);
        if ($parent_member) {
            $parent_member['tier'] = 2;
            $parent_member['sid'] = $member['id'];
            $parent_member['s_member'] = $member['member'];
            array_push($tree, $parent_member);
            $parent_member2 = db('member')->field(['id' => 'member_id','member','pid'])->where('id', $parent_member['pid'])->find();
            if ($parent_member2) {
                $parent_member2['tier'] =3;
                $parent_member2['sid'] = $parent_member['member_id'];
                $parent_member2['s_member'] = $parent_member['member'];
                array_push($tree, $parent_member2);
            }
        }
        return $tree;
    }


    // coach表字段增加
    protected function coachInc($member_id,$incField,$inc = 1){
        $result = db('coach')->where(['member_id'=>$member_id])->setInc($incField,$inc);
        if($result){
            file_put_contents(ROOT_PATH.'data/schedule/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>['coach_member_id'=>$member_id,'filed'=>$incField,'inc'=>$inc],'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        } else {
            file_put_contents(ROOT_PATH.'data/schedule/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>['coach_member_id'=>$member_id,'filed'=>$incField,'inc'=>$inc],'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        }
    }
    // student表字段增加
    protected function studentInc($student_id,$incField,$inc = 1){
        $result = db('student')->where(['id'=>$student_id])->setInc($incField,$inc);
        if($result){
            file_put_contents(ROOT_PATH.'data/schedule/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>['student_id'=>$student_id,'filed'=>$incField,'inc'=>$inc],'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        } else {
            file_put_contents(ROOT_PATH.'data/schedule/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>['student_id'=>$student_id,'filed'=>$incField,'inc'=>$inc],'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        }
    }

    //grade_member表rest_schedule减少
    protected function gradeMemberRestScheduleDec($student_id,$decField = 'rest_schedule',$dec = 1){
        $result = db('grade_member')->where(['student_id'=>$student_id])->setDec($incField,$inc);
        if($result){
            file_put_contents(ROOT_PATH.'data/grade_member/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>['student_id'=>$student_id,'filed'=>$incField,'inc'=>$inc],'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        } else {
            file_put_contents(ROOT_PATH.'data/grade_member/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>['student_id'=>$student_id,'filed'=>$incField,'inc'=>$inc],'time'=>date('Y-m-d H:i:s',time())]).PHP_EOL, FILE_APPEND  );
        }
    }
}