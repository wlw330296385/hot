<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CoachService;
use app\service\ScheduleService;
use think\Db;
class Coach extends Base{
	protected $coachService;
    protected $scheduleService;
	public function _initialize(){
		parent::_initialize();
		$this->coachService = new CoachService;
        $this->scheduleService = new ScheduleService;

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
    public function createCoach(){

        return view('Referee/createReferee');
    }

    public function updateCoach(){

        return view('Referee/updateReferee');
    }


    //注册成功
    public function registerSuccess(){
        return view('Coach/registerSuccess');
    }

}