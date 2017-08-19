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
    	$hotLessonList = $this->LessonService->getLessonList([],'hot ASC',4);
    	//推荐课程
    	$sortLessonList = $this->LessonService->getLessonList([],'sort ASC',4);
    	$this->assign('bannerList',$bannerList);
    	$this->assign('hotLessonList',$hotLessonList);
    	$this->assign('sortLessonList',$sortLessonList);
        return view();
    }



    public function search(){
        return view();
    }

    public function test(){
        $a = ['a'=>33333,'b'=>44444444,'c'=>55555555];
        $b = ['a'=>1111,'g'=>666666];
        $c = array_merge($a,$b);
        $c['url'] = '/uploads/images/lesson/1.jpg';
        $media = new \app\model\Media;
        $result = $media->allowField(true)->data($c)->save();
        dump($result);
        dump($c);
    }
}
