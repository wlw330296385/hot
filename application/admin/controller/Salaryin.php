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
        $member_id = input('member_id',19);
        
        $monthStart = 20171201;
        $monthEnd = 20171231;
        $camp_id = $this->cur_camp['camp_id'];
        $map['camp_id'] = $camp_id;
        $salaryinList = db('salary_in')->field("*,sum(salary) as s_salary,sum(push_salary) as s_push_salary,sum(students) as s_students,count(id) as c_id,from_unixtime(create_time,'%Y%m%d') as days")->where(['member_id'=>$member_id])->group('days')->order('days')->select();
        // dump($salaryinList);
        $salaryin = [];
        $list1 = [];
        $list2 = [];
        for ($i=$monthStart; $i <= $monthEnd; $i++) { 
                $list1[$i] = [];
                $list2[$i] = [];
            }

        foreach ($list1 as $key => &$value) {
            foreach ($salaryinList as $k => $val) {
                if($key == $val['days']){
                    $value[] = $val;
                }
            }
        }

        $salaryoutList = db('salary_out')->field("*,sum(salary) as s_salary,count(id) as c_id,from_unixtime(create_time,'%Y%m%d') as days")->where(['member_id'=>$member_id])->group('days')->order('days')->select();

        foreach ($list2 as $key => &$value) {
            foreach ($salaryoutList as $k => $val) {
                if($key == $val['days']){
                    $value[] = $val;
                }
            }
        }
        $this->assign('list2',$list2);
        $this->assign('list1',$list1);
        return view();
    }
    
}