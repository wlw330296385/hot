<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\model\Student as StudentModel;
use think\Db;

class Student extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    // 学员列表
    public function index() {
        // 搜索筛选
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['grade_member.camp_id'] = $cur_camp['camp_id'];
        }
        $camp = input('camp');
        if ($camp) {
            $map['grade_member.camp'] = ['like', '%'. $camp .'%'];
        }
        $name = input('name');
        if ($name) {
            $map['student.student'] = ['like', '%'. $name .'%'];
        }
        $tel = input('tel');
        if ($tel) {
            $map['member.telephone'] = $tel;
        }
        // 视图查询 grade_member - student
        $list = Db::view('student','student,member_id,id')
            ->view('member', 'member,hot_id,telephone', 'member.id=student.member_id', 'left')
            ->view('grade_member', 'camp,camp_id,grade,grade_id,status', 'grade_member.student_id=student.id', 'LEFT')
            ->where($map)
            ->where('grade_member.delete_time', null)
            ->order('student.member_id desc')
            ->paginate(15);
//        dump($list->toArray());die;
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 学员档案
    public function show() {
        $id = input('id');
        $data = StudentModel::with('member')->where(['id' => $id])->find()->toArray();
        $data['_incamp'] = Db::view('student', 'id, student,member_id')
            ->view('grade_member', 'grade,camp,type,status', 'grade_member.student_id=student.id')
            ->where(['student_id' => $data['id']])->select();

        return view();
    }
}