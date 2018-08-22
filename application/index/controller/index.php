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
        $list = db('schedule')->field('schedule.coach as s_c,coach.coach as c_c,schedule.id,schedule.status,schedule.is_settle')->join('coach','coach.id = schedule.coach_id')->where(['schedule.create_time'=>['between',[1533610564,1534906564]]])->order('schedule.id desc')->select();
        foreach ($list as $key => $value) {
            if($value['c_c']<>$value['s_c']){
                dump($value);
            }
        }
    }

    public function index2(){
        
       

    }


}