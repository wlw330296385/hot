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

        return view('Referee/index');
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

}