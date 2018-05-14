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
        $camp_id = input('param.camp_id')?input('param.camp_id'):0;
        $isCourt = -1;
        $power = 0;
        $button = 0;
        $courtInfo = $this->CourtService->getCourtInfoWithCourtCamp($court_id,$camp_id);

        $CampService = new \app\service\CampService;
        $power = $CampService->isPower($camp_id,$this->memberInfo['id']);
        if($camp_id!=$courtInfo['campid'] && $power>2 && $courtInfo['status'] == 1){
            // 可以将场地添加到自己场地
            $button = 1;
        }elseif ( $courtInfo['campid'] == $camp_id && $power>2 && $courtInfo['status'] == -1){
            //可以编辑
            $button = 2;
        }elseif ($courtInfo['campid'] == $camp_id && $power>2 && $courtInfo['status'] == 1){
            $button = 3;
        }
        $this->assign('camp_id',$camp_id);
        $this->assign('button',$button);
        $this->assign('courtInfo',$courtInfo);
    	return view('Court/courtInfo');
    }

    public function courtList(){
        $camp_id = input('param.camp_id')?input('param.camp_id'):0;
        $courtList = $this->CourtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        $this->assign('courtList',$courtList);
        return view('Court/courtList');
    }

    // 场地列表 （机构版）
    public function courtListOfOrganization(){
        $camp_id = input('param.camp_id')?input('param.camp_id'):0;
        $courtList = $this->CourtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        $this->assign('courtList',$courtList);
        return view('Court/courtListOfOrganization');
    }

    public function updateCourt(){   	
    	$court_id = input('param.court_id');
        $CourtInfo = $this->CourtService->getCourtInfo(['id'=>$court_id]);
        $CampService = new \app\service\CampService;
        $power = $CampService->isPower($CourtInfo['camp_id'],$this->memberInfo['id']);
        if($power<2){
            $this->error('请先加入一个训练营并成为管理员或者创建训练营');
        }
        // $mediaList = $this->CourtMediaService->getCourtMediaList(['court_id'=>$court_id]);
		$this->assign('CourtInfo',$CourtInfo);
    	return view('Court/updateCourt');
    }

    public function createCourt(){
        $camp_id = input('param.camp_id');
        $CampService = new \app\service\CampService;
        $power = $CampService->isPower($camp_id,$this->memberInfo['id']);

        if($power<2){
            $this->error('请先加入一个训练营并成为管理员或者创建训练营');
        }

        $campInfo = $CampService->getCampInfo(['id'=>$camp_id]);
        $this->assign('campInfo',$campInfo);
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

    public function searchCourtList(){
        $camp_id = input('param.camp_id');
        $this->assign('camp_id',$camp_id);
        return view('Court/searchCourtList');
    }
}