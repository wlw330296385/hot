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
    	$list = db('grade')->where(['students'=>0])->select();
        $ids = [];
        foreach ($list as $key => $value) {
            $ids[] = $value['id'];
        }
        db('grade_member')->where(['grade_id'=>['in',$ids]])->delete();
    }

    public function index2(){
        
        $list = db('salary_in')->field('salary_in.id,schedule.lesson_time')->join('schedule','schedule.id = salary_in.schedule_id')->select();
        foreach ($list as $key => $value) {
            db('salary_in')->where(['id'=>$value['id']])->update(['schedule_time'=>$value['lesson_time']]);
        }

    }


}