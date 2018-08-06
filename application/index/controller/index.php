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
    	$l = [1,2,3,4,5,6,7,8,9];
        $l1 = array_slice($l, 0,2);
        $l2 = array_slice($l,2,3);
        $l3 = array_slice($l,2+3,4);
        dump($l1);
        dump($l2);
        dump($l3);
    }

    public function index2(){
        
        $list = db('salary_in')->field('salary_in.id,schedule.lesson_time')->join('schedule','schedule.id = salary_in.schedule_id')->select();
        foreach ($list as $key => $value) {
            db('salary_in')->where(['id'=>$value['id']])->update(['schedule_time'=>$value['lesson_time']]);
        }

    }


}