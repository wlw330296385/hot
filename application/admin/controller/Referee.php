<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\MessageService;
use app\service\RefereeService;
use app\model\Referee as RefereeModel;

class Referee extends Backend{
	public $RefereeService;
	public $refereeModel;
	public function _initialize(){
		parent::_initialize();
		$this->RefereeService = new RefereeService();
		$this->refereeModel = new RefereeModel();
	}


	// 裁判员列表
	public function index(){
        // 裁判员分页列表
		$refereeList = $this->refereeModel
            ->order(['id' => 'desc'])
            ->paginate()->each(function($item, $key) {
                $member = db('member')->where('id', $item->member_id)->whereNull('delete_time')->find();
                if ($member) {
                    $item->member = $member;
                }
            });

        // 模板变量赋值
		$this->assign('refereeList', $refereeList);
		return view('Referee/index');
	}

	public function refereeInfo(){
		$id = input('param.id', 0, 'intval');
		if (!$id) {
		    $this->error(__lang('MSG_402'));
        }
        // 获取裁判员数据
		$refereeInfo = $this->RefereeService->getRefereeInfo(['id'=>$id]);
		if (!$refereeInfo) {
		    $this->error(__lang('MSG_404'));
        }
        
		// 证书
        $idcard = $license = [];
		$certList = db('cert')->where(['member_id'=>$refereeInfo['member_id']])->select();
		if ($certList) {
		    foreach ($certList as $cert) {
		        // 资质证书
		        if ($cert['cert_type'] == 5) {
		            $license = $cert;
                }
                // 身份证
                if ($cert['cert_type'] ==1) {
		            $idcard = $cert;
                }
            }
        }

		return view('Referee/refereeInfo', [
		    'refereeInfo' => $refereeInfo,
            'idcard' => $idcard,
            'license' => $license
        ]);
	}

	// 修改裁判员状态
	public function updateRefereeStatus(){
	    // 判断请求与接收变量
		if ( !$this->request->isPost() ) {
            $this->error(__lang('MSG_402'));
        }
        $id = input('post.id');
		if (!$id) {
		    return json(['status' => 0, 'msg' => __lang('MSG_402')]);
        }
        // 获取裁判员数据
        $refereeInfo = $this->RefereeService->getRefereeInfo(['id'=>$id]);
        if (!$refereeInfo) {
            return json(['status' => 0, 'msg' => __lang('MSG_404')]);
        }
        $post = input('post.');
        $status = input('post.status');
		// 更新数据
		$res = $this->refereeModel->isUpdate(true)->save($post);
		if ($res) {
		    // 更新证件信息
            if ($status ==1) {
                db('cert')->where(['member_id' => $refereeInfo['member_id'], 'cert_type' => 5])->update(['status' => 1, 'update_time' => time()]);
            }

		    // 发送消息
            // 申核结果文字
            $checkStr = ($status==1) ? '审核通过' : '审核不通过';
            $messageS = new MessageService();
            $messageData = [
                'title' => '裁判员注册审核结果回复',
                'content' => '裁判员注册'.$checkStr,
                'keyword1' => '裁判员注册审核',
                'keyword2' => $checkStr,
                'remark' => '点击进入',
                'url' => ($status==1) ? url('keeper/referee/refereemanage', '', '', true) : url('keeper/message/index', '', '', true),
                'steward_type' => 2
            ];
            $messageS->sendMessageToMember($refereeInfo['member_id'], $messageData, config('wx.applyResult'));

            $this->record('审核裁判员id: '. $id .'审核操作:'. $checkStr .'，成功');
		    $response = ['code' => 200, 'status'=>1, 'msg' => __lang('MSG_200')];
        } else {
		    $response = ['code' => 100, 'status' => 0, 'msg' =>__lang('MSG_401')];
        }
        return json($response);
	}
}