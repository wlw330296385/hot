<?php

namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\admin\model\Admin;
use util\Tree;
class User extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    public function index() {
        $users = Admin::with('admin_group')->order('id desc')->paginate(15);
        // dump($users);die;
        $this->assign('list', $users);
        return $this->fetch();
    }

    public function create() {
        $menu = db('admin_group')->select();
        $groupTree = Tree::toLayer($menu);
        // dump($groupTree);die;
        $this->assign('groupTree',$groupTree);
        return $this->fetch();
    }

    public function store() {
        if (request()->isPost()) {
            //dump(input('post.'));
            $data = input('post.');
            // $data['username'] = input('username');
            // $password = input('password');
            // $data['password'] = passwd($password);
            // $data['truename'] = input('truename');
            // $data['avatar'] = '/static/default/avatar.png';
            $model = new Admin();
            $res = $model->save($data);
            if ($res) {
                $this->record('新增管理员 id:'.$model->id.'成功');
                $this->success(__lang('MSG_200'), 'user/index');
            } else {
                $this->record('新增管理员 失败');
                $this->error(__lang('MSG_400'));
            }
        }
    }

    public function edit() {
        $id = input('id');
        $user = Admin::get($id);
        $menu = db('admin_group')->select();
        $groupTree = Tree::toLayer($menu);
        // dump($groupTree);die;
        $this->assign('groupTree',$groupTree);
        $this->assign('user', $user);
        return $this->fetch();
    }

    public function update() {
        if (request()->isPost()) {
            //dump(input('post.'));
            $id = input('id');
            $data['username'] = input('username');
            if (input('?password') && !empty(input('password'))) {
                $password = input('password');
                $data['password'] = passwd($password);
            }
            
            $data['truename'] = input('truename');
            $data['avatar'] = '/static/default/avatar.png';
            $model = new Admin();
            $res = $model->where(['id' => $id])->update($data);
            if ($res || ($res === 0)) {
                $this->record('修改管理员 id:'.$id.'成功');
                $this->success(__lang('MSG_200'), 'user/index');
            } else {
                $this->record('修改管理员 失败');
                $this->error(__lang('MSG_400'));
            }
        }
    }
}