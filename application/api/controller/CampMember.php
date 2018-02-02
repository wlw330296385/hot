<?php

namespace app\api\controller;

use app\api\controller\Base;
use app\model\MessageMember;
use app\service\CampService;
use app\service\CoachService;
use app\service\MessageService;
use app\service\StudentService;
use app\service\WechatService;
use think\Db;
use think\Exception;

class CampMember extends Base
{
    protected $CampService;

    public function _initialize()
    {
        parent::_initialize();
        $this->CampService = new CampService;
    }

    // 关注训练营
    public function focusApi()
    {
        $camp_id = input('param.camp_id');
        $remarks = input('param.remarks');
        // 插入follow数据
        $followDb = db('follow');
        $hasFollow = $followDb->where(['type' => 2, 'follow_id' => $campInfo['id'], 'member_id' => $this->memberInfo['id']])->find();
        if ($hasFollow) {
            if ($hasFollow['status'] == -1) {
                $followDb->where('id', $hasFollow)->update(['status' => 1, 'update_time' => time()]);
            }
        } else {
            $followDb->insert([
                'type' => 2, 'status' => 1,
                'follow_id' => $campInfo['id'], 'follow_name' => $campInfo['camp'], 'follow_avatar' => $campInfo['logo'],
                'member_id' => $this->memberInfo['id'], 'member' => $this->memberInfo['member'], 'member_avatar' => $this->memberInfo['avatar'],
                'create_time' => time(), 'update_time' => time()
            ]);
        }
        return json(['code' => 200, 'msg' => $msg]);
        
    }

