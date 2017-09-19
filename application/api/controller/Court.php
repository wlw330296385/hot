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


    // 搜索场地
    public function searchCourtApi(){
        try{
            $map = [];
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $map = ['province'=>$province,'city'=>$city,'area'=>$area];
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value!=' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['court'] = ['LIKE','%'.$keyword.'%'];
            }
            $campList = $this->CampService->getCourtList($map,$page);
            return json(['code'=>100,'msg'=>'OK','data'=>$campList]);
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }       
    }

    // 分页获取数据
    public function courtListApi(){
        try{
            $camp_id = input('param.camp_id');
            $condition = input('post.');
            $where = ['camp_id'=>['or',[0,$camp_id]]];
            if($camp_id){
                $map = function($query) use ($condition,$camp_id){
                    $query->where($condition)->where(['delete_time'=>null])->where(['camp_id'=>0])->whereOr(['camp_id'=>$camp_id]);
                };
            }else{
                $map = $condition;
            }
            $page = input('param.page')?input('param.page'):1;
            $result = $this->CourtService->getCourtList($map,$page);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updateCourtApi(){
        try{
            $data = input('post.');
            $id = input('param.id');
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