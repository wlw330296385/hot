<?php 
namespace app\school\controller;
use app\school\controller\Base;
use app\service\MessageService;
class Message extends Base{
	protected $MessageService;
	public function _initialize(){
		parent::_initialize();
		$this->MessageService = new MessageService;
	}

    public function index() {
        return view('Message/index');
    }
}