<?php
namespace app\system\controller;
use app\system\controller\Base;
/**
 * 
 * @param  测试
 */
class Test extends Base {
   


    public function _initialize() {
        parent::_initialize();
        
    }

    public function test(){
        db('log_exception')->insert(
                [
                    'message'=>"定时任务测试运行",
                    'file'=>"base.php",
                    'line'=>'0',
                    'data_json'=>request()->instance()->header('fff'),
                    'request_url'=>"fff",
                    'member_id'=>0,
                    'member'=>'woo',
                    'trace'=>json_encode(request()->instance()->header()),
                ]
            );
        echo 1234;die;

    }

}