    // 申请成为训练营的某个身份
    public function applyApi()
    {
        try {
            $type = input('param.type');
            $camp_id = input('param.camp_id');
            $remarks = input('param.remarks');
            $campInfo = $this->CampService->getCampInfo($camp_id);
            if (!$campInfo) {
                return json(['code' => 100, 'msg' => '不存在此训练营']);
            }
            if (!$type || $type > 3 || $type < -1) {
                return json(['code' => 100, 'msg' => '不存在这个身份']);
            }
            //是否已存在身份
            $isType = db('camp_member')->where(['member_id' => $this->memberInfo['id'], 'camp_id' => $camp_id])->find();
            // 存在身份
            if ($isType) {
                // 升级身份
                if ($type > $isType['type']) {  
                    
                    $data['id'] = $isType['id'];
                    if ($type == 2) {// 必须要有教练资格
                        $coachS = new CoachService();
                        $coach = $coachS->coachInfo(['member_id' => $this->memberInfo['id']]);
                        if (!$coach && $coach['status_num'] != 1) {
                            return json(['code' => 101, 'msg' => '请先注册教练资格', 'goto' => url('frontend/coach/createcoach')]);
                        }
                    }
                    $status = 0;
                    $data = [
                        'camp_id' => $campInfo['id'],
                        'camp' => $campInfo['camp'],
                        'member_id' => $this->memberInfo['id'],
                        'member' => $this->memberInfo['member'],
                        'remarks' => $remarks,
                        'type' => $type,
                        'status' => $status
                    ];
                    // 改写身份
                    $model = new \app\model\CampMember();
                    $result = $model->save($data,['id'=>$isType['id']]);
                //降低身份?
                }else {
                    if ($isType['status'] == 1) {
                        return json(['code' => 100, 'msg' => '你已经是训练营的一员']);
                    }else{
                        return json(['code' => 100, 'msg' => '重复申请']);
                    } 
                }
                $id = $isType['id'];
            // 不存在身份
            }else{
                $status = 0;
                $data = [
                    'camp_id' => $campInfo['id'],
                    'camp' => $campInfo['camp'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'remarks' => $remarks,
                    'type' => $type,
                    'status' => $status
                ];
                // 插入身份
                $model = new \app\model\CampMember();
                $result = $model->save($data);
                $id = $model->id;
            }

             
            // 操作成功
            if ($result) {
                // 插入follow数据
                $followDb = db('follow');
                $hasFollow = $followDb->where(['type' => 2, 'follow_id' => $campInfo['id'], 'member_id' => $this->memberInfo['id']])->find();
                if ($hasFollow) {
                    if ($hasFollow['status'] == -1) {
                        $followDb->where('id', $hasFollow)->update(['status' => 1, 'update_time' => time()]);
                    }
                } else {
                    $followDb->insert([
                        'type' => 2, 'status' => 1,
                        'follow_id' => $campInfo['id'], 'follow_name' => $campInfo['camp'], 'follow_avatar' => $campInfo['logo'],
                        'member_id' => $this->memberInfo['id'], 'member' => $this->memberInfo['member'], 'member_avatar' => $this->memberInfo['avatar'],
                        'create_time' => time(), 'update_time' => time()
                    ]);
                }
                return json(['code' => 200, 'msg' => '申请成功', 'insid' => $id]);
            } else {
                return json(['code' => 100, 'msg' => '申请失败']);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 训练营人员审核
    public function ApproveApplyApi()
    {
        try {
            $id = input('param.id');
            $status = input('param.status');
            if (!$id || !$status) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $campMemberInfo = db('camp_member')->where(['id' => $id, 'status' => 0])->find();
            if (!$campMemberInfo) {
                return json(['code' => 100, 'msg' => '不存在该申请']);
            }
            $isPower = $this->CampService->isPower($campMemberInfo['camp_id'], $this->memberInfo['id']);
            if ($isPower < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }
            if ($campMemberInfo['status'] != 0) {
                return json(['code' => 100, 'msg' => '该申请已操作，无须重复操作']);
            }

            $result = db('camp_member')->where(['id' => $id])->update(['status' => $status, 'update_time' => time()]);
            if ($result) {
                return json(['code' => 200, 'msg' => __lang('MSG_200')]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    //训练营人员变更
    public function modifyApi()
    {
        try {
            $id = input('param.id');
            $type = input('param.type');
            if (!$id || !$type || ($type != 2 || $type != 5 || $type != 3)) {
                return json(['code' => 200, 'msg' => __lang('MSG_402')]);
            }

            $campMemberInfo = db('camp_member')->where(['id' => $id, 'status' => 1])->find();
            if (!$campMemberInfo) {
                return json(['code' => 100, 'msg' => '不存在该人员']);
            }
            $isPower = $this->CampService->isPower($campMemberInfo['camp_id'], $this->memberInfo['id']);

            if ($isPower < 4) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }

            $result = db('camp_member')->where(['id' => $id])->update(['type' => $type]);
            if ($result) {
                return json(['code' => 200, 'msg' => __lang('MSG_200')]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取一条记录
    public function getCampMemberApi()
    {
        try {
            $camp_id = input('param.camp_id');
            $member_id = input('param.member_id') ? input('param.member_id') : $this->memberInfo['id'];
            $CampMember = new  \app\model\CampMember;
            $result = $CampMember->where(['member_id' => $member_id, 'camp_id' => $camp_id])->find();
            if ($result) {
                return json(['code' => 200, 'msg' => 'OK', 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . __lang('MSG_403')]);
            }

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    // 获取有教练身份的训练营员工（没分页、可模糊查询）
    public function getCoachListApi()
    {
        try {
            $camp_id = input('param.camp_id');
            $keyword = input('param.keyword');
            $status = input('param.status', 1);
            if (!empty($keyword) && $keyword != ' ' && $keyword != '') {
                $map['coach.coach'] = ['LIKE', '%' . $keyword . '%'];
                $map['coach.status'] = 1;
            }

            $map['camp_id'] = $camp_id;
            $map['camp_member.status'] = $status;
            $map['camp_member.type'] = ['in', '2,4'];
            $list = Db::view('camp_member', ['id' => 'campmemberid', 'camp_id'])
                ->view('coach', '*', 'coach.member_id=camp_member.member_id')
                ->where($map)
                ->select();
            foreach ($list as $k => $val) {
                if ($val['star'] > 0) {
                    $list[$k]['star'] = ceil($val['star']/$val['star_num']);
                }
            } 
            return ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list];
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    //自定义获取训练营身份列表分页（有页码）
    public function getCampMemberListByPageApi()
    {
        try {
            $map = input('post.');
            $keyword = input('param.keyword');
            if (!empty($keyword) && $keyword != ' ' && $keyword != '') {
                $map['member'] = ['LIKE', '%' . $keyword . '%'];
            }
            if (isset($map['keyword'])) {
                unset($map['keyword']);
            }
            if (isset($map['page'])) {
                unset($map['page']);
            }
            $CampMember = new  \app\model\CampMember;
            $result = $CampMember->with('coach')->where($map)->paginate(10);
            if ($result) {
                return json(['code' => 200, 'msg' => 'OK', 'data' => $result->toArray()]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . __lang('MSG_403')]);
            }
        } catch (Exception $e) {
            return json(['code' => 200, 'msg' => $e->getMessage()]);
        }
    }


    //自定义获取训练营身份列表分页（无分页）
    public function getCampMemberListNoPageApi()
    {
        try {
            $map = input('post.');
            $keyword = input('param.keyword');
            $type = input('param.type');
            if (!empty($keyword) && $keyword != ' ' && $keyword != '') {
                $map['member'] = ['LIKE', '%' . $keyword . '%'];
            }
            if (isset($map['keyword'])) {
                unset($map['keyword']);
            }
            if (isset($map['page'])) {
                unset($map['page']);
            }
            if(!empty($type) && $type != ' ' && $type != ''){
                $map['type'] = ['egt',$type];
            }
            $CampMember = new  \app\model\CampMember;
            $result = $CampMember->where($map)->select();
            if ($result) {
                return json(['code' => 200, 'msg' => 'OK', 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . __lang('MSG_403')]);
            }
        } catch (Exception $e) {
            return json(['code' => 200, 'msg' => $e->getMessage()]);
        }
    }

    //自定义获取训练营身份列表有分页
    public function getCampMemberListApi()
    {
        try {
            $map = input('post.');
            $keyword = input('param.keyword');
            if (!empty($keyword) && $keyword != ' ' && $keyword != '') {
                $map['member'] = ['LIKE', '%' . $keyword . '%'];
            }
            $page = input('param.page');
            if (isset($map['keyword'])) {
                unset($map['keyword']);
            }
            if (isset($map['page'])) {
                unset($map['page']);
            }
            $result = $this->CampService->getCampMemberListByPage($map);
            if ($result) {
                return json(['code' => 200, 'msg' => 'OK', 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . __lang('MSG_403')]);
            }
        } catch (Exception $e) {
            return json(['code' => 200, 'msg' => $e->getMessage()]);
        }
    }

    /** 解除训练营-人员关联 2017/09/27
     * $id: input('campmemberid') camp_member表主键
     * @return array|\think\response\Json
     */
    public function removerelationship()
    {
        try {
            $id = input('campmemberid');
            $model = new \app\model\CampMember();
            $campmember = $model->where(['id' => $id])->find();
            if ($campmember->getData('type') == 4 && $campmember->member_id == $this->memberInfo['id']) {
                return json(['code' => 100, 'msg' => '你是营主不能删除自己']);
            }

            $campS = new CampService();
            // 操作权限
            $power = $campS->isPower($campmember['camp_id'], $this->memberInfo['id']);
            if ($power < 3) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }

            // 删教练 检查是否在营有班级
            if ($campmember->getData('type') == 2) {
                $coachS = new CoachService();
                $coach = $coachS->getCoachInfo(['member_id' => $campmember['member_id']]);
                $grade = $coachS->ingradelist($coach['id'], $campmember['camp_id']);
                if ($grade) {
                    return json(['code' => 100, 'msg' => '该教练有班级记录,请先修改班级记录主教练/助教练']);
                }
                $lesson = $coachS->inlessonlist($coach['id'], $campmember['camp_id']);
                if ($lesson) {
                    return json(['code' => 100, 'msg' => '该教练有课程记录,请先修改课程记录主教练/助教练']);
                }
            }

            $campmember->status = -1;
            $result = $campmember->save();
            if ($result) {
                $memberopenid = getMemberOpenid($campmember['member_id']);
                // 发送模板消息
                $sendTemplateData = [
                    'touser' => $memberopenid,
                    'template_id' => 'anBmKL68Y99ZhX3SVNyyX6hrtzhlDW3RrB-vB6_GmqM',
                    'url' => url('frontend/index/index', '', '', true),
                    'data' => [
                        'first' => ['value' => '您好, 您所在的' . $campmember['camp'] . '的' . $campmember['type'] . '身份被移除了'],
                        'keyword1' => ['value' => $campmember['member']],
                        'keyword2' => ['value' => '训练营营主或管理员移除'],
                        'keyword3' => ['value' => date('Y年m月d日 H时i分')]
                    ]
                ];
                $wechatS = new WechatService();
                $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
                $log_sendTemplateData = [
                    'wxopenid' => $memberopenid,
                    'member_id' => $campmember['member_id'],
                    'url' => $sendTemplateData['url'],
                    'content' => serialize($sendTemplateData),
                    'create_time' => time()
                ];
                if ($sendTemplateResult) {
                    $log_sendTemplateData['status'] = 1;
                } else {
                    $log_sendTemplateData['status'] = 0;
                }
                db('log_sendtemplatemsg')->insert($log_sendTemplateData);

                // 发送站内消息
                $modelMessageMember = new MessageMember();
                $modelMessageMember->save([
                    'title' => $sendTemplateData['data']['first']['value'],
                    'content' => $sendTemplateData['data']['first']['value'],
                    'member_id' => $campmember['member_id'],
                    'status' => 1,
                    'url' => $sendTemplateData['url']
                ]);

                $response = json(['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $result]);
            } else {
                $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            return $response;
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    // 邀请加入训练营
    public function invate()
    {
        $data = input('post.');
        $isMember = $this->CampService->getCampMemberInfo($data);
        if ($isMember) {
            return json(['msg' => '他已经申请加入训练题']);
        }
    }

    // 训练营学生列表
    public function campstudentlist()
    {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            if (isset($map['page'])) {
                unset($map['page']);
            }
            // 关键字搜索学员名
            $keyword = input('param.keyword');
            if (isset($keyword)) {
                if (!empty($keyword)) {
                    if (!ctype_space($keyword)){
                        // 关键字不为空 组合查询条件
                        $map['student.student'] = ['like', "%$keyword%"];
                    }
                }
                unset($map['keyword']);
            }
            // keyword == null 处理
            if ($keyword == null) {
                unset($map['keyword']);
            }

            $map['camp_member.type'] = input('param.type', 1);
            $map['camp_member.status'] = input('param.status', 1);
            $list = Db::view('camp_member')
                ->view('student', ['id' => 'student_id', 'student', 'student_sex', 'student_avatar'], 'student.member_id=camp_member.member_id')
                ->order('camp_member.id desc')
                ->where($map)->page($page, 10)->select();

            if (empty($list)) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 训练营学生列表 带页码
    public function campstudentpage()
    {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            if (isset($map['page'])) {
                unset($map['page']);
            }
            // 关键字搜索学员名
            $keyword = input('param.keyword');
            if (isset($keyword)) {
                if (!empty($keyword)) {
                    if (!ctype_space($keyword)){
                        // 关键字不为空 组合查询条件
                        $map['student.student'] = ['like', "%$keyword%"];
                    }
                }
                unset($map['keyword']);
            }
            // keyword == null 处理
            if ($keyword == null) {
                unset($map['keyword']);
            }
            $map['camp_member.type'] = input('param.type', 1);
            $map['camp_member.status'] = input('param.status', 1);
            $list = Db::view('camp_member')
                ->view('student', ['id' => 'student_id', 'member_id', 'student', 'student_sex', 'student_avatar'], 'student.member_id=camp_member.member_id')
                ->order('camp_member.id desc')
                ->where($map)->paginate(10);
            //dump($list);
            if ($list->isEmpty()) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list->toArray()]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    // 训练营未操作学生
    public function pendstudentlist()
    {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            //$map['type'] = input('param.type', 1);
            if (isset($map['page'])) {
                unset($map['page']);
            }
            $keyword = input('param.keyword');
            if (!empty($keyword) && $keyword != "" && $keyword != " ") {
                $where['lesson_member.student'] = ['like', "%$keyword%"];
                unset($map['keyword']);
            }
            if (isset($map['status'])) {
                $where['lesson_member.status'] = $map['status'];
            }

            $where['lesson_member.camp_id'] = $map['camp_id'];
            $where['grade_id'] = 0;
            $list = Db::view('lesson_member')
                ->view('student', ['id' => 'studentid', 'member_id', 'student', 'student_sex', 'student_avatar'], 'student.member_id=lesson_member.member_id')
                ->where($where)->page($page, 10)->select();
            if (empty($list)) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 训练营 学生在营/离营操作
    public function removestudent()
    {
        try {
            $student_id = input('param.student_id', 0);
            $camp_id = input('param.camp_id', 0);
            $action = input('param.action');
            if (!$action || !$student_id || !$camp_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $power = getCampPower($camp_id, $this->memberInfo['id']);
            if ($power < 3) { // 管理员以上才能操作
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }

            $studentS = new StudentService();
            $studentInfo = $studentS->getStudentInfo(['id' => $student_id]);
//            dump($studentInfo);
            $model = new \app\model\CampMember();
            $campmember = $model->where(['camp_id' => $camp_id, 'member_id' => $studentInfo['member_id']])->find()->toArray();
            // 如果学员有离营申请记录，可直接进行离营操作；否则先检查剩余课时
            $studentleaveappply = db('camp_leaveapply')->where(['camp_id' => $camp_id, 'member_id' => $studentInfo['member_id']])->find();
            // 学员有剩余课时 不允许操作
            $studentLessons = $studentS->getLessons(['camp_id' => $camp_id, 'student_id' => $studentInfo['id'], 'member_id' => $studentInfo['member_id']]);
            //dump($studentLessons);
            $isStudentRestSchedule = 0;
            $isStudentLeave = 0;
            foreach ($studentLessons as $studentLesson) {
                if ($studentLesson['lesson_member_status'] == -1) {
                    $isStudentLeave = 1;
                }
                if ($studentLesson['rest_schedule'] > 0) {
                    $isStudentRestSchedule = 1;
//                    continue;
                }
            }
            // 学员在有效数据的班级中
            $studentGrades = $studentS->getGrades(['camp_id' => $camp_id, 'student_id' => $studentInfo['id'], 'member_id' => $studentInfo['member_id']]);
            $isStudentInGrade = 0;
            foreach ($studentGrades as $studentGrade) {
                if ($studentGrade['grade_member_status'] == 1) {
                    $isStudentInGrade =1;
//                    continue;
                }
            }
            //dump($isStudentLeave);
            $lessonmemberM = new \app\model\LessonMember();
            $gradememberM = new \app\model\GradeMember();
            if ($isStudentLeave) {
                $updateLessonmember = $lessonmemberM->where(['camp_id' => $camp_id, 'student_id' => $studentInfo['id'], 'member_id' => $studentInfo['member_id']])->setField('status', 1);
                if (!$updateLessonmember)  {
                    return json(['code' => 100, 'msg' => '学员设为在营'.__lang('MSG_400')]);
                } else {
                    $studentLessonAllLeave = $studentS->getLessons(['camp_id' => $camp_id, 'member_id' => $studentInfo['member_id'], 'status' => 1]);
                    if ($studentLessonAllLeave) {
                        $model->update(['id' => $campmember['id'], 'status' => 1, 'update_time' => time()]);
                    }
                    return json(['code' => 200, 'msg' => '学员设为在营'.__lang('MSG_200')]);
                }
            } else { // 执行离营
                if (!$studentleaveappply) {
                    if ($isStudentRestSchedule) {
                        return json(['code' => 100, 'msg' => __lang('MSG_400') . '，该学员在训练营课时尚未完成']);
                    }
                }

                if ($isStudentInGrade) {
                    return json(['code' => 100, 'msg' => __lang('MSG_400') . '，该学员在训练营班级中，请先将学员移出班级']);
                }

                // lesson_member、grade_member status=-1 学员离营
                $studentleave1 = $lessonmemberM->where(['camp_id' => $camp_id, 'student_id' => $studentInfo['id'], 'member_id' => $studentInfo['member_id']])->setField('status', -1);
                $studentleave2 = $gradememberM->where(['camp_id' => $camp_id, 'student_id' => $studentInfo['id'], 'member_id' => $studentInfo['member_id']])->setField('status', -1);
                if (!$studentleave1 && !$studentleave2) {
                    return json(['code' => 100, 'msg' => '学员设为离营' . __lang('MSG_400')]);
                } else {
                    $studentLessonAllLeave = $studentS->getLessons(['camp_id' => $camp_id, 'member_id' => $studentInfo['member_id'], 'status' => -1]);
                    if ($studentLessonAllLeave) {
                        $model->update(['id' => $campmember['id'], 'status' => -1, 'update_time' => time()]);
                    }
                    return json(['code' => 200, 'msg' => '学员设为离营' . __lang('MSG_200')]);
                }
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 训练营教务人员列表
    public function teachlist()
    {
        try {
            $map = input('param.');
            $keyword = input('param.keyword');
            if (!empty($keyword) && $keyword != "" && $keyword != " ") {
                $where['member.member'] = ['like', "%$keyword%"];
                unset($map['keyword']);
            }
            if (isset($map['page'])) {
                unset($map['page']);
            }
            $page = input('param.page', 1);
            $where['camp_member.camp_id'] = $map['camp_id'];
            $where['camp_member.type'] = 3;
            $where['camp_member.status'] = $map['status'];
            $list = Db::view('camp_member', ['id' => 'campmemberid', 'camp_id', 'member_id', 'status'])
                ->view('member', ['id', 'member', 'sex', 'avatar', 'province', 'city', 'area'], 'camp_member.member_id=member.id', 'LEFT')
                ->where($where)
                ->page($page, 10)
//                ->fetchSql(true)
                ->select();

//            dump($list);
            if (empty($list)) {
                return json(['code' => 200, 'msg' => __lang('MSG_000'), 'data' => []]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}

