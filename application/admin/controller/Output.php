<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;

class Output extends Backend{
	protected $BonusService;
	public function _initialize(){
		parent::_initialize();
	}

    public function index(){
        $list1 = [];
        if(!$this->cur_camp){

        }else{
            $monthStart = 20180101;
            $monthEnd = 20180131;
            $camp_id = $this->cur_camp['camp_id'];
            $map['camp_id'] = $camp_id;
            // $map['type'] = 1;
            $income = db('income')->field("sum(balance_pay) as s_balance_pay,count(id) as c_id,from_unixtime(create_time,'%Y%m%d') as days")->where($map)->group('days')->order('days')->select();
            

            $output = db('output')->field("sum(output) as s_output,count(id) as c_id,from_unixtime(create_time,'%Y%m%d') as days")->where($map)->group('days')->order('days')->select();
            for ($i=$monthStart; $i <= $monthEnd; $i++) { 
                $list1[$i]['income'] = ["s_balance_pay"=>0,'c_id'=>0,'days'=>$i];
                $list1[$i]['output'] = ["s_output"=>0,'c_id'=>0,'days'=>$i];
            }
            foreach ($list1 as $key => &$value) {
                foreach ($income as $k => $val) {
                    if($key == $val['days']){
                        $value['income'] = $val;
                    }
                }
                foreach ($output as $k => $val) {
                    if($key == $val['days']){
                        $value['output'] = $val;
                    }
                }
            }

            

        }

        
        
        dump($list1);
        $this->assign('list1',$list1);
        return view('Output/index');
    }



    public function demo(){
        
        return view();
    }
    
}