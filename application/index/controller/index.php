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
        $list = db('salary_in')->where(['create_time'=>['between',[1533610564,1534906564]])->select();
    }

    public function index2(){
        
       

    }


}