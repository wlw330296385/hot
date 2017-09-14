<?php
// 教练
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\CoachService;
use app\service\AuthService;
use think\Db;
use app\model\Coach as CoachModel;

class Coach extends Backend {
    // 教练列表
    public function index() {
        $list = CoachModel::order('create_time desc')->paginate(15);

        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '教练管理' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 教练详情
    public function show() {
        $id = input('id');

        $coach = CoachModel::with('member')->where(['id' => $id])->find()->toArray();
        $coach['cert'] = $coach['cert_id'] ? getCert($coach['cert_id']) : '';
        // 教练所在训练营集合
       $coachInCamp = Db::name('camp_member')->where([ 'member_id' => $coach['member_id'], 'type' => ['in', '2,4'] ])->select();
        $coach['_incamp'] = '';
        foreach ($coachInCamp as $k => $val) {
            $coach['_incamp'] .= $val['camp'] . ',';
        }
        $coach['member']['cert'] = $coach['member']['cert_id'] ? getCert($coach['member']['cert_id']) : '';
        //dump($coach);

        $breadcrumb = [ 'ptitle' => '教练管理' , 'title' => '教练详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('coach', $coach);
        return view();
    }

    // 教练审核
    public function audit() {
        if ( request()->isAjax() ) {
            $id = input('coach');
            $status = input('code');
            $data = [
                'id' => $id,
                'status' => $status,
                'update_time' => time()
            ];

            $execute = Db::name('coach')->update($data);
            $Auth = new AuthService();
            if ( $execute ) {
                $no = '';
                if ($status == 2) {
                    $no = '不';
                }
                $doing = '审核教练id: '. $id .' 审核'. $no .'通过 成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_100_SUCCESS'), 'goto' => url('coach/index') ];
            } else {
                $doing = '审核教练id: '. $id .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_200_ERROR') ];
            }
            return $response;
        }
    }

    // 软删除教练
    public function sdel() {
        $id = input('id');
        $Coach = new CoachService();
        $result = $Coach->SoftDeleteCamp($id);

        $Auth = new AuthService();
        if ( $result['code'] == 100 ) {
            $Auth->record('教练id:'. $id .' 软删除 成功');
            $this->success($result['msg'], 'coach/index');
        } else {
            $Auth->record('教练id:'. $id .' 软删除 失败');
            $this->error($result['msg']);
        }
    }

    // 修改教练信息
    public function edit() {
        if ( request()->isPost() ) {
            $id = input('id');
            $validate = $this->validate(
                [
                    'id' => $id,
                    '__token__' => input('__token__')
                ],
                [
                    'id' => 'require',
                    '__token__' => 'token',
                ]
            );
            if ( true !== $validate ) {
                $this->error($validate);
            }
            $data = [
                'id' => $id,
                'coach_rank' => input('coach_rank'),
                'coach_year' => input('coach_year'),
                'coach_level' => input('coach_level'),
                'student_flow' => input('student_flow'),
                'lesson_flow' => input('lesson_flow'),
                'sys_remarks' => input('sys_remarks'),
                'update_time' => time()
            ];
            $execute = Db::name('coach')->update($data);


            $Auth = new AuthService();
            if ( $execute ) {
                $Auth->record('教练id:'. $id .' 修改平台备注 成功');
                $this->success(__lang('MSG_100_SUCCESS'), 'coach/index');
            } else {
                $Auth->record('教练id:'. $id .' 修改平台备注 失败');
                $this->error(__lang('MSG_200_ERROR'));
            }
        }
    }
}