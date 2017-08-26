<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ScoreService;
class Score extends Base{
	protected $ScoreService;
	public function _initialize(){
		parent::_initialize();
		$this->ScoreService = new ScoreService;
	}

    public function index() {

    }



    // 我的积分
    public function myScore(){
        $member_id = $this->memberInfo['id'];
        $scoreList = $this->ScoreService->getScoreList(['member_id'=>$member_id]);

        $this->assign('scoreList',$scoreList);
        return view();
    }

}
