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
    	db('admin_menu')->insert(['pid'=>4,'url_value'=>'admin/Charge/chargeList','title'=>'充值记录']);
    }

    public function index2(){
        
        $list = db('salary_in')->field('salary_in.id,schedule.lesson_time')->join('schedule','schedule.id = salary_in.schedule_id')->select();
        foreach ($list as $key => $value) {
            db('salary_in')->where(['id'=>$value['id']])->update(['schedule_time'=>$value['lesson_time']]);
        }

    }


}