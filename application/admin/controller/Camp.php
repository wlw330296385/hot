<?php
// 训练营
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use think\Db;
use think\Validate;
use think\Cookie;
use app\service\AuthService;
use app\model\Camp as CampModel;
use app\model\Member as MemberModel;

class Camp extends Backend {
    // 训练营列表
    public function index() {
        $list = CampModel::paginate(15);
        $breadcrumb = ['title' => '训练营管理', 'ptitle' => '训练营模块'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        return $this->fetch('camp/index');
    }

    // 训练营详情
    public function show() {
        $id = input('id');
        $camp = CampModel::get($id)->toArray();
        $camp['cert'] = $camp['cert_id'] ? getCert($camp['cert_id']) : '';
        $camp_member = MemberModel::get(['id' => $camp['member_id']])->toArray();
        $camp_member['cert'] = $camp_member['cert_id'] ? getCert($camp_member['cert_id']) : '';
        $camp['member_info'] = $camp_member;

        $breadcrumb = ['title' => '训练营详情', 'ptitle' => '训练营模块'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('camp', $camp);
        return view('camp/show');
    }

    // 修改训练营信息
    public function edit() {
        if ( request()->isPost() ) {
            $id = input('id');
            $sys_remarks = input('sys_remarks');
            $token = input('__token__');
            $rule = [
                'id' => 'require',
                '__token__' => 'token',
            ];
            $data = [
                'id' => $id,
                '__token__' => $token,
            ];
            $validate = new Validate($rule);
            $result = $validate->check($data);
            if (!$result)
            {
                $this->error($validate->getError());
                return;
            }

            $update = [
                'id' => $id,
                'sys_remarks' => $sys_remarks,
                'update_time' => time()
            ];
            $execute = Db::name('camp')->update($update);

            $Auth = new AuthService();
            if ( $execute ) {
                $Auth->record('训练营id:'. $id .' 修改平台备注 成功');
                $this->success(__lang('MSG_100_SUCCESS'), 'camp/index');
            } else {
                $Auth->record('训练营id:'. $id .' 修改平台备注 失败');
                $this->error(__lang('MSG_200_ERROR'));
            }
        }
    }

    // 审核训练营申请
    public function audit() {
        if ( request()->isAjax() ) {
            $campid = input('campid');
            $memberid = input('memberid');
            $status = input('status');
            $sys_remarks = input('sys_remarks');
            $data = [
                'id' => $campid,
                'status' => $status,
                'sys_remarks' => $sys_remarks,
                'update_time' => time()
            ];
            $execute = Db::name('camp')->update($data);

            $Auth = new AuthService();
            if ( $execute ) {
                $no = '';
                if ($status == 3) {
                    $no = '不';
                }

                // update grade_member status
                Db::name('grade_member')->where([
                    'camp_id' => $campid,
                    'member_id' => $memberid,
                    'type' => 3,
                ])->setField('status' ,1 );

                $doing = '审核训练营id: '. $campid .' 审核'. $no .'通过 成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_100_SUCCESS'), 'goto' => url('camp/index') ];
            } else {
                $doing = '审核训练营id: '. $campid .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_200_ERROR') ];
            }
            return $response;
        }
    }

    // 软删除
    public function sdel() {
        $id = input('id');
        $Camp = new CampService();
        $result = $Camp->SoftDeleteCamp($id);
        $Auth = new AuthService();
        if ( $result ) {
            $Auth->record('训练营id:'. $id .' 软删除 成功');
            $this->success(__lang('MSG_100_SUCCESS'), 'camp/index');
        } else {
            $Auth->record('训练营id:'. $id .' 软删除 失败');
            $this->error(__lang('MSG_200_ERROR'));
        }
    }

    //设置当前查看训练营
    public function setcur() {
        $id = input('id');
        $camp = CampModel::get($id)->toArray();
//        dump($camp);

        if ($camp) {
            Cookie::set('camp_id', $camp['id'], ['prefix' => 'curcamp_']);
            Cookie::set('camp', $camp['camp'], ['prefix' => 'curcamp_']);

            $this->success(__lang('MSG_100_SUCCESS'));
        } else {
            $this->error(__lang('MSG_200_ERROR'));
        }
    }

    public function clearcur() {
        $curcamp = $this->getCurCamp();
        if ($curcamp) {
            Cookie::clear('curcamp_');

            $this->success(__lang('MSG_100_SUCCESS'));
        }
    }
}
