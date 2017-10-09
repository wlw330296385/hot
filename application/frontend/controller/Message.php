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
      $camp_id = input('param.camp_id');
      if($camp_id){
          $messageList = $this->MessageService->getMessageList(['camp_id'=>$camp_id]);
      }else{
          $messageList = $this->MessageService->getMessageList();
      }
  		$messageMemberList = $this->MessageService->getMessageMemberList(['member_id'=>$this->memberInfo['id']]);
  		
  		


  		$this->assign('messageMemberList',$messageMemberList);
  		$this->assign('messageList',$messageList);
        return view('Message/index');
    }
}