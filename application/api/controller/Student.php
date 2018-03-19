<?php

namespace app\api\controller;

use app\service\CampService;
use app\service\StudentService;
use app\api\controller\Base;
use think\Exception;

/**
 * 学生控制器
 */
class Student extends Base
{
    protected $studentService;

    function _initialize()
    {
        parent::_initialize();
        $this->studentService = new StudentService;
    }

    public function index()
    {
        return json(['code' => 1]);
    }

    public function getStudentListByPageApi()
    {
        try {
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $city = input('param.city');
            $area = input('param.area');
            $map['province'] = $province;
            $map['city'] = $city;
            $map['area'] = $area;
            foreach ($map as $key => $value) {
                if ($value == '' || empty($value) || $value == ' ') {
                    unset($map[$key]);
                }
            }
            if (!empty($keyword) && $keyword != ' ' && $keyword != '' && $keyword != NULL) {
                $map['court'] = ['LIKE', '%' . $keyword . '%'];
            }
            if (isset($map['keyword'])) {
                unset($map['keyword']);
            }
            if (isset($map['page'])) {
                unset($map['page']);
            }
            $result = $this->studentService->getStudentListByPage($map);
            if ($result) {
                return json(['data' => $result, 'code' => 200, 'msg' => 'ok']);
            } else {
                return json(['code' => 200, 'msg' => '没数据了']);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    public function createStudentApi()
    {
        try {
            $data = input('post.');
            $data['member'] = $this->memberInfo['member'];
            $data['member_id'] = $this->memberInfo['id'];
            $result = $this->studentService->createStudent($data);
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }


    public function updateStudentApi()
    {
        try {
            $data = input('post.');
            $student_id = input('param.student_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->studentService->updateStudent($data, $student_id);
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }

    public function getStudentListApi()
    {
        try {
            $member_id = input('param.member_id') ? input('param.member_id') : $this->memberInfo['id'];
            $result = $this->studentService->getStudentList(['member_id' => $member_id]);
            if ($result) {
                return json(['data' => $result, 'code' => 200, 'msg' => 'ok']);
            } else {
                return json(['code' => 100, 'msg' => '没数据了']);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 学员提交离营申请
    public function applyleavecamp()
    {
        try {
            $student_id = input('param.student_id', 0);
            $camp_id = input('param.camp_id', 0);
            if (!$student_id || !$camp_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }

            $studentS = new StudentService();
            $student = $studentS->getStudentInfo(['id' => $student_id]);
            if (!$student) {
                return json(['code' => 100, 'msg' => '学生'.__lang('MSG_404')]);
            }
            $campS = new CampService();
            $camp = $campS->getCampInfo($camp_id);
            if (!$camp) {
                return json(['code' => 100, 'msg' => '训练营'.__lang('MSG_404')]);
            }

            $db = db('camp_leaveapply');
            $hasapply = $db->where(['member_id' => $student['member_id'], 'camp_id' => $camp['id'], 'user_id' => $student['id']])->find();
            if ($hasapply) {
                return json(['code' => 100, 'msg' => '你已提交离营申请，不需再次提交']);
            }

            $addApplyleavecampResult = $db->insert([
                'member_id' => $student['member_id'],
                'member' => $student['member'],
                'camp_id' => $camp['id'],
                'camp' => $camp['camp'],
                'username' => $student['student'],
                'user_id' => $student['id'],
                'status' => 0,
                'create_time' => time()
            ]);
            if (!$addApplyleavecampResult) {
                return json(['code' => 100, 'msg' => '提交离营申请'.__lang('MSG_400')]);
            } else {
                return json(['code' => 200, 'msg' => '提交离营申请'.__lang('MSG_200'), 'data' => $db->getLastInsID()]);
            }

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}