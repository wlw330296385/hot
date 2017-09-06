<?php 
namespace app\frontend\controller;
use app\frontend\controller\Frontend;
use app\service\ScoreService;
class Score extends Frontend{
	protected $ScoreService;
	public function _initialize(){
		parent::_initialize();
		$this->ScoreService = new ScoreService;
	}

    public function index() {

    }



    // 我的积分
    public function myScore(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        if($member_id){
            $memberInfo = db('member')->where(['id'=>$member_id])->find();
            $this->assign('memberInfo',$memberInfo);
        }
        $scoreList = $this->ScoreService->getScoreList(['member_id'=>$member_id]);
        $this->assign('scoreList',$scoreList);
        return view('Score/myScore');
    }

}
