<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\GradeService;
use app\service\ScheduleService;

class Grade extends Backend {
    // 班级管理
    public function index() {
        $camp_id = input('campid');
        $map = [];
        if ($camp_id) {
            $map = ['camp_id' => $camp_id];
        }
        $Grade_S = new GradeService();
        $res=$Grade_S->getGradePage($map);
        if ($res['code'] == 200) {
            $this->error($res['msg']);
        }

        //dump($res['data']);
        $this->assign('list', $res['data']);
        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '班级管理' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }

    // 班级详情
    public function detail() {
        $id = input('id');
        $Grade_S = new GradeService();
        $grade = $Grade_S->getGradeOne([ 'id' => $id ]);
        $Schedule_S = new ScheduleService();
        $schedule = $Schedule_S->getscheduleList([ 'grade_id' => $id ], 'id desc');

        if ($grade['code'] == 200 || $schedule['code'] == 200) {
            $this->error($grade['msg']);
        }

        $this->assign('data', $grade['data']);
        $this->assign('schedule', $schedule['data']);
        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '班级详情' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }
}