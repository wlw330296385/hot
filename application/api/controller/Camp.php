<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampService;
class Camp extends Base{
    protected $CampService;
	public function _initialize(){
		parent::_initialize();
	}


    public function searchCampApi(){
        try{
            $keyword = input('keyword');
            $province = input('province');
            $city = input('city');
            $area = input('area');
            $map = ['province'=>$province,'city'=>$city,'area'=>$area];
            foreach ($map as $key => $value) {
                if($value == ''){
                    unset($map[$key])
                }
            }
            if($keyword){
                $map['camp'] = ['LIKE',$keyword];
            }
            $campList = $this->CampService->getCampList($map);
            return json(['code'=>100,'msg'=>'OK','data'=>$campList]);
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }       
    }

    public function getCampListApi(){
        try{
            $map = input('post.');
            $campList = $this->CampService->getCampList($map);

            return json(['code'=>100,'msg'=>'OK','data'=>$campList]);

        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }  
    }
}
