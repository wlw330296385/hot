<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\GradeService;
use app\service\ScheduleService;
use app\model\Grade as GradeModel;
use app\model\Schedule as ScheduleModel;
use think\Db;

class Grade extends Backend {
    // 班级管理
    public function index() {
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }
        $camp = input('camp');
        if ($camp) {
            $map['camp'] = ['like', '%'. $camp .'%'];
        }
        $grade = input('grade');
        if ($grade) {
            $map['grade'] = ['like', '%'. $grade .'%'];
        }
        $lesson = input('lesson');
        if ($lesson) {
            $map['lesson'] = ['like', '%'. $lesson .'%'];
        }
        $coach = input('coach');
        if ($coach) {
            $map['coach'] = ['like', '%'. $coach .'%'];
        }

        $list = GradeModel::where($map)->paginate(15);

        $this->assign('list', $list);
        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '班级管理' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }

    // 班级详情
    public function show() {
        $id = input('id');
        $grade = GradeModel::get(['id' => $id])->toArray();
        $studentsMap['grade_id'] = $id;
        $studentsMap['type'] = ['in', [1,5]];
        $studentsMap['status'] = 1;
        $grade['student'] = Db::name('gradeMember')->where($studentsMap)->select();
        $schedule = ScheduleModel::where(['grade_id' => $id])->order('id desc')->select()->toArray();

        $this->assign('grade', $grade);
        $this->assign('schedule', $schedule);
        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '班级详情' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }
}