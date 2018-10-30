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
            $outputValue = [0=>'未知',1=>'个人余额提现支出',2=>'课时版训练营余额提现支出',3=>'课时版训练营退费训练营支出',4=>'课时版训练营退费用户支出',5=>"课时版推荐提成"];
            $incomeValue = [0=>'未知',1=>'课时版订单收入',2=>'营业额版训练营提现收入',3=>"课时版赠课收入",4=>"个人平台充值收入"];
            $this->sysoutput1($date_str);
            $this->sysoutput2($date_str);
            $this->sysoutput3p4($date_str);
            $this->sysincome1($date_str);
            $this->sysincome2($date_str);
            $this->sysincome3($date_str);
            $this->sysincome4($date_str);
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
        Db::execute("update salary_out set date_str = FROM_UNIXTIME(create_time,'%Y%m%d') WHERE date_str = 0 and status=1 and is_pay=1");
        Db::execute("update camp_withdraw set date_str = FROM_UNIXTIME(create_time,'%Y%m%d') WHERE date_str = 0 and status=2");
    }


    

    // 平台支出数据1(个人余额提现支出)
    private function sysoutput1($date_str){
        $list = db('salary_out')->where(['is_pay'=>1,'status'=>1,'date_str'=>$date_str])->select();
        foreach ($list as $key => $value) {
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>1,'output'=>$value['salary'],'camp_id'=>$value['member_id'],'camp'=>$value['member'],'create_time'=>$value['pay_time'],'system_remarks'=>"个人余额提现支出"]
            );
        }
    }


    // 平台支出数据2(课时版训练营余额提现支出)
    private function sysoutput2($date_str){
        $list = db('camp_withdraw')->where(['rebate_type'=>1,'status'=>['egt',2],'date_str'=>$date_str])->select();
        foreach ($list as $key => $value) {
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>2,'output'=>$value['withdraw'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['agree_time'],'system_remarks'=>"课时版训练营余额提现支出"]
            );
        }
    }



    // 平台支出数据3(课时版训练营退费支出)
    private function sysoutput3($date_str){
        $list = db('output')->where(['rebate_type'=>1,'type'=>2,'date_str'=>date('Ymd',$date_str)])->select();
        foreach ($list as $key => $value) {
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>3,'output'=>$value['output'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time'],'system_remarks'=>"课时版训练营退费支出"]
            );
        }
    }


    //平台支出4(课时版训练营退费用户支出)




    //平台支出5(课时版推荐提成)





    //3+4
    private function sysoutput3p4(){
        $s = time() - 86400;
        $e = time();
        $list = db('refund')
        ->where(['status'=>3])
        ->where('finish_time',['>=',$s],['<',$e],'and')
        ->where(['rebate_type'=>1])
        ->select();
        foreach ($list as $key => $value) {
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>5,'output'=>$value['refund'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['finish_time'],'system_remarks'=>"课时版训练营退费用户支出"]
            );
            db('sys_output')->insert(
                ['f_id'=>$value['id'],'type'=>3,'output'=>$value['refundamount'] - $value['refund'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['finish_time'],'system_remarks'=>"课时版训练营退费训练营支出"]
            );
        }
    }











    // 平台收入1(课时版订单收入)
    private function sysincome1($date_str){
        $list = db('income')->where(['rebate_type'=>1,'type'=>['elt',2],'date_str'=>$date_str])->select();
        foreach ($list as $key => $value) {
            db('sys_income')->insert(
                ['f_id'=>$value['id'],'type'=>1,'income'=>$value['income'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time'],'system_remarks'=>"课时版订单收入"]
            );
        }
    }

    // 平台收入2(营业额版训练营提现收入)
    private function sysincome2($date_str){
        $list = db('output')->where(['rebate_type'=>2,'type'=>4,'date_str'=>$date_str])->select();
        foreach ($list as $key => $value) {
            db('sys_income')->insert(
                ['f_id'=>$value['id'],'type'=>2,'income'=>$value['output'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time'],'system_remarks'=>"营业额版训练营提现收入"]
            );
        }
    }





    // 平台收入3(课时版赠课收入)
    private function sysincome3($date_str){
        $list = db('output')->where(['rebate_type'=>1,'type'=>1,'date_str'=>$date_str])->select();
        foreach ($list as $key => $value) {
            db('sys_income')->insert(
                ['f_id'=>$value['id'],'type'=>3,'income'=>$value['output'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'create_time'=>$value['create_time'],'system_remarks'=>"课时版赠课收入"]
            );
        }
    }


    
    //个人充值收入4
    private function sysincome4($date_str){
        $list = db('charge')->where(['is_pay'=>1,'status'=>1,'date_str'=>$date_str])->select();
        foreach ($list as $key => $value) {
            db('sys_income')->insert(
                ['f_id'=>$value['id'],'type'=>4,'income'=>$value['charge'],'camp_id'=>$value['member_id'],'camp'=>$value['member'],'create_time'=>$value['create_time'],'system_remarks'=>"个人充值收入"]
            );
        }
    }
    

}