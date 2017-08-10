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

    	$bannerList = unserialize($this->systemSetting['banner']); 
    	// 热门课程
    	$hotLessonList = $this->LessonService->getLessonAll([],'hot ASC',4);
    	//推荐课程
    	$sortLessonList = $this->LessonService->getLessonAll([],'sort ASC',4);
    	// $bannerList = ['/uploads/images/banner/1.jpg','/uploads/images/banner/2.jpg','/uploads/images/banner/3.jpg'];
    	// echo serialize($bannerList);die;
    	$this->assign('bannerList',$bannerList);
    	$this->assign('hotLessonList',$hotLessonList['data']);
    	// dump($hotLessonList['data']);die;
    	$this->assign('sortLessonList',$sortLessonList['data']);
        return view();
    }



    public function search(){
        return view();
    }
}
