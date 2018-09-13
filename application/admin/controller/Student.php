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
        $type = input('param.type');
        $status = input('param.status');
        $keyword = input('param.keyword');
        $camp_id = input('param.camp_id',9);
        $map['lesson_member.camp_id'] = $camp_id;
        $map['bill.is_pay'] = 1;
        $map['bill.goods_type'] = 1;
        if ($type) {
            $map['lesson_member.type'] = $type;
        }
        if($status){
            $map['lesson_member.status'] = $status;
        }
        if($keyword){
            $map['lesson_member.lesson|lesson_member.student'] = ['like',"%$keyword%"];
        }


        $campList = db('camp')->select();
        $studentList = db('lesson_member')->field('lesson_member.*,sum(bill.balance_pay) as s_balance_pay')->join('bill','bill.student_id = lesson_member.student_id and lesson_member.lesson_id = bill.goods_id','left')->where($map)->order('lesson_member.id desc')->group('bill.student_id')->select();
        $this->assign('studentList', $studentList);
        $this->assign('camp_id', $camp_id);
        $this->assign('campList',$campList);
        return $this->fetch();
    }

    // 学员档案
    public function show() {
        $id = input('id');
        $studentInfo = StudentModel::with('member')->where(['id' => $id])->find()->toArray();
        $studentInfo['_incamp'] = Db::view('student', 'id, student,member_id')
            ->view('grade_member', 'grade,camp,type,status', 'grade_member.student_id=student.id')
            ->where(['student_id' => $studentInfo['id']])->select();
        $this->assign('studentInfo', $studentInfo);    
        return view();
    }


    // 创建|修改学生
    public function updateStudent(){
        $student_id = input('param.student_id');
        $StudentService = new \app\service\StudentService;
        $member_id = input('param.member_id');
        $memberInfo = db('member')->where(['id'=>$member_id])->find();
            
            
        if($student_id){
            if(request()->isPost()){
                $data = input('post.');
                $result = $StudentService->updateStudent($data,$student_id);
                if($result){
                    echo  "<script>alert('".$result['msg']."');</script>";
                }
            }
            // 编辑学生
            $memberInfo = db('member')->where(['id'=>$member_id])->find();
            $this->assign('memberInfo',$memberInfo);
            return view('student/updateStudent');
        }else{
            if(request()->isPost()){
                $data = input('post.');
                $data['member'] = $memberInfo['member'];
                $result = $StudentService->createStudent($data);
                if($result){
                    echo  "<script>alert('".$result['msg']."');</script>";
                }
            }
            // 创建学生
            $memberInfo = db('member')->where(['id'=>$member_id])->find();
            $this->assign('memberInfo',$memberInfo);
            return view('student/createStudent');
        }
        
    }
}