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

  		$messageMemberList = $this->MessageService->getMessageMemberList([]);
  		$messageList = $this->MessageService->getMessageList([]);
  		


  		$this->assign('messageMemberList',$messageMemberList);
  		$this->assign('messageList',$messageList);
        return view('Message/index');
    }
}