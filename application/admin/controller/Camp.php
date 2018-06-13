<?php
// 训练营
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\MessageService;
use app\service\WechatService;
use think\Db;
use think\Validate;
use think\Cookie;
use app\service\AuthService;
use app\model\Camp as CampModel;
use app\model\Member as MemberModel;
use app\service\CampService;

class Camp extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    // 训练营列表
    public function index() {
        $list = CampModel::order('id desc')->paginate(15)->each(function($item, $key){
            $item->status_num = CampModel::get($item->id)->getData('status');
        });
        $breadcrumb = ['title' => '训练营管理', 'ptitle' => '训练营模块'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        return $this->fetch('camp/index');
    }

    // 训练营详情
    public function show() {
        $id = input('id');
        $camp = CampModel::get($id)->getData();
        $campS = new CampService();
        $camp['cert'] = $campS->getCampCert($id);
        $camp_member = MemberModel::get(['id' => $camp['member_id']])->toArray();
        $camp['member_info'] = $camp_member;
        $breadcrumb = ['title' => '训练营详情', 'ptitle' => '训练营模块'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('camp', $camp);
        return view('camp/show');
    }

    // 修改训练营信息
    public function edit() {
        if ( request()->isPost() ) {
            $request = request()->post();
            $id = $request['id'];
            $rule = [
                'id' => 'require',
                '__token__' => 'token',
            ];

            $validate = new Validate($rule);
            $result = $validate->check($request);
            if (!$result)
            {
                $this->error($validate->getError());
                return;
            }
            if (isset($request['__token__'])) {
                unset($request['__token__']);
            }
            // 保存课时收入平台抽取比例空值
            if (empty($request['schedule_rebate']) || $request['schedule_rebate']<0) {
                $request['schedule_rebate'] = 0.1;
            }
            // 保存课时收入平台抽取比例空值
            if (empty($request['refund_rebate'])) {
                $request['refund_rebate'] = 0.1;
            }
            $execute = Db::name('camp')->update($request);

            $Auth = new AuthService();
            if ( $execute || ($execute === 0) ) {
                $Auth->record("训练营id:{$id} 修改信息 成功 data:".json_encode($request));
                $this->success(__lang('MSG_200'), 'camp/index');
            } else {
                $Auth->record("训练营id:{$id} 修改信息 失败 data:".json_encode($request));
                $this->error(__lang('MSG_400'));
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

            $execute = Db::name('camp')->update([
                'id' => $campid,
                'status' => $status,
                'system_remarks' => $sys_remarks,
                'update_time' => time()
            ]);

            $Auth = new AuthService();
            if ( $execute ) {
                $memberopenid = getMemberOpenid($memberid);
                if ($status == 3) {
                    $checkstr = '审核未通过';
                    $remark = '点击进入修改完善资料';
                    $url = url('frontend/camp/campsetting', ['camp_id' => $campid, 'openid' => $memberopenid], '', true);
                } else {
                    $checkstr = '审核已通过';
                    $remark = '点击进入训练营进行操作吧';
                    $url = url('frontend/camp/powercamp', ['camp_id' => $campid, 'openid' => $memberopenid], '', true);
                }

                $sendTemplateData = [
                    'touser' => $memberopenid,
                    'template_id' => 'xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88',
                    'url' => $url,
                    'data' => [
                        'first' => ['value' => '您好,您所提交的训练营注册申请 '.$checkstr],
                        'keyword1' => ['value' => $checkstr],
                        'keyword2' => ['value' => date('Y年m月d日 H时i分')],
                        'remark' => ['value' => $remark]
                    ]
                ];
                $wechatS = new WechatService();
                $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
                $log_sendTemplateData = [
                    'wxopenid' => $memberopenid,
                    'member_id' => $memberid,
                    'url' => $sendTemplateData['url'],
                    'content' => serialize($sendTemplateData),
                    'create_time' => time()
                ];
                if ($sendTemplateResult) {
                    $log_sendTemplateData['status'] = 1;
                } else {
                    $log_sendTemplateData['status'] = 0;
                }
                db('log_sendtemplatemsg')->insert($log_sendTemplateData);

                $doing = '审核训练营id: '. $campid .'审核操作:'. $checkstr .'成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_200'), 'goto' => url('camp/index') ];
            } else {
                $doing = '审核训练营id: '. $campid .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_400') ];
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
            db('camp_member')->where(['camp_id' => $id])->update([
                'status' => -1,
                'delete_time' => time(),
                'system_remarks' => date('Ymd H:i', time()) . '控制台注销训练营'
            ]);
            $Auth->record('训练营id:'. $id .' 软删除 成功');
            $this->success(__lang('MSG_200'), 'camp/index');
        } else {
            $Auth->record('训练营id:'. $id .' 软删除 失败');
            $this->error(__lang('MSG_400'));
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

            $this->success(__lang('MSG_200'));
        } else {
            $this->error(__lang('MSG_400'));
        }
    }

    public function clearcur() {
        $curcamp = $this->getCurCamp();
        if ($curcamp) {
            Cookie::clear('curcamp_');

            $this->success(__lang('MSG_200'));
        }
    }

    // 修改训练营状态
    public function editstatus() {
        $id = input('id');
        $campObj = CampModel::get($id);
        $camp = $campObj->toArray();
        $camp['status_num'] = $campObj->getData('status');
//        dump($camp);
        $setcampstatus = 0;
        $messageS = new MessageService();
        if ($camp['status_num'] == 1) { // 执行下架
            $lessonM = new \app\model\Lesson();
            $lessonM->where(['camp_id' => $camp['id']])->setField('status', -1);
            $setcampstatus = 2;
            $messageData = [
                'title' => '您好,您的"'. $camp['camp'] .'"训练营被平台设为下架状态',
                'content' => '您好,您的训练营被平台设为下架状态',
                'url' => url('frontend/message/index', '', '', true),
                'keyword1' => '训练营状态发生变更',
                'keyword2' => '被设为下架状态',
                'keyword3' => date('Y年m月d日 H时i分'),
                'remark' => '如有疑问，请联系客服'
            ];
            $messageS->sendMessageToMember($camp['member_id'], $messageData, config('wxTemplateID.statusChange'));
        } else if ($camp['status_num'] == 2) { // 执行上架
            $setcampstatus = 1;
            //dump($camp);die;
            $messageData = [
                'title' => '您好,您的"'. $camp['camp'] .'"训练营被平台设为上架状态',
                'content' => '您好,您的训练营被平台设为上架状态',
                'url' => url('frontend/message/index', '', '', true),
                'keyword1' => '训练营状态发生变更',
                'keyword2' => '被设为上架状态',
                'keyword3' => date('Y年m月d日 H时i分'),
                'remark' => '如有疑问，请联系客服'
            ];
            $messageS->sendMessageToMember($camp['member_id'], $messageData, config('wxTemplateID.statusChange'));
        } else {
            // 审核通过
            $setcampstatus = 1;
            //dump($camp);die;
            $messageData = [
                'title' => '您好,您所提交的"'. $camp['camp'] .'"训练营注册申请审核已通过',
                'content' => '您好,您所提交的训练营注册申请审核已通过',
                'url' => url('frontend/camp/powercamp', ['camp_id' => $camp['id']], '', true),
                'keyword1' => '审核已通过',
                'keyword2' => date('Y年m月d日 H时i分'),
                'remark' => '点击进入训练营进行操作吧'
            ];
            $messageS->sendMessageToMember($camp['member_id'], $messageData, config('wxTemplateID.successCheck'));
        }
        $result = CampModel::where('id', $camp['id'])->update(['status'=>$setcampstatus]);
        $Auth = new AuthService();
        if ( $result ) {
            $Auth->record('训练营id:'. $id .' 更新状态 成功');
            $this->success(__lang('MSG_200'), 'camp/index');
        } else {
            $Auth->record('训练营id:'. $id .' 更新状态 失败');
            $this->error(__lang('MSG_400'));
        }
    }

    // 输出机构版首页微信授权链接
    public function wxindex() {
        // 微信授权链接地址
        $id = input('id', 0);
        $WechatS = new WechatService();
        $url = $WechatS->oauthRedirect(url('frontend/index/indexofcamp',['o_id'=> $id,'o_type'=>1], '', true));
        return view('camp/wxindex', [
            'url' => $url
        ]);
    }
}
