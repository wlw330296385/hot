<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\model\Student as StudentModel;
use think\Db;

class Student extends Backend {
    // 学员列表
    public function index() {
        // 搜索筛选
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }
        $camp = input('camp');
        if ($camp) {
            $map['grade_member.camp'] = ['like', '%'. $camp .'%'];
        }
        $name = input('name');
        if ($name) {
            $map['grade_member.student'] = ['like', '%'. $name .'%'];
        }
        $tel = input('tel');
        if ($tel) {
            $map['member.telephone'] = $tel;
        }

        // 视图查询 grade_member - student
        $map['type'] = ['in', [1,5]];
        $map['status'] = ['>', 0];
        $list = Db::view('student', 'id, student,member_id')
            ->view('grade_member', 'grade,camp_id,camp,type,status', 'grade_member.student_id=student.id')
            ->view('member','member,telephone', 'member.id=student.member_id')
            ->where($map)->paginate(15);
        //dump($list);

        $breadcrumb = ['title' => '学员列表', 'ptitle' => '训练营'];
        $this->assign('breadcrumb', $breadcrumb);
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
//        dump($data);

        $breadcrumb = ['title' => '学员档案', 'ptitle' => '训练营'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('student', $data);
        return view();
    }
}