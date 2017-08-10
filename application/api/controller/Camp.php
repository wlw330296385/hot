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


    public function updateCampApi(){
        try{
            $data = input('post.');
            $id = input('get.camp_id');
            $result = $this->CampService->updateCamp($data,$id);
            return json($result);
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }  
    }

    public function createCampApi(){
        try{
            $data = input('post.');
            $result = $this->CampService->createCamp($data);
            return json($result);
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    } 


    public function isCreateCampApi(){
        try{ 
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $result = $this->CampService->isCreateCamp($member_id);
            if($result){
                return json(['code'=>200,'msg'=>'已有训练营','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'没有训练营','data'=>'']);
            }
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    } 
}
