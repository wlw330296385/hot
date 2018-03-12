<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\MatchService;
use app\service\RefereeService;
use think\Db;
class Referee extends Base{
	protected $refereeService;
	protected $refereeId;
	protected $refereeInfo;
	public function _initialize(){
		parent::_initialize();
		$this->refereeService = new RefereeService;
		$refereeId = input('referee_id', 0);
		$refereeInfo = $this->refereeService->getRefereeInfo(['id' => $refereeId]);
		$this->assign('refereeId', $refereeId);
		$this->assign('refereeInfo', $refereeInfo);
	}

    // 裁判主页
    public function refereeManage(){
        $refereeInfo = $this->refereeService->getRefereeInfo(['member_id'=>$this->memberInfo['id']]);
        // 接单次数
        $totalOrder = 0;
        // 受邀次数
        $totalInvited = 0;
        $Apply = new \app\model\Apply;
        // $applyMap = function($query) use($refereeInfo){
        //     $query->where(['member_id'=>$refereeInfo['member_id']])
        // }
        $applyList = $Apply
                    ->where('type',['=',6],['=',7],'or')
                    ->where(['member_id'=>$refereeInfo['member_id']])
                    ->where(['organization_type'=>4])
                    ->select();

        foreach ($applyList as $key => $value) {
            if($value['apply_type'] == 2){
                $totalInvited++;
            }
            if($value['apply_type'] == 1 && $value['status'] == 2){
                $totalOrder++;
            }
        }
        // 执裁场次
        $totalMatch = db('match_referee')->where(['referee_id'=>$refereeInfo['id']])->count();
        
        $this->assign('refereeInfo',$refereeInfo);
        $this->assign('totalMatch',$totalMatch);
        $this->assign('totalOrder',$totalOrder);
        $this->assign('totalInvited',$totalInvited);
        return view('Referee/refereeManage');
    }


    public function refereeList(){


        return view('Referee/refereeList');
    }

    //
    public function refereeInfo(){
        $referee_id = input('param.referee_id');
        $refereeInfo = $this->refereeService->getRefereeInfo(['id'=>$referee_id]);
        $commentList = db('referee_comment')->where(['referee_id'=>$referee_id])->select();
        $this->assign('commentList',$commentList);
        $this->assign('refereeInfo',$refereeInfo);
        return view('Referee/refereeInfo');
    }

    //裁判员注册
    public function createReferee(){
        // 获取会员证件数据
        $idcard = $license = [];
        $certList = db('cert')->where(['member_id'=>$this->memberInfo['id']])->select();
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
        return view('Referee/createReferee', [
            'idcard' => $idcard,
            'license' => $license,
            'hasidcard' => empty($idcard) ? 0 : 1
        ]);
    }

    // 修改裁判员信息
    public function updateReferee(){
        $referee_id = input('param.referee_id');
        $refereeInfo = $this->refereeService->getRefereeInfo(['id'=>$referee_id]);
        if (!$refereeInfo) {
            $this->error(__lang('MSG_404'));
        }
        // 获取会员证件数据
        $idcard = $license = [];
        $certList = db('cert')->where(['member_id'=>$this->memberInfo['id']])->select();
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
        
        return view('Referee/updateReferee', [
            'refereeInfo' => $refereeInfo,
            'idcard' => $idcard,
            'license' => $license,
            'hasidcard' => empty($idcard) ? 0 : 1
        ]);
    }

    //注册成功
    public function registerSuccess(){
        return view('Referee/registerSuccess');
    }

    // 比赛申请/邀请列表
    public function applyList(){
        $type = input('param.type',1);
        $view = 'Referee/applyList';
        return view($view.$type);
    }

    // 比赛邀请详情
    public function matchapply() {
        $id = input('apply_id', 0);
        $matchId = input('match_id', 0);
        $refereeInfo = $this->refereeService->getRefereeInfo(['member_id' => $this->memberInfo['id']]);

        // 查询比赛邀请数据
        $map =[];
        if ($id) {
            $map['id'] = $id;
        }
        if ($matchId) {
            $map['match_id'] = $matchId;
            $map['referee_id'] = $refereeInfo['id'];
        }
        $matchService = new MatchService();
        $applyInfo = $matchService->getMatchRerfereeApply($map);
        // 查询关联的比赛数据
        $matchInfo = $matchService->getMatch(['id' => $applyInfo['match_id']]);
        $matchRecordInfo = $matchService->getMatchRecord(['id' => $applyInfo['match_record_id']]);
        if ($matchRecordInfo) {
            $matchInfo['record'] = $matchRecordInfo;
        }

        return view('Referee/matchApply', [
            'applyInfo' => $applyInfo,
            'matchInfo' => $matchInfo
        ]);
    }

    // 执裁比赛列表
    public function myMatchList(){
        return view('Referee/myMatchList');
    }
}