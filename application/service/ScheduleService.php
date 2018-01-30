<?php

namespace app\service;

use app\model\Grade;
use app\model\LessonMember;
use app\model\Schedule;
use app\model\ScheduleComment;
use app\model\ScheduleGiftrecord;
use app\model\ScheduleGiftStudent;
use app\model\ScheduleMember;
use app\model\Student;
use app\model\ScheduleGiftbuy;
use think\Db;
use app\common\validate\ScheduleVal;
use app\common\validate\ScheduleCommentVal;

class ScheduleService
{

    protected $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = new Schedule;
    }


    // 获取课时数据列表
    public function getscheduleList($map = [], $page = 1, $p = '10', $order = 'id desc', $field = '*')
    {
        $res = Schedule::where($map)->field($field)->order($order)->page($page, $p)->select();
        if ($res) {
            $result = $res->toArray();
            return $result;
        } else {
            return $res;
        }
    }

    public function getScheduleListByPage($map = [],  $order = 'id desc', $paginate = 10)
    {
        $result = $this->scheduleModel->where($map)->order($order)->paginate($paginate)->each(
            function($item, $key){
                $item->student_strs = unserialize($item->student_str);    
            });
        if ($result) {
            $list = $result->toArray();
            return $list;
        } else {
            return $result;
        }
    }

    // 发布课时
    public function createSchedule($data)
    {
        //dump($data);die;
        // 查询权限
        $is_power = $this->isPower($data['camp_id'], $data['member_id']);
        if ($is_power < 2) {
            return ['code' => 100, 'msg' => __lang('MSG_403')];
        }
        if($data['assistants']){
            $doms = explode(',', $data['assistants']);
            $seria = serialize($doms);
            $data['assistant'] = $seria;
        }else{
            $data['assistant'] = '';
        }
        if($data['assistant_ids']){
            $doms = explode(',', $data['assistant_ids']);
            $seria = serialize($doms);
            $data['assistant_id'] = $seria;
        }else{
            $data['assistant_id'] = '';
        }
        if (!isset($data['status'])) {
            $data['status'] = -1;
        }
        /*$validate = validate('ScheduleVal');
        if (!$validate->check($data)) {
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $model->allowField(true)->save($data);
        if ($result === false) {
            return ['msg' => $this->scheduleModel->getError(), 'code' => 100];
        } else {
            db('camp')->where(['id'=>$data['camp_id']])->setInc('total_schedule');
            return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$result];
        }*/
        $model = new Schedule();
        // 验证数据
        $validate = validate('ScheduleVal');
        if (!$validate->scene('add')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 保存数据 
        $result = $model->allowField(true)->save($data);
        if ($result) {
            db('camp')->where(['id'=>$data['camp_id']])->setInc('total_schedule');
            return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$model->getLastInsID()];
        } else {
            return ['msg' => $model->getError(), 'code' => 100];
        }
    }

    // 修改课时
    public function updateSchedule($data, $id)
    {
        $scheduleInfo = $this->getScheduleInfo(['id'=>$id]);
        // 是否已被审核通过
        if($scheduleInfo['status'] == 1){
            // 判断权限
            return ['code' => 100, 'msg' => '已审核通过的课时不允许编辑'];
            
        }else{
            // 查询权限
            $is_power = $this->isPower($data['camp_id'], $data['member_id']);

            if ($is_power < 2) {
                return ['code' => 100, 'msg' => __lang('MSG_403')];
            }
        }
        if($data['assistants']){
            $doms = explode(',', $data['assistants']);
            $seria = serialize($doms);
            $data['assistant'] = $seria;
        }else{
            $data['assistant'] = '';
        }
        if($data['assistant_ids']){
            $doms = explode(',', $data['assistant_ids']);
            $seria = serialize($doms);
            $data['assistant_id'] = $seria;
        }else{
            $data['assistant_id'] = '';
        }
        $validate = validate('ScheduleVal');
        if (!$validate->check($data)) {
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        /*$result = $this->scheduleModel->save($data, ['id' => $id]);
        if ($result === false) {
            return ['msg' => $this->scheduleModel->getError(), 'code' => 100];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }*/
        $model = new Schedule();
        // 保存数据
        $result = $model->allowField(true)->save($data, ['id' => $id]);
        if ($result || ($result === 0)) {
            return ['msg'=>__lang('MSG_200'),'code'=>200];
        } else {
            return ['msg' => $model->getError(), 'code' => 100];
        }
    }

    // 保存课时-会员关系表(学员、教练)
    public function saveScheduleMember($schedule_id)
    {
        $schedule = db('schedule')->where('id', $schedule_id)->find();
        if (!$schedule) {
            return ['code' => 100, 'msg' => '课时' . __lang('MSG_404')];
        }
        $res = false;

        $students = unserialize($schedule['student_str']);
        // 检查课时相关学员剩余课时
        $checkStudentRestscheduleResult = $this->checkstudentRestschedule($students, $schedule);
        if ($checkStudentRestscheduleResult['code'] == 100) {
            return $checkStudentRestscheduleResult;
        }
        // 课时相关学员剩余课时-1
        $decStudentRestscheduleResult = $this->decStudentRestschedule($students, $schedule);
        if ($decStudentRestscheduleResult['code'] != 200) {
            return $decStudentRestscheduleResult;
        }

        $model = new ScheduleMember();

        // 记录学员
        $studentDatalist = [];
        foreach ($students as $student) {
            $datatmp = [
                'schedule_id' => $schedule_id,
                'schedule' => $schedule['grade'],
                'camp_id' => $schedule['camp_id'],
                'camp' => $schedule['camp'],
                'lesson_id' => $schedule['lesson_id'],
                'lesson' => $schedule['lesson'],
                'grade_id' => $schedule['grade_id'],
                'grade' => $schedule['grade'],
                'user_id' => $student['student_id'],
                'user' => $student['student'],
                'type' => 1,
                'status' => 1,
                'schedule_time' => $schedule['lesson_time']
            ];
            array_push($studentDatalist, $datatmp);
            unset($datatmp);
        }
        $savestudentResult = $model->saveAll($studentDatalist);
        if (!$savestudentResult) {
            return ['code' => 100, 'msg' => '记录学员课时数据异常，请重试'];
        }

        // 记录教练
        $coachDatalist = [];
        if ($schedule['coach_id']) {
            $datatmp = [
                'schedule_id' => $schedule_id,
                'schedule' => $schedule['grade'],
                'camp_id' => $schedule['camp_id'],
                'camp' => $schedule['camp'],
                'user_id' => $schedule['coach_id'],
                'user' => $schedule['coach'],
                'type' => 2,
                'status' => 1,
                'schedule_time' => $schedule['lesson_time']
            ];
            array_push($coachDatalist, $datatmp);
            unset($datatmp);
        }
        $assistantIdArray = unserialize($schedule['assistant_id']) ;
        $assistantArray = unserialize($schedule['assistant']);
        if (!empty($assistantIdArray)) {
            foreach ($assistantIdArray as $key => $val) {
                if ($val) {
                    $datatmp = [
                        'schedule_id' => $schedule_id,
                        'schedule' => $schedule['grade'],
                        'camp_id' => $schedule['camp_id'],
                        'camp' => $schedule['camp'],
                        'user_id' => $val,
                        'user' => $assistantArray[$key],
                        'type' => 2,
                        'status' => 1,
                        'schedule_time' => $schedule['lesson_time']
                    ];
                    array_push($coachDatalist, $datatmp);
                    unset($datatmp);
                }
            }
        }
        $savecoachResult = $model->saveAll($coachDatalist);
        if (!$savecoachResult) {
            return ['code' => 100, 'msg' => '记录教练数据异常，请重试'];
        }

        // 更新课时数据为已申状态
        $update = db('schedule')->where('id', $schedule_id)->update(['status' => 1,'update_time' => time()]);
        if (!$update) {
            return ['code' => 100, 'msg' => '课时记录更新' . __lang('MSG_400')];
        }

        return ['code' => 200, 'msg' => '课时审核'.__lang('MSG_200')];
    }

    // 检查课时相关学员剩余课时是否还有
    protected function checkstudentRestschedule($students, $schedule) {
        $lessonDb = new LessonMember();
        foreach ($students as $student) {
            $gradeMemberWhere['student_id'] = $student['student_id'];
            $gradeMemberWhere['lesson_id'] = $schedule['lesson_id'];
            $gradeMemberWhere['camp_id'] = $schedule['camp_id'];
            $gradeMemberWhere['type'] = 1;
            $studentWhere['id'] = $student['student_id'];
            $restschedule = $lessonDb->where($gradeMemberWhere)->value('rest_schedule');
            // 某个学员无剩余课时 抛出提示
            if (!$restschedule || $restschedule == 0) {
                return ['code' => 100, 'msg' => $student['student'] . '已无剩余课时，请修改课时信息'];
            }
        }
        // 课时所有学员剩余课时数返回code=200
        return ['code' => 200, 'msg' => __lang('MSG_201')];
    }

    /** 课时相关学员剩余课时-1
     * @param $students 学员列表数组
     * [
     * [] => ['id','student_id','student']
     * [] => ['id','student_id','student']
     * ]
     * id 是grade_member表id
     * @return array
     */
    function decStudentRestschedule($students, $schedule) {
        $gradeMemberDb = db('grade_member');
        $lessonDb = new LessonMember();
        $studentDb = new Student();
        $gradeModel = new Grade();
        foreach ($students as $student) {
            $gradeMemberWhere['student_id'] = $student['student_id'];
            $gradeMemberWhere['lesson_id'] = $schedule['lesson_id'];
            $gradeMemberWhere['camp_id'] = $schedule['camp_id'];
            $gradeMemberWhere['type'] = 1;
            $studentWhere['id'] = $student['student_id'];
            $restschedule = $lessonDb->where($gradeMemberWhere)->value('rest_schedule');
            if ($restschedule == 1) {
                // lesson_member剩余课时为0 毕业状态
                $finishSchedule = $lessonDb->where($gradeMemberWhere)->update(['rest_schedule' => 0, 'status' => 4, 'update_time' => time(), 'system_remarks' => date('Ymd').'学员完成课时毕业']);
                if (!$finishSchedule) {
                    return ['code' => 100, 'msg' => $student['student'].'更新剩余课时'.__lang('MSG_400')];
                }
                // 学员档案完成课程数+1
                $studentFinishedTotal = $studentDb->where($studentWhere)->setInc('finished_lesson', 1);
                if (!$studentFinishedTotal) {
                    return ['code' => 100, 'msg' => $student['student'].'更新完成课程'.__lang('MSG_400')];
                }
                // 学员从班级毕业（grade_member数据 status=4）
                $gradeMemberDb->where($gradeMemberWhere)->whereNull('delete_time')->update(['status' => 4, 'update_time' => time(), 'system_remarks' => date('Ymd').'学员完成课时毕业']);
                // 更新学员所在班级学员名单，剔除学员（查询班级其他在班学员名单，更新班级数据）
                $reserveStudentList = $gradeMemberDb->where([ 'grade_id' => $schedule['grade_id'], 'status' => 1 ])->column('student');
                $reserveStudentStr = '';
                if ($reserveStudentList) {
                    foreach ($reserveStudentList as $val) {
                        $reserveStudentStr .= $val.',';
                    }
                    $reserveStudentStr = rtrim($reserveStudentStr, ',');
                }
                $gradeModel->where(['id' => $schedule['grade_id']])->update(['student_str' => $reserveStudentStr, 'students' => count($reserveStudentList)]);
            } else {
                $decRestSchedule = $lessonDb->where($gradeMemberWhere)->setDec('rest_schedule',1);
                if (!$decRestSchedule) {
                    return ['code' => 100, 'msg' => $student['student'].'更新剩余课时'.__lang('MSG_400')];
                }
            }
            $incStudentFinishedSchedule = $studentDb->where($studentWhere)->setInc('finished_schedule', 1);
            if (!$incStudentFinishedSchedule) {
                return ['code' => 100, 'msg' => $student['student'].'更新完成课时'.__lang('MSG_400')];
            }
        }
        return ['code' => 200, 'msg' => __lang('MSG_200')];
    }

    //查看一条课时信息
    public function getScheduleInfo($map)
    {
        $result = $this->scheduleModel->where($map)->find();
        if($result){
            $res = $result->toArray();
            if($res['assistant']){
                $pieces = unserialize($res['assistant']);
                $res['assistants'] = implode(',', $pieces);
            }else{
                $res['assistants'] = '';
            }

            if($res['assistant_id']){
                $pieces = unserialize($res['assistant_id']);
                $res['assistant_ids'] = implode(',', $pieces);
            }else{
                $res['assistant_ids'] = '';
            }
            /*if($res['student_str']){
                $res['student_strs'] = unserialize($res['student_str']);
            }*/
            return $res;
        }else{
            return $result;
        }
        // return $result ? $result->toArray() : false;
    }

    // 统计课时数量
    public function countSchedules($map=[]) {
        $model = new Schedule();
        $count = [];
//        $map['camp_id'] = $camp_id;
        $monthcount = $model->where($map)
            ->whereTime('lesson_time', 'month')->count();
        $yearcount = $model->where($map)
            ->whereTime('lesson_time', 'year')->count();
        $sumcount = $model->where($map)->count();
        $count = ['month' => $monthcount, 'year' => $yearcount, 'sum' => $sumcount];
        return $count;
    }


    // 统计学生课时数量
    public function countScheduleMembers($map=[]) {
        $ScheduleMember = new ScheduleMember();
        $count = [];
//        $map['camp_id'] = $camp_id;
        $monthcount = $ScheduleMember->where($map)
            ->whereTime('schedule_time', 'month')->count();
        $yearcount = $ScheduleMember->where($map)
            ->whereTime('schedule_time', 'year')->count();
        $sumcount = $ScheduleMember->where($map)->count();
        $count = ['month' => $monthcount, 'year' => $yearcount, 'sum' => $sumcount];
        return $count;
    }

    // 获得课时评论
    public function getCommentList($schedule_id, $paginate = 10)
    {
        $model = new ScheduleComment();
        $result = $model->where(['schedule_id' => $schedule_id])->paginate($paginate);
        return $result;
    }

    // 获取课时学生
    public function getStudentList($schedule_id, $page = 1, $paginate = 10)
    {
        $result = db('schedule_member')->where(['schedule_id' => $schedule_id, 'type' => 0, 'status' => 1])->page($page, $paginate)->select();
        return $result;
    }


    // 教练增加课流量并升级
    public function addScheduleLevel($coach_id)
    {
        $result = db('coach')->where(['id' => $coach_id])->setInc('lesson_flow');
        if ($result) {
            $System = new SystemService();
            $setting = $System->getSite();
            $coachLevel = db('coach')->where(['id' => $coach_id])->value('coach_level');
            if ($coachLevel >= $setting['coachlevel8']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }
            if ($coachLevel >= $setting['coachlevel7']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }
            if ($coachLevel >= $setting['coachlevel6']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }
            if ($coachLevel >= $setting['coachlevel5']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }
            if ($coachLevel >= $setting['coachlevel4']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }
            if ($coachLevel >= $setting['coachlevel3']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }
            if ($coachLevel >= $setting['coachlevel2']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }
            if ($coachLevel >= $setting['coachlevel1']) {
                db('coach')->save(['coach_level' => 8], $coach_id);
                return true;
            }

            return false;
        }
        file_put_contents(ROOT_PATH . '/data/coachlevel/' . date('Y-m-d', time()) . '.txt', json_encode(['error' => '未成功返回课流量,教练id为:' . $coach_id, 'time' => date('Y-m-d H:i:s', time())]));
        return false;
    }


    // 课程权限
    public function isPower($camp_id, $member_id)
    {
        $is_power = db('camp_member')
            ->where([
                'camp_id' => $camp_id,
                'status' => 1,
                'member_id' => $member_id,
            ])
            ->value('type');

        return $is_power ? $is_power : 0;

    }


    // 课时评分
    public function starSchedule($data)
    {
        $ScheduleComment = new \app\model\ScheduleComment;
        $validate = validate('ScheduleCommentVal');
        if (!$validate->check($data)) {
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $isSchedule = $ScheduleComment->where(['member_id' => $data['member_id'], 'schedule_id' => $data['schedule_id']])->find();
        if ($isSchedule) {
            return ['code' => 100, 'msg' => '您已经评论过此课时'];
        } else {
            $result = $ScheduleComment->allowField(true)->save($data);
            if ($result) {
                // 更新训练营评分、教练评分
                db('camp')->where(['id' => $data['camp_id']])->inc('star', $data['avg_star'])->inc('star_num',1)->update();
                $this->updateCoachStar($data['schedule_id'],$data['avg_star']);
                return ['code' => 200, 'msg' => '评论成功'];
            } else {
                return ['code' => 100, 'msg' => '评论失败'];
            }
        }
    }

    // 能否课时评分
    public function canStarSchedule($schedule_id, $member_id) {
        $students = db('student')->where('member_id', $member_id)->column('id');
        $scheduleMember = db('schedule_member')->where(['schedule_id' => $schedule_id, 'type' => 1])->column('user_id');
        if (array_intersect($students, $scheduleMember)) {
            return true;
        } else {
            return false;
        }
    }

    // 课时评分更新课时相关教练评分
    public function updateCoachStar($schedule_id, $star) {
        // 获取课时教练名单
        $coachs = $this->getScheduleCoachList($schedule_id);
        // 遍历更新教练评分
        $coachDb = db('coach');
        if (!empty($coachs)) {
            foreach ($coachs as $coach) {
                $coachDb->where(['id' => $coach['coach_id']])->inc('star', $star)->inc('star_num', 1)->update();
            }
        }
    }

    // 获取课时的教练名单（主教练+助教练）
    public function getScheduleCoachList($schedule_id) {
        // 查询课时数据
        $schedule = db('schedule')->where('id', $schedule_id)->find();
        $coachs = [];
        // 获取主教练
        if ($schedule['coach_id']) {
            array_push($coachs, ['coach_id' => $schedule['coach_id'], 'coach' => $schedule['coach'], 'coach_type' => 1]);
        }
        // 获取助教练，反序列化处理
        $assistantIdArray = unserialize($schedule['assistant_id']) ;
        $assistantArray = unserialize($schedule['assistant']);
        if (!empty($assistantIdArray)) {
            foreach ($assistantIdArray as $key => $val) {
                if ($val) {
                    array_push($coachs, ['coach_id' => $val, 'coach' => $assistantArray[$key], 'coach_type' => 2]);
                }
            }
        }
        return $coachs;
    }

    // 删除课时
    public function delSchedule($id) {
        return Schedule::destroy($id);
    }

    public function getScheduleStudentMemberList($schedule_id) {
        $schedulemember = ScheduleMember::where(['schedule_id' => $schedule_id, 'type' => 1])->select()->toArray();

        $list = [];
        foreach ($schedulemember as $key => $val) {
            $student = Student::where(['id' => $val['user_id']])->find()->toArray();
            $list[$key] = [
                'member_id' => $student['member_id'],
                'openid' => getMemberOpenid($student['member_id'])
            ];
        }
        return $list;
    }

    // 购买赠送课时
    public function buygift($request) {
        $model = new ScheduleGiftbuy;
        $validate = validate('ScheduleGiftbuyVal');
        if (!$validate->check($request)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        $result = $model->allowField(true)->save($request);
        if (!$result) {
            return ['code' => 100, 'msg' => '购买赠送课时'.__lang('MSG_400')];
        } else {
            return ['code' => 200, 'msg' => '购买赠送课时'.__lang('MSG_200'), 'insid' => $model->id];
        }
    }

    // 购买赠送课时列表
    public function buygiftpage($map=[], $page=1, $order='id desc', $limit=10) {
        $model = new ScheduleGiftbuy;
        $list = $model->with('lesson')->where($map)->order($order)->page($page, $limit)->select();
        if ($list) {
            return ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list->toArray()];
        } else {
            return ['code' => 100, 'msg' => __lang('MSG_000')];
        }
    }

    // 购买赠送课时详情
    public function getbuygift($map) {
        $model = new ScheduleGiftbuy;
        $result = $model->with('lesson')->where($map)->find()->toArray();
        return $result;
    }

    // 赠送课时给学员
    public function recordgift($request) {
        //dump($request);
        $model = new ScheduleGiftrecord();
        $validate = validate('ScheduleGiftrecordVal');
        if (!$validate->check($request)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        $result = $model->allowField(true)->save($request);
        if (!$result) {
            return $result;
        } else {
            return $model->getLastInsID();
        }
    }

    // 批量更新学员剩余课时
    public function saveStudentRestschedule($map, $gift_schedule){
        // 更新lesson_member课时数字段
        //$lessonMemberRestSchedule = Db::name('lesson_member')->where($map)->whereNull('delete_time')->setInc('rest_schedule', $gift_schedule);
        $lessonMemberRestSchedule = db('lesson_member')->where($map)->whereNull('delete_time')->inc('rest_schedule', $gift_schedule)->inc('total_schedule', $gift_schedule)->update();
        $studentTotalSchedule = db('student')->where(['id' => $map['student_id']])->whereNull('delete_time')->setInc('total_schedule', $gift_schedule);
        if (!$lessonMemberRestSchedule || !$studentTotalSchedule ) {
            return false;
        } else {
            return true;
        }
    }

    // 保存赠课与学员关系
    public function saveAllScheduleGiftStudent($data) {
        $model = new ScheduleGiftStudent();
        $res = $model->saveAll($data);
        if ($res) {
            return $res;
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return $res;
        }
    }


    // 赠送课时列表
    public function giftpage($map=[], $page=1, $order='id desc', $limit=10) {
        $model = new ScheduleGiftrecord();
        $list = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($list) {
            return ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list->toArray()];
        } else {
            return ['code' => 100, 'msg' => __lang('MSG_000')];
        }
    }

    // 赠送课时详情
    public function getGiftRecordInfo($map) {
        $model = new ScheduleGiftrecord();
        $result = $model->where($map)->find()->toArray();
        return $result;
    }

    // 课时结算的收入统计
    public function scheduleIncome($map) {
        $model = new Schedule();
        if (isset($map['create_time'])) {
            $map['lesson_time'] = $map['create_time'];
            unset($map['create_time']);
        }
        $map['status'] = 1;
        $map['is_settle'] = 1;
        $schedules = $model->where($map)->select();
        $sum = 0;
        if ($schedules) {
            $schedules = $schedules->toArray();
            //dump($schedules);
            foreach ($schedules as $schedule) {
                $sum += $schedule['schedule_income'];
            }
            return $sum;
        } else {
            return $sum;
        }
    }
}