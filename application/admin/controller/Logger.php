<?php

namespace app\admin\controller;
use app\admin\controller\base\Backend;
use think\Controller;
use think\Request;
use think\Validate;
use think\Cache;
use think\Db;

use app\model\LogException;

class Logger extends Backend 
{

    public function systemException()
    {
        $list = Db::table('log_exception')
            ->field('max(id) as id, line, file, message, count(id) as count, min(create_time) as min, max(create_time) as max')
            ->group('line, message, file')
            ->order('max desc')
            ->select();

        $this->assign('list',$list);
        return view('systemException');
    }

    public function systemExceptionDetails()
    {
        $id = input('param.id');
        $systemExceptionInfo = LogException::get(['id' => $id]);
        if (empty($systemExceptionInfo)) {
            $this->error('找不到该id');
        }
        $list = Db::table('log_exception')
            ->field('line, file, message, count(id) as count, min(create_time) as min, max(create_time) as max')
            ->group('line, message, file')
            ->order('max desc')
            ->select();
            
        $this->assign('systemExceptionInfo', $systemExceptionInfo);
        $this->assign('list', $list);
        return view('systemExceptionDetails');
    }
}