<?php 
namespace app\index\controller;
use think\Controller;
/**
* 
*/
class Index extends Controller
{
	
	function __construct()
	{
		
	}

    public function index(){
        echo "<p><a href='/frontend/index'><h1>欢迎来到篮球管家</h1></p>";
    }

    public function index1(){
    	$list = db('schedule')->where(['is_settle'=>0,'coach_salary'=>0,'assistant_salary'=>0,'status'=>-1])->select();
        // dump($list);
        foreach ($list as $key => $value) {
            $info = db('grade')->where(['id'=>$value['grade_id']])->find();
            if($info['coach_salary']<>0 || $info['assistant_salary']<>0){
                db('schedule')->where(['id'=>$value['id']])->update(['coach_salary'=>$info['coach_salary'],'assistant_salary'=>$info['assistant_salary']]);
            }
        }
    }

    public function index2(){
        
        $list = db('salary_in')->field('salary_in.id,schedule.lesson_time')->join('schedule','schedule.id = salary_in.schedule_id')->select();
        foreach ($list as $key => $value) {
            db('salary_in')->where(['id'=>$value['id']])->update(['schedule_time'=>$value['lesson_time']]);
        }

    }


}