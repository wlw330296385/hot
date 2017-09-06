<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\ScheduleService;
use app\model\Schedule as ScheduleModel;

class Schedule extends Backend {
    public function index() {
        $breadcrumb = ['title' => '课时管理', 'ptitle' => '训练营'];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }

    public function calendar() {
        if (request()->isAjax()) {
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
            $field = ['id', 'grade', 'grade_id', 'teacher', 'assistant', 'lesson_date', 'lesson_time', 'court', 'remarks'];
            $schedule = ScheduleModel::where($map)->field($field)->select();
            $calendar_events = [];
            if ($schedule) {
                foreach ($schedule as $k => $val) {
                    $calendar_events[] = [
                        'id' => $val['id'],
                        'title' => $val['grade'],
                        'start' => date('Y-m-d H:i', $val['lesson_time']),
                        'url' => url('schedule/detail', ['id' => $val['id']])
                    ];
                }

                return ['status' => 1, 'data' => $calendar_events];
            } else {
                return ['status' => 0, 'data' => $calendar_events];
            }
        }
    }

    public function detail(){
        $id = input('id');

        /*$Schedule_S = new ScheduleService();
        $schedule_res = $Schedule_S->getScheduleInfo(['id' => $id]);
        if ($schedule_res['code'] == 200 ) {
            $this->error($schedule_res['msg']);
        }
        $schedule = $schedule_res['data'];*/

        $schedule = ScheduleModel::where(['id' => $id])->find()->toArray();
        $students = explode(',', $schedule['student_str']);


        $breadcrumb = ['title' => '课时详情', 'ptitle' => '训练营'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('data', $schedule);
        $this->assign('students', $students);
        return view();
    }
}