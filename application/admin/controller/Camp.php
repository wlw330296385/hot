<?php
// 训练营
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\CertService;
use app\service\GradeMemberService;
use app\service\MemberService;
use think\Db;
use think\Validate;
use app\service\AuthService;
use app\service\CampService;

class Camp extends Backend {
    // 训练营列表
    public function index() {
        $Camp = new CampService();
        $res = $Camp->campListPage();
        if ($res['code'] != 200) {
            $list = $res['data'];
        }
        $breadcrumb = ['title' => '训练营管理', 'ptitle' => '训练营模块'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        //return view();
        return $this->fetch();
    }

    public function detail() {
        $id = input('id');
        $Camp = new CampService();
        $res = $Camp->CampOneById($id);
        if ($res['code'] != 200) {
            $camp = $res['data'];
        }
        $Member_S = new MemberService();
        $Cert = new CertService();
        // 训练营创建人会员数据
        $camp_member_res = $Member_S->getMemberInfo([ 'id' => $camp['member_id'] ]);
        if ($camp_member_res['code' ]!= 200) {
            $camp_member = $camp_member_res['data'];
            $camp_member['cert'] = $camp_member['cert_id'] ? getCert($camp_member['cert_id']) : '';
            $camp['member'] = $camp_member;
        }
        $cert = $camp['cert_id'] ? $Cert->CertOneById($camp['cert_id']) : '';

        $breadcrumb = ['title' => '训练营详情', 'ptitle' => '训练营模块'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('camp', $camp);
        $this->assign('cert', $cert);
        return view();
    }

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

            $data = [
                'id' => $id,
                'sys_remarks' => $sys_remarks,
                'update_time' => time()
            ];
            $Camp = new CampService();
            $result = $Camp->UpdateCamp($data);

            $Auth = new AuthService();
            if ( $result['code'] == 100 ) {
                $Auth->record('训练营id:'. $id .' 修改平台备注 成功');
                $this->success(__lang('MSG_100_SUCCESS'), 'camp/index');
            } else {
                $Auth->record('训练营id:'. $id .' 修改平台备注 失败');
                $this->error(__lang('MSG_200_ERROR'));
            }
        }
    }

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
}
