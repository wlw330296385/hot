<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\StudentService;

class Student extends Backend {
    public function index() {
        $Student_S = new StudentService();
        $Student_S->getStudentAll();
    }
}