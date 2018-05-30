<?php
namespace app\system\controller;
use app\system\controller\Base;
use think\Db;
/**
 * 系统收支
 * @param  
 */
class Dailysys extends Base{
 
    public function _initialize(){
    	parent::_initialize();
    }

   //每天执行平台收支记录数据
    public function dailyInOut(){
    	try{
            $date_str = date('Ymd',(time()-86400));

            $this->sysoutput1($date_str);
            $this->sysoutput2($date_str);
            $this->sysoutput3($date_str);
            $this->sysincome1($date_str);
            $this->sysincome2($date_str);
            $this->sysincome3($date_str);

	    	$data = ['crontab'=>'每日平台收支'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'每日平台收支','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }

    // 优先运行,每日23:50运行
    public function dateStr(){
        Db::execute("update output set date_str = FROM_UNIXTIME(create_time,'%Y%m%d') WHERE date_str = 0");
        Db::execute("update income set date_str = FROM_UNIXTIME(create_time,'%Y%m%d') WHERE date_str = 0");
    }


    // 平台支出数据3(课时退费)
    private function sysoutput1($date_str){
        $list = db('output')->where(['rebate_type'=>1,'type'=>2,'date_str'=>date('Ymd',$date_str)])->select();
        foreach ($list as $key => &$value) {
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>3,'output'=>$value['output'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time']]
            );
        }
    }

    // 平台支出数据1(工资支出)
    private function sysoutput2($date_str){
        $list = db('output')->where(['rebate_type'=>1,'type'=>3,'date_str'=>$date_str])->select();
        foreach ($list as $key => &$value) {
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>1,'output'=>$value['output'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time']]
            );
        }
    }


    // 平台支出数据2(课时收入)
    private function sysoutput3($date_str){
        $list = db('income')->where(['rebate_type'=>1,'type'=>3,'date_str'=>$date_str])->select();
        foreach ($list as $key => &$value) {
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>2,'output'=>$value['income'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time']]
            );
        }
    }


    // 平台收入1(课时版订单收入)
    private function sysincome1($date_str){
        $list = db('income')->where(['rebate_type'=>1,'type'=>['elt',2],'date_str'=>$date_str])->select();
        foreach ($list as $key => &$value) {
            db('sys_income')->insert(
                ['f_id'=>$value['id'],'type'=>1,'income'=>$value['income'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time']]
            );
        }
    }

    // 平台收入1(提现收入)
    private function sysincome2($date_str){
        $list = db('output')->where(['rebate_type'=>2,'type'=>4,'date_str'=>$date_str])->select();
        foreach ($list as $key => &$value) {
            db('sys_income')->insert(
                ['f_id'=>$value['id'],'type'=>2,'income'=>$value['income'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time']]
            );
        }
    }

    // 平台收入1(赠课收入)
    private function sysincome3($date_str){
        $list = db('output')->where(['rebate_type'=>2,'type'=>4,'date_str'=>$date_str])->select();
        foreach ($list as $key => &$value) {
            db('sys_income')->insert(
                ['f_id'=>$value['id'],'type'=>2,'income'=>$value['income'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time']]
            );
        }
    }


    

    
}