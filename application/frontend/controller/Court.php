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

        return view('Court/index');
    }


    public function courtInfo(){
    	$court_id = input('param.court_id');
    	$courtInfo = $this->CourtService->getCourtInfo(['id'=>$court_id]);
        $mediaList = db('court_media')->where(['court_id'=>$court_id])->limit(3)->select();
        $this->assign('courtInfo',$courtInfo);
        $this->assign('mediaList',$mediaList);
    	return view('Court/courtInfo');
    }

    public function courtList(){
        $camp_id = input('param.camp_id')?input('param.camp_id'):0;
        $courtList = $this->CourtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        $this->assign('courtList',$courtList);
        return view('Court/courtList');
    }

    public function updateCourt(){   	
    	$court_id = input('param.court_id');
        $camp_id = input('param.camp_id');
        $CampService = new \app\service\CampService;
        $power = $CampService->isPower($this->memberInfo['id'],$camp_id);
        if($power<2){
            $this->error('请先加入一个训练营并成为管理员或者创建训练营');
        }
		$CourtInfo = $this->CourtService->getCourtInfo(['id'=>$court_id]);
        $mediaList = $this->CourtMediaService->getCourtMediaList(['court_id'=>$court_id]);
		$this->assign('CourtInfo',$CourtInfo);
        $this->assign('mediaList',$mediaList);
    	return view('Court/updateCourt');
    }

    public function createCourt(){
        $camp_id = input('param.camp_id');
        $CampService = new \app\service\CampService;
        $power = $CampService->isPower($this->memberInfo['id'],$camp_id);
        if($power<2){
            $this->error('请先加入一个训练营并成为管理员或者创建训练营');
        }
        return view('Court/createCourt');
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