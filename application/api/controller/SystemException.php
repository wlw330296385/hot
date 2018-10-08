<?php

namespace app\api\controller;
use think\Request;
use think\Controller;
use think\Session;
use app\model\LogException;

class SystemException extends controller{

    public function addmenu() {
        $data = input('post.');
        $model = new LogException();
        $result = $model->isUpdate()->save($data);
        return json(['code' => 200, 'data' => $result]);
    }

    public function update() {
        $data = input('post.');
        return 1;
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


