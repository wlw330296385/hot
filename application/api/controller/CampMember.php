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

            // 申请加入教练必须有已审核的教练员资格
            if ($type == 2) {
                $coachS = new CoachService();
                $coachInfo = $coachS->coachInfo(['member_id' => $this->memberInfo['id']]);
                if (!$coachInfo && $coachInfo['status_num'] != 1) {
                    return json(['code' => 101, 'msg' => '请先注册教练资格', 'goto' => url('frontend/coach/createcoach')]);
                }
            }

            // 查询会员与训练营有无camp_member数据
            $db = db('camp_member');
            $campMemberInfo = $db->where(['camp_id' => $camp_id, 'member_id' => $this->memberInfo['id']])->whereNull('delete_time')->find();
            $status = 0;
            if ($campMemberInfo) {
                $campMemberId = $campMemberInfo['id'];
                // 营主不能改变
                if ($campMemberInfo['type'] == 4) {
                    return json(['code' => 100, 'msg' => '你是训练营营主，不需申请加入']);
                }
                // 若有camp_member数据 status=-1的话更新status=1
                if ($type == $campMemberInfo['type']) {
                    if ($campMemberInfo['status'] == 1) {
                        return json(['code' => 100, 'msg' => '你已经是训练营的一员']);
                    } elseif ($campMemberInfo['status'] == -1) {
                        $result = $db->update([
                            'id' => $campMemberId,
                            'status' => $status
                        ]);
                    } else {
                        return json(['code' => 100, 'msg' => '您已提交加入申请，请等待训练营审核']);
                    }
                } else {
                    // type改变只能增大
                    if ($type > $campMemberInfo['type']) {
                        // 改变角色等级
                        $data = [
                            'id' => $campMemberId,
                            'camp_id' => $campInfo['id'],
                            'camp' => $campInfo['camp'],
                            'member_id' => $this->memberInfo['id'],
                            'member' => $this->memberInfo['member'],
                            'remarks' => $remarks,
                            'type' => $type,
                            'status' => $status,
                            'update_time' => time()
                        ];
                        $result = $db->update($data);
                    } else {
                        return json(['code' => 100, 'msg' => '你已经是训练营的一员']);
                    }
                }
            } else {
                // 插入新数据
                $data = [
                    'camp_id' => $campInfo['id'],
                    'camp' => $campInfo['camp'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'remarks' => $remarks,
                    'type' => $type,
                    'status' => $status,
                    'create_time' => time(),
                    'update_time' => time()
                ];
                $result = $db->insert($data);
                $campMemberId = $db->getLastInsID();
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
                return json(['code' => 200, 'msg' => '申请成功', 'data' => $campMemberId]);
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
            // 查询camp_member数据
            $campMemberInfo = db('camp_member')->where(['id' => $id])->find();
            if (!$campMemberInfo) {
                return json(['code' => 100, 'msg' => '不存在该申请']);
            }
            // 检查会员在训练营身份角色
            $isPower = $this->CampService->isPower($campMemberInfo['camp_id'], $this->memberInfo['id']);
            if ($isPower < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }
            // 申请已操作提示
            if ($campMemberInfo['status'] != 0) {
                return json(['code' => 100, 'msg' => '该申请已操作，无须重复操作']);
            }
            // 更新的数据内容
            $data = [
                'status' => $status,
                'update_time' => time()
            ];
            // 同意教练申请设为兼职教练type=2 level=1 status=1
            if ($status == 1) {
                if ($campMemberInfo['type'] == 2) {
                    $data['level'] = 1;
                }
            }
            // 更新camp_member数据
            $result = db('camp_member')->where(['id' => $id])->update($data);
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


    // 获取有教练身份的训练营员工（没分页、可模糊查询）（含有教练员身份的营主legend）
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
            $list = Db::view('camp_member', ['id' => 'campmemberid', 'camp_id', 'level', 'type'])
                ->view('coach', '*', 'coach.member_id=camp_member.member_id')
                ->where($map)
                ->select();
            foreach ($list as $k => $val) {
                if ($val['star'] > 0) {
                    $list[$k]['star'] = ceil($val['star'] / $val['star_num']);
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


    //自定义获取训练营身份列表分页（一页全部）
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
            if (!empty($type) && $type != ' ' && $type != '') {
                $map['type'] = ['egt', $type];
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

    /** 操作训练营-人员关联 2017/09/27
     * $id: input('campmemberid') camp_member表主键
     * @return array|\think\response\Json
     */
    public function removerelationship()
    {
        try {
            // 请求参数验证
            $id = input('post.campmemberid');
            $action = input('post.action');
            if (!$id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 获取camp_member数据
            $model = new \app\model\CampMember();
            $campMember = $model->get($id);
            if (!$campMember) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            // 获取原始数据
            $campMemberData = $campMember->getData();
            $campMember = $campMember->toArray();
            // 获取会员在训练营角色，营主才能操作
            $power = getCampPower($campMemberData['camp_id'], $this->memberInfo['id']);
            if ($power != 4) {
                return json(['code' => 100, 'msg' => __lang('MSG_403') . '，只有营主才能操作']);
            }
            $messageSevice = new MessageService();
            $messageData = [];
            $resUpdateCampMebmer = false;
            // 根据action参数 识别业务操作 level:改变角色等级，del移除人员出训练营
            switch ($action) {
                case 'level' :
                    {
                        // 改变角色等级
                        if ($campMemberData['type'] == 2) {
                            // 教练角色 改变兼职教练/正职教练：现在是兼职改为正职，反之现在是正职改为兼职
                            if ($campMemberData['level'] == 1) {
                                $newLevel = 2;
                                $levelText = '高级教练';
                            } else {
                                $newLevel = 1;
                                $levelText = '普通教练';
                            }
                            // 更新camp_member数据
                            $resUpdateCampMebmer = $model->save(['level' => $newLevel], ['id' => $campMemberData['id']]);
                            $messageData = [
                                'title' => '您好, 您所在的' . $campMember['camp'] . '的' . $campMember['type'] . '权限发生变更',
                                'content' => '您好, 您所在的' . $campMember['camp'] . '的' . $campMember['type'] . '权限发生变更，现为：' . $levelText,
                                'keyword1' => '训练营教练权限变更',
                                'keyword2' => $levelText,
                                'keyword3' => date('Y年m月d日 H:i', time()),
                                'remark' => '点击进入查看更多',
                                'url' => url('frontend/camp/campinfo', ['camp_id' => $campMember['camp_id']], '', true)
                            ];
                        }
                        break;
                    }
                default:
                    {
                        // 移除
                        // 营主不能移除自己
                        if ($campMemberData['type'] == 4 && $campMemberData['member_id'] == $this->memberInfo['id']) {
                            return json(['code' => 100, 'msg' => '你是营主不能删除自己']);
                        }
                        // 删教练 检查教练在营内有无班级
                        if ($campMember['type'] == 2) {
                            $coachS = new CoachService();
                            $coach = $coachS->getCoachInfo(['member_id' => $campMemberData['member_id']]);
                            $grade = $coachS->ingradelist($coach['id'], $campMemberData['camp_id']);
                            if ($grade) {
                                return json(['code' => 100, 'msg' => '该教练有班级记录,请先修改班级记录主教练/助教练']);
                            }
                            $lesson = $coachS->inlessonlist($coach['id'], $campMemberData['camp_id']);
                            if ($lesson) {
                                return json(['code' => 100, 'msg' => '该教练有课程记录,请先修改课程记录主教练/助教练']);
                            }
                        }
                        // 移除人员 更新camp_member数据
                        $resUpdateCampMebmer = $model->save(['status' => -1], ['id' => $campMemberData['id']]);
                        $messageData = [
                            'title' => '您好, 您所在的' . $campMember['camp'] . '的' . $campMember['type'] . '身份被移除了',
                            'content' => '您好, 您所在的' . $campMember['camp'] . '的' . $campMember['type'] . '身份被移除了',
                            'keyword1' => '训练营教练身份',
                            'keyword2' => '被移除',
                            'keyword3' => date('Y年m月d日 H:i', time()),
                            'remark' => '点击进入查看更多',
                            'url' => url('frontend/camp/campinfo', ['camp_id' => $campMember['camp_id']], '', true)
                        ];
                    }
            }
            if (!$resUpdateCampMebmer) {
                $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            // 更新camp_member数据成功 发送通知给该会员
            $messageSevice->sendMessageToMember($campMember['member_id'], $messageData, config('wxTemplateID.informationChange'));
            // 返回成功响应结果
            $response = json(['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $resUpdateCampMebmer]);
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
                    if (!ctype_space($keyword)) {
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
                    if (!ctype_space($keyword)) {
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
        // 接收传参
        $student_id = input('param.student_id', 0);
        $camp_id = input('param.camp_id', 0);
        $action = input('param.action');
        if (!$action || !$student_id || !$camp_id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 获取训练营角色 管理员以上才能操作
        $power = getCampPower($camp_id, $this->memberInfo['id']);
        if ($power < 3) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 获取学员信息
        $studentS = new StudentService();
        $studentInfo = $studentS->getStudentInfo(['id' => $student_id]);
        // 学员是否已离营标识 1：已离营
        $isStudentLeave = 0;
        // 学员在营剩余课时数
        $studentRestScheduleNum = 0;
        // 获取学员与课程关系数据
        $studentInLessons = $studentS->getInLessons([
            'camp_id' => $camp_id,
            'student_id' => $studentInfo['id'],
            'member_id' => $studentInfo['member_id']
        ]);
        if (!empty($studentInLessons)) {
            foreach ($studentInLessons as $val) {
                $studentRestScheduleNum += $val['rest_schedule'];
                if ($val['status'] != 1) {
                    $isStudentLeave = 1;
                }
                continue;
            }
        }
        // 获取学员与班级关系数据
        $studentInGrades = $studentS->getInGrades([
            'camp_id' => $camp_id,
            'student_id' => $studentInfo['id'],
            'member_id' => $studentInfo['member_id']
        ]);
        // 获取学员有无离营申请数据
        $leaveApplyInfo = db('camp_leaveapply')->where([
            'camp_id' => $camp_id,
            'user_id' => $studentInfo['id'],
            'member_id' => $studentInfo['member_id'],
            'status' => 0
        ])->whereNull('delete_time')->find();
        // 获取学员的会员账号与训练营关系
        $campMember = db('camp_member')->where(['camp_id' => $camp_id, 'member_id' => $studentInfo['member_id']])->find();
        // 以$isStudentLeave区别当前学员在营|离营状态，操作设为离营|在营操作
        $lessonMemberModel = new \app\model\LessonMember();
        $gradeMemberModel = new \app\model\GradeMember();
        if ($isStudentLeave) {
            // 设为在营状态
            try {
                // 数据业务操作：lesson_member status=1,rest_schedule=0,system_remarks记录在营操作；
                $saveAllDataLessonMember = [];
                if (!empty($studentInLessons)) {
                    foreach ($studentInLessons as $k => $val) {
                        $saveAllDataLessonMember[$k]['id'] = $val['id'];
                        $saveAllDataLessonMember[$k]['status'] = 1;
                        $systemRemarksTxt = date('Ymd', time()).' 训练营人员 '. $this->memberInfo['member'] .' 操作设为在营';
                        $saveAllDataLessonMember[$k]['system_remarks'] = empty($val['system_remarks']) ? $systemRemarksTxt : $val['system_remarks'].'\n'.$systemRemarksTxt;
                    }
                    $updateLessonMember = $lessonMemberModel->saveAll($saveAllDataLessonMember);
                }
                // grade_member status=1
                $updateGradeMember = $gradeMemberModel->where(['camp_id' => $camp_id, 'student_id' => $studentInfo['id'], 'member_id' => $studentInfo['member_id']])->setField('status', 1);
                // 涉及grade的student_str更新（操作的学员 回到班级）
                if (!empty($studentInGrades)) {
                    foreach ($studentInGrades as $val) {
                        $reserveStudentList = $gradeMemberModel->where(['grade_id' => $val['grade_id'], 'status' => 1])->column('student');
                        $reserveStudentStr = '';
                        if ($reserveStudentList) {
                            foreach ($reserveStudentList as $student) {
                                $reserveStudentStr .= $student . ',';
                            }
                            $reserveStudentStr = rtrim($reserveStudentStr, ',');
                        }
                        db('grade')->update([
                            'id' => $val['grade_id'],
                            'student_str' => $reserveStudentStr,
                            'students' => count($reserveStudentList)
                        ]);
                    }
                }
                // camp_leaveapply 清理学员的离营申请
                db('camp_leaveapply')->where(['user_id' => $studentInfo['id']])->update(['delete_time' => time()]);
                // camp_member status=1
                db('camp_member')->update(['id' => $campMember['id'], 'status' => 1, 'update_time' => time()]);
            } catch (Exception $e) {
                return json(['code' => 100, 'msg' => $e->getMessage()]);
            }
            // 返回成功结果
            return json(['code' => 200, 'msg' => '学员设为在营' . __lang('MSG_200')]);
        } else {
            // 设为离营状态
            // 若学员有离营申请，直接操作数据|提示学员有剩余课时
            if (!$leaveApplyInfo) {
                if ($studentRestScheduleNum) {
                    return json(['code' => 100, 'msg' => __lang('MSG_400') . '，该学员在训练营课时尚未完成']);
                }
            }
            try {
                // 数据业务操作：lesson_member status=-1,rest_schedule=0,system_remarks记录离营操作；
                $saveAllDataLessonMember = [];
                if (!empty($studentInLessons)) {
                    foreach ($studentInLessons as $k => $val) {
                        $saveAllDataLessonMember[$k]['id'] = $val['id'];
                        $saveAllDataLessonMember[$k]['rest_schedule'] = 0;
                        $saveAllDataLessonMember[$k]['status'] = -1;
                        $systemRemarksTxt = date('Ymd', time()).' 训练营人员 '. $this->memberInfo['member'] .' 操作设为离营，当前学员剩余课时数：'.$val['rest_schedule'];
                        $saveAllDataLessonMember[$k]['system_remarks'] = empty($val['system_remarks']) ? $systemRemarksTxt : $val['system_remarks'].'\n'.$systemRemarksTxt;
                    }
                    $updateLessonMember = $lessonMemberModel->saveAll($saveAllDataLessonMember);
                }
                // grade_member status=-1
                $updateGradeMember = $gradeMemberModel->where(['camp_id' => $camp_id, 'student_id' => $studentInfo['id'], 'member_id' => $studentInfo['member_id']])->setField('status', -1);
                // 涉及grade的student_str更新（保留同班其他学员）
                if (!empty($studentInGrades)) {
                    foreach ($studentInGrades as $val) {
                        $reserveStudentList = $gradeMemberModel->where(['grade_id' => $val['grade_id'], 'status' => 1])->column('student');
                        $reserveStudentStr = '';
                        if ($reserveStudentList) {
                            foreach ($reserveStudentList as $student) {
                                $reserveStudentStr .= $student . ',';
                            }
                            $reserveStudentStr = rtrim($reserveStudentStr, ',');
                        }
                        db('grade')->update([
                            'id' => $val['grade_id'],
                            'student_str' => $reserveStudentStr,
                            'students' => count($reserveStudentList)
                        ]);
                    }
                }
                // camp_leaveapply status=1
                db('camp_leaveapply')->where(['id' => $leaveApplyInfo['id']])->update(['status' => 1, 'update_time' => time()]);
                // 如果会员账号下所有学员都离营了 更新camp_member status=-1
                $studentLessonAllLeave = $studentS->getInLessons(['camp_id' => $camp_id, 'member_id' => $studentInfo['member_id'], 'status' => -1]);
                if ($studentLessonAllLeave) {
                    db('camp_member')->update(['id' => $campMember['id'], 'status' => -1, 'update_time' => time()]);
                }
            } catch (Exception $e) {
                return json(['code' => 100, 'msg' => $e->getMessage()]);
            }
            // 返回成功结果
            return json(['code' => 200, 'msg' => '学员设为离营' . __lang('MSG_200')]);
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


    // 搜索训练营的教练(一页全部)  (不含有教练员身份的营主，考虑弃用legend)
    public function getCoachOfCampListAllApi()
    {
        try {
            $camp_id = input('param.camp_id');
            $keyword = input('param.keyword');
            if (!empty($keyword) && $keyword != ' ' && $keyword != '') {
                $map = ['camp_member.camp_id' => $camp_id, 'camp_member.type' => 2, 'camp_member.member' => ['like', "%$keyword%"]];
            } else {
                $map = ['camp_member.camp_id' => $camp_id, 'camp_member.type' => 2];
            }
            $result = db('camp_member')->where($map)->join('coach', 'camp_member.member_id = coach.member_id')->order('camp_member.id desc')->select();
            if ($result) {
                return json(['code' => 200, 'msg' => '查询成功', 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => '查询成功,无数据']);
            }

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 训练营工作人员列表
    public function getcampworkerlist() {
        try {
            $map = input('param.');
            $page = input('page', 1);
            $map['type'] = ['gt', 1];
            if ( array_key_exists('keyword', $map) ) {
                $keyword = $map['keyword'];
                if ( $keyword == null ) {
                    unset($map['keyword']);
                }
                if ( !empty($keyword) || !ctype_space($keyword) ) {
                    $map['camp|member'] = ['like', '%'.$keyword.'%'];
                }
                unset($map['keyword']);
            }
            if ( input('?page') ) {
                unset($map['page']);
            }
            $result = db('camp_member')
                ->where($map)
                ->whereNull('delete_time')
                ->order(['id'=>'desc'])
                ->page($page)
                ->limit(10)
                ->select();
            if ($result) {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 训练营工作人员列表
    public function getcampworkerpage() {
        try {
            $map = input('param.');
            $page = input('page', 1);
            $map['type'] = ['gt', 1];
            if ( array_key_exists('keyword', $map) ) {
                $keyword = $map['keyword'];
                if ( $keyword == null ) {
                    unset($map['keyword']);
                }
                if ( !empty($keyword) || !ctype_space($keyword) ) {
                    $map['camp|member'] = ['like', '%'.$keyword.'%'];
                }
                unset($map['keyword']);
            }
            if ( input('?page') ) {
                unset($map['page']);
            }
            $result = db('camp_member')
                ->where($map)
                ->whereNull('delete_time')
                ->order(['id'=>'desc'])
                ->paginate(10);
            if ($result) {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }
}

