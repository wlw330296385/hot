<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CourtService;
class Court extends Base{
	protected $CourtService;

	public function _initialize(){
		parent::_initialize();
		$this->CourtService = new CourtService;
	}

    public function index() {

        return view();
    }


    public function courtInfo(){
    	$id = input('id');
    	$result = $this->CourtService->getCourtOne(['id'=>$id]);
    	return view();
    }



    public function updateCourt(){   	
    	$id = input('id');
		$courtInfo = $this->CourtService->getCourtOne(['id'=>$id]);
		$this->assign('CourtInfo',$CourtInfo);
    	return view();
    }

    public function createCourt(){
        $pidList = $this->CourtService->getCourtAll(['pid'=>0]);

        $this->assign('pidList',$pidList['data']);
        return view();
    }
    // 分页获取数据
    public function courtListApi(){
    	$camp_id = input('get.camp_id');
        $condition = input('post.');
        $where = ['status'=>['or',[1,$camp_id]]];
        $map = array_merge($condition,$where);
    	$courtList = $this->CourtService->getCourtPage($map,10);
    	return json($result);
    }

}