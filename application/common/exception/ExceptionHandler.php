<?php
namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use app\model\LogException;

class ExceptionHandler extends Handle
{

    public function render(Exception $e)
    {
        // $e_file = $e->getFile();
        // $e_relative_file = str_replace(ROOT_PATH,'',$e_file);
        // $e_line    = $e->getLine();
        // $e_message = $e->getMessage();
        // $trace = $e->getTraceAsString();

        // $data_json = json_encode([
        //     'get_data'  => $_GET,
        //     'post_data' => $_POST
        // ]);
        // $log_data = [
        //     'file'      =>  $e_relative_file,
        //     'line'      =>  $e_line,
        //     'message'   =>  $e_message,
        //     'trace'     =>  $trace,
        //     'code'      =>  $e->getCode(),
        //     'data_json' =>  $data_json
        // ];

        // if (!empty(session('memberInfo','','think'))) {
        //     $memberInfo = session('memberInfo','','think');
        //     $log_data['member_id'] = $memberInfo['id'];
        //     $log_data['member'] = $memberInfo['member'];
        // }

        // $syslog = LogException::create($log_data);

        //TODO::开发者对异常的操作
        //可以在此交由系统处理
        return parent::render($e);
    }

}