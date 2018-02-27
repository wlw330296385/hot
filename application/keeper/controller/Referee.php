<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\RefereeService;
use think\Db;
class Referee extends Base{
	protected $RefereeService;
	public function _initialize(){
		parent::_initialize();
		$this->RefereeService = new RefereeService;
	}

    // 裁判主页
    public function refereeManage(){
        $refereeInfo = $this->RefereeService->getRefereeInfo(['member_id'=>$this->memberInfo['id']]);
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


    public function refereeInfo(){
        $referee_id = input('param.referee_id');
        $refereeInfo = $this->RefereeService->getRefereeInfo(['id'=>$referee_id]);
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
            'license' => $license
        ]);
    }

    public function updateReferee(){
        $referee_id = input('param.referee_id');
        $refereeInfo = $this->RefereeService->getRefereeInfo(['id'=>$referee_id]);
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
            'license' => $license
        ]);
    }


    //注册成功
    public function registerSuccess(){
        return view('Referee/registerSuccess');
    }


    // 申请列表
    public function applyList(){
        $type = input('param.type',1);
        if($type == 1){

            return view('Referee/applyList1');
        }else{
            return view('Referee/applyList2');
        }
    }


    public function myMatchList(){
        $referee_id = input('param.referee_id');

        

        $this->assign('referee_id',$referee_id);

        return view('Referee/myMatchList');
    }
}