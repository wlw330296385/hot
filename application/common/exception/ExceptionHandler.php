<?php
namespace app\common\exception;

use Exception;
use think\Request;
use think\exception\Handle;
use think\exception\HttpException;
use app\model\LogException;

class ExceptionHandler extends Handle
{
    public function render(Exception $e)
    {

        $request = Request::instance();
        
        $e_file = $e->getFile();
        $e_relative_file = str_replace(ROOT_PATH, '', $e_file);
        $e_line    = $e->getLine();
        $e_message = $e->getMessage();
        $trace = $e->getTraceAsString();

        $data_json = json_encode([
            'get_data'  => $_GET,
            'post_data' => $_POST
        ]);
        $log_data = [
            'file'      =>  $e_relative_file,
            'line'      =>  $e_line,
            'message'   =>  $e_message,
            'trace'     =>  $trace,
            'data_json' =>  $data_json
        ];

        if (!empty(session('memberInfo','','think'))) {
            $memberInfo = session('memberInfo','','think');
            $log_data['member_id'] = $memberInfo['id'];
            $log_data['member'] = $memberInfo['member'];
        }

        if (!empty($_SERVER['REQUEST_URI'])) {
            $log_data['request_url'] = $_SERVER['REQUEST_URI'];
        }

        if (!empty($_SERVER['HTTP_REFERER'])) {
            $log_data['referer'] = str_replace($request->domain(), '', $_SERVER['HTTP_REFERER']);
        }

        if (!empty($_SERVER['OS'])) {
            $log_data['os'] = $_SERVER['OS'];
        }

        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $log_data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        }

        $syslog = LogException::create($log_data);

        //TODO::开发者对异常的操作
        //可以在此交由系统处理
        return parent::render($e);
    }

}