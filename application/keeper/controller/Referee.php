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
        //判断是否已存在身份证
        $certList = db('cert')->where(['member_id'=>$this->memberInfo['id']])->select();
        $credit = [];
        $refereeCert = [];
        foreach ($certList as $key => $value) {
            if($value['cert_type'] == 5){
                $refereeCert = $value;
            }elseif($value['cert_type'] == 1){
                $credit = $value;
            }
        }
        
        $this->assign('credit',$credit);
        $this->assign('refereeCert',$refereeCert);
        return view('Referee/createReferee');
    }

    public function updateReferee(){
        $referee_id = input('param.referee_id');
        $refereeInfo = $this->RefereeService->getRefereeInfo(['id'=>$referee_id]);
        //判断是否已存在身份证
        $certList = db('cert')->where(['member_id'=>$this->memberInfo['id']])->select();
        $credit = [];
        $refereeCert = [];
        foreach ($certList as $key => $value) {
            if($value['cert_type'] == 5){
                $refereeCert = $value;
            }elseif($value['cert_type'] == 1){
                $credit = $value;
            }
        }
        // dump($credit);die;
        $this->assign('credit',$credit);
        $this->assign('refereeCert',$refereeCert);
        $this->assign('refereeInfo',$refereeInfo);
        return view('Referee/updateReferee');
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