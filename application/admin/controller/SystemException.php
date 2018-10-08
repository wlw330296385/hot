<?php

namespace app\admin\controller;
use app\admin\controller\base\Backend;

use think\Controller;
use think\Request;
use think\Validate;
use think\Db;

use app\model\LogException;

class SystemException extends Backend 
{
    public function _initialize(){
        parent::_initialize();
    }

    public function index()
    {
        echo $list;
        switch (input('param.status', 0)) {
            case '1':
                $status = 1;
                break;
            case '-1':
                $status = -1;
                break;
            default:
                $status = 0;
                break;
        }
        $list = Db::table('log_exception')
            ->field('max(id) as id, line, file, message, count(id) as count, min(create_time) as min, max(create_time) as max')
            ->where(['status' => $status])
            ->group('line, message, file')
            ->order('max desc')
            ->select();

        $this->assign('list',$list);
        return view('SystemException/index');
    }

    public function info()
    {
        $id = input('param.id');
        
        $exceptionInfo = LogException::get($id);
        if (empty($exceptionInfo)) {
            $this->error("未找到该异常信息");
        }

        $exceptionStats = Db::table('log_exception')
        ->field("
            min(`create_time`) AS min,
            max(`create_time`) AS max,
            count(distinct member_id) AS member_count,
            count(distinct update_time) AS fix_count,
            count(id) AS id_count,
            sum(case when status = '0' then 1 else 0 end) AS 'waiting_count'
        ")
        ->where([
            'file' => $exceptionInfo["file"],
            'line' => $exceptionInfo["line"],
            'message' => $exceptionInfo["message"]
        ])->find();
        $exceptionStats['fix_rate'] = ($exceptionStats['id_count'] - $exceptionStats["waiting_count"]) * 100/ $exceptionStats['id_count'];

        $exceptionGroup = Db::table('log_exception')
        ->field("
            min(create_time) AS min,
            max(create_time) AS max,
            count(id) AS fix_count,
            fixed_by,
            update_time,
            status
        ")
        ->where([
            'file' => $exceptionInfo["file"],
            'line' => $exceptionInfo["line"],
            'message' => $exceptionInfo["message"],
            'status' => ['neq', 0]
        ])
        ->group('fixed_by,update_time')
        ->order('update_time desc')
        ->select();

        $this->assign('exceptionInfo',$exceptionInfo);
        $this->assign('exceptionStats',$exceptionStats);
        $this->assign('exceptionGroup',$exceptionGroup);
        return view('SystemException/info');
    }

    public function update() {
        $data = input('post.');
        if (empty($data['id'])) {
            return json(['code' => 400, 'msg' => 'id不能为空']);
        }
        if (empty($data['status'])) {
            return json(['code' => 400, 'msg' => 'status不能为空']);
        }

        $model = new LogException();
        $info = $model->get($data['id']);
        if (empty($info)) {
            return json(['code' => 400, 'msg' => __lang('MSG_404')]);
        }

        if (isset($data['is_batch']) || !empty($data['is_batch'])) {
            // 如果是批量操作
            $now = time();
            $result = $model->where([
                'message'   => $info['message'],
                'line'      => $info['line'],
                'file'      => $info['file'],
                'status'    => 0
            ])->update(['status' => $data['status'], 'fixed_by' => $this->admin, 'update_time' => $now]);
        } else {
            // 如果不是批量操作
            $data['id'] = $info['id'];
            $data['fixed_by'] = $this->admin;
            $result = $model->isUpdate()->save($data);
        }

        return json(['code' => 200, 'data' => $result]);
    }
}