<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\LessonService;
use app\service\WechatService;
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
       /* session(null,'think');
        $param = input('param.');
        cache('param',$param);
        cookie('param', $param);
        dump($param);
        dump($this->memberInfo);
        dump(session('memberInfo','','think'));
        dump(cache('param'));
        dump(cookie('param'));*/

        $WechatService = new WechatService;
        $callback1 = url('login/wxlogin','','', true);
        $callback2 = url('login/wxlogin');
        dump( $WechatService -> oauthredirect($callback1) );
        dump( $WechatService -> oauthredirect($callback2) );
    }
}
