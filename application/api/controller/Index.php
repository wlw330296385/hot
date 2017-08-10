<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\LessonService;
class Index extends Base{
	protected $LessonService;
	public function _initialize(){
		parent::_initialize();
		$this->LessonService = new LessonService;
	}


}
