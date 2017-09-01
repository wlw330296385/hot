<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CourtService;
use app\service\CourtMediaService;
class Court extends Base{
	protected $CourtService;
    protected $CourtMediaService;
	public function _initialize(){
		parent::_initialize();
		$this->CourtService = new CourtService;
        $this->CourtMediaService = new CourtMediaService;
	}

    public function index() {

        return view();
    }


    public function courtInfo(){
    	$court_id = input('param.court_id');
    	$courtInfo = $this->CourtService->getCourtInfo(['id'=>$court_id]);
        $mediaList = db('court_media')->where(['court_id'=>$court_id])->limit(3)->select();
        $this->assign('courtInfo',$courtInfo);
        $this->assign('mediaList',$mediaList);
    	return view();
    }

    public function courtList(){
        $courtList1 = $this->CourtService->getCourtList(['camp_id'=>1,'status'=>1]);
        $courtList0 = $this->CourtService->getCourtList(['camp_id'=>1,'status'=>0]);
        $this->assign('courtList1',$courtList1);
        $this->assign('courtList0',$courtList0);
        return view();
    }

    public function updateCourt(){   	
    	$court_id = input('param.court_id');
		$CourtInfo = $this->CourtService->getCourtInfo(['id'=>$court_id]);
        // dump($CourtInfo);die;
        $mediaList = $this->CourtMediaService->getCourtMediaList(['court_id'=>$court_id]);
		$this->assign('CourtInfo',$CourtInfo);
        $this->assign('mediaList',$mediaList);
    	return view();
    }

    public function createCourt(){
        // $pidList = $this->CourtService->getCourtList(['pid'=>0]);

        // $this->assign('pidList',$pidList['data']);
        return view();
    }
    // 分页获取数据
    public function courtListApi(){
    	$camp_id = input('param.camp_id');
        $condition = input('post.');
        $where = ['status'=>['or',[1,$camp_id]]];
        $map = array_merge($condition,$where);
    	$courtList = $this->CourtService->getCourtPage($map,10);
    	return json($result);
    }

}