<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CourtService;
class Court extends Base{
	protected $CourtService;

	public function _initialize(){
		parent::_initialize();
		$this->CourtService = new CourtService;
	}

    // 分页获取数据
    public function courtListApi(){
        try{
            $camp_id = input('get.camp_id');
            $condition = input('post.');
            $where = ['status'=>['or',[1,$camp_id]]];
            $map = array_merge($condition,$where);
            $courtList = $this->CourtService->getCourtPage($map,10);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updateCourtApi(){
        try{
            $data = input('post.');
            $id = input('get.id');
            $result = $this->CourtService->updateCourt($data,$id);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function createCourtApi(){
        try{
            $data = input('post.');
            $result = $this->CourtService->createCourt($data);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}