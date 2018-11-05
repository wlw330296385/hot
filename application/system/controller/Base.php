<?php 
namespace app\system\controller;
use think\Controller;
use think\Exception;
class Base extends Controller{
	public function _initialize() {
    $fff = request()->instance()->header('fff');
		if(!$fff|| $fff!='woo'){
            echo "非法操作";
            db('log_exception')->insert(
                [
                    'message'=>"定时任务非正常运行",
                    'file'=>"base.php",
                    'line'=>'0',
                    'data_json'=>$fff,
                    'request_url'=>"fff",
                    'member_id'=>0,
                    'member'=>'woo',
                    'trace'=>json_encode(request()->instance()->header()),
                ]
            );
            exit(1);
        }
    }



    protected function record($data){
    	
    	$data['create_time'] = time();
    	$data['date_str'] = date('Y-m-d H:i:s',time());
    	db('crontab_record')->insert($data);
    }
}	