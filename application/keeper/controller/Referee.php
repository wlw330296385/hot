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

    // 教练主页
    public function refereeManage(){

        return view('Referee/index');
    }


    public function refereeList(){
        return view('Referee/refereeList');
    }


    public function refereeInfo(){

        return view('Referee/refereeInfo');
    }

    //教练员注册
    public function createReferee(){
        //判断是否已存在身份证
        $certList = db('cert')->where(['id'=>$this->memberInfo['id']])->select();
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

        return view('Referee/updateReferee');
    }


    //注册成功
    public function registerSuccess(){
        return view('Referee/registerSuccess');
    }

}