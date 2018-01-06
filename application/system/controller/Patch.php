<?php
// 数据补丁
namespace app\system\controller;


use app\model\Bill;
use app\model\LessonMember;
use app\model\ScheduleGiftStudent;
use app\model\ScheduleMember;
use app\model\Student;

class Patch {
    // 重新统计学员剩余课时
    public function countstudentrestschedule() {
        // 遍历lesson_member数据
        $modelLessonMember = new LessonMember();
        $modelBill = new Bill();
        $modelScheduleGiftStudent = new ScheduleGiftStudent();
        $modelScheduleMember = new ScheduleMember();
        $modelStudent = new Student();
        $lessonmembers = $modelLessonMember->order('id desc')->select();
        //dump($lessonmembers);
        $dataLessonMemberSaveAll = [];
        $dataStudentSaveAll = [];
        foreach ($lessonmembers as $k => $lessonmember) {
            //dump($lessonmember);
            // 学员购买课程
            $buylessonum = $modelBill->where(['goods_type' => 1, 'is_pay' => 1, 'status' => 1, 'student_id' => $lessonmember['student_id']])->distinct(true)->field('goods')->count();
            //dump($lessonmember['student_id'].'---'.$buylessonum);
            
            // 学员总课时统计
            // 学员课程订单购买课时数
            $buyschedulenum = $modelBill->where(['camp_id' => $lessonmember['camp_id'], 'goods_id' => $lessonmember['lesson_id'], 'student_id' => $lessonmember['student_id'], 'is_pay' => 1, 'status' => 1 ])->sum('total');
            if (!$buyschedulenum) { $buyschedulenum = 0 ;}
            //dump($buyschedulenum);
            // 学员课程赠课数
            $giftschedulenum = $modelScheduleGiftStudent->where(['camp_id' => $lessonmember['camp_id'], 'lesson_id' => $lessonmember['lesson_id'], 'student_id' => $lessonmember['student_id'], 'status' => 1 ])->sum('gift_schedule');
            if (!$giftschedulenum) { $giftschedulenum = 0; }
            //dump($giftschedulenum);
            $total_schedule = $buyschedulenum+$giftschedulenum;
            //dump($total_schedule);

            // 学员剩余课时统计
            // 已上课课时数
            $schedulenum = $modelScheduleMember->where(['camp_id' => $lessonmember['camp_id'], 'type' => 1, 'user_id' => $lessonmember['student_id']])->count();
            $restschedulenum = 0;
            // 没有课时记录 剩余课时数为学员总课时数
            if ($schedulenum) {
                $restschedulenum = $total_schedule-$schedulenum;
            } else {
                $restschedulenum = $total_schedule;
            }
            //dump($schedulenum);
            
            // 组合批量保存数据数组
            $dataLessonMemberSaveAll[$k] = [
                'id' => $lessonmember['id'],
                'rest_schedule' => $restschedulenum,
                'total_schedule' => $total_schedule
            ];
            $dataStudentSaveAll[$k] = [
                'id' => $lessonmember['student_id'],
                'total_schedule' => $total_schedule,
                'finished_schedule' => $schedulenum,
                'total_lesson' => $buylessonum
            ];
        }
        //dump($dataLessonMemberSaveAll);
//        dump($dataStudentSaveAll);
        $res1 = $modelLessonMember->saveAll($dataLessonMemberSaveAll);
        $res2 = $modelStudent->saveAll($dataStudentSaveAll);
        if ($res1 && $res2) {
            echo 'ok';
        }
    }
}