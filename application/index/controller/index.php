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
        $list = db('camp_finance')->field('schedule.cost*schedule.students as money2,camp_finance.money,camp_finance.id')->join('schedule','camp_finance.f_id = schedule.id')->where(['camp_finance.camp_id'=>13,'camp_finance.type'=>3])->order('camp_finance.id desc')->select();
        $ids = [];
        foreach ($list as $key => $value) {
            if(($value['money2'])==$value['money']){
                $ids[] = $value['id'];
            }
        }
        $res = db('camp_finance')->where(['id'=>['in',$ids],'camp_id'=>13])->dec('e_balance','money*schedule_rebate')->update();
        $res = db('camp_finance')->where(['id'=>['in',$ids],'camp_id'=>13])->dec('money','money*schedule_rebate')->update();
        
    }

    public function index2(){
        
       

    }


}