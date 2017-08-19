<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\ScheduleService;

class Schedule extends Backend {
    public function index() {
        $breadcrumb = ['title' => '课时管理', 'ptitle' => '训练营'];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }

    public function calendar() {
        if (request()->isAjax()) {
            $Schedule_S = new ScheduleService();
            $field = [ 'id', 'grade', 'grade_id' ,'teacher', 'assistant', 'lesson_date', 'lesson_time', 'court', 'remarks' ];
            $res = $Schedule_S->getscheduleList([], '',$field);
            $calendar_events = [];
            if ($res['code'] == 100) {
                $schedule = $res['data'];
                foreach ($schedule as $k => $val) {
                    $calendar_events[] = [
                        'id' => $val['id'],
                        'title' => $val['grade'],
                        'start' => $val['lesson_time'],
                        'url' => url('schedule/detail', ['id' => $val['id']])
                    ];
                }
                return [ 'status' => 1, 'data' => $calendar_events ];
            } else {
                return [ 'status' => 0, 'data' => $calendar_events ];
            }
        }
    }

    public function detail(){
        $id = input('id');

        $Schedule_S = new ScheduleService();
        $schedule_res = $Schedule_S->getScheduleInfo(['id' => $id]);
        if ($schedule_res['code'] == 200 ) {
            $this->error($schedule_res['msg']);
        }
        $schedule = $schedule_res['data'];
        $students = explode(',', $schedule['student_str']);


        $breadcrumb = ['title' => '课时详情', 'ptitle' => '训练营'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('data', $schedule);
        $this->assign('students', $students);
        return view();
    }
}