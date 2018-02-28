<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;

class Salaryin extends Backend{
	protected $BonusService;
	public function _initialize(){
		parent::_initialize();
	}

    public function coach(){
        $member_id = input('param.member_id',18);
        $salaryinList = db('salary_in')->field('*,sum(salary) as s_salary,sum(push_salary) as s_push_salary,sum(students) as s_students,count(id) as c_id')->where(['member_id'=>$member_id])->group('camp_id')->select();

 

        $this->assign('salaryinList',$salaryinList);
        return view('Salaryin/coach');
    }



    public function demo(){
        
        return view();
    }
    
}