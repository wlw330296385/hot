<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\MessageService;
class Message extends Base{
	protected $MessageService;
	public function _initialize(){
		parent::_initialize();
		$this->MessageService = new MessageService;
	}

    public function index() {

      $campIDs = db('camp_member')
                ->where(['member_id'=>$this->memberInfo['id'],'status'=>1])
                ->where('type','gt',2)
                ->column('camp_id');


    $messageList = $this->MessageService->getMessageList(['camp_id'=>['in',$campIDs]]);

  		$messageMemberList = $this->MessageService->getMessageMemberList(['member_id'=>$this->memberInfo['id']]);
  		
  		


  		$this->assign('messageMemberList',$messageMemberList);
  		$this->assign('messageList',$messageList);
        return view('Message/index');
    }
}