<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\LessonService;
class Index extends Base{
	protected $LessonService;
	public function _initialize(){
		parent::_initialize();
		$this->LessonService = new LessonService;
	}

    public function index() {
        $page = input('param.page')?input('param.page'):1;
    	$bannerList = unserialize($this->systemSetting['banner']); 
    	// 热门课程
    	$hotLessonList = $this->LessonService->getLessonList([],$page,'hot ASC',4);
    	//推荐课程
    	$sortLessonList = $this->LessonService->getLessonList([],$page,'sort ASC',4);
    	$this->assign('bannerList',$bannerList);
    	$this->assign('hotLessonList',$hotLessonList);
    	$this->assign('sortLessonList',$sortLessonList);
        return view('Index/index');
    }



    public function search(){
        return view();
    }

    public function test(){
        
    }
}
