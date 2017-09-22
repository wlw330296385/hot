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
    	$this->assign('mid', cookie('mid'));
        return view('Index/index');
    }



    public function search(){
        
        return view('Index/search');
    }


    


    

    public function test(){

        // $this->redirect('/frontend/index/index/pid/1');
        dump($url = $_SERVER["REQUEST_URI"]);
        // cookie(null);
        session(null,'think');die;
        // $param = input('param.');
        // cache('param',$param);
        // cookie('param', $param);
        // dump($param);
        // dump($this->memberInfo);
        //session('memberInfo',['id'=>'0','openid'=>'o83291CzkRqonKdTVSJLGhYoU98Q','member'=>'woo'],'think');
        //dump(session('memberInfo','','think'));
        // dump(cache('param'));
        // dump(cookie('param'));

        // $WechatService = new WechatService;
        // $callback1 = url('login/wxlogin','','', true);
        // $callback2 = url('login/wxlogin');
        // dump( $WechatService -> oauthredirect($callback1) );
        // dump( $WechatService -> oauthredirect($callback2) );

        return view('Index/test');
    }
}
