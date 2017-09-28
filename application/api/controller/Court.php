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
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != '' && $keyword!=NULL){
                $map['court'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $campList = $this->CourtService->getCourtList($map,$page);
            return json(['code'=>200,'msg'=>'OK','data'=>$campList]);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    // 分页获取数据
    public function getCourtListApi(){
        try{
            $camp_id = input('param.camp_id')?input('param.camp_id'):0;
            $map = input('post.');
            $map['camp_id'] = $camp_id;
            $map['status'] = 1;
            // $where = ['camp_id'=>['or',[0,$camp_id]]];
            // if($camp_id){
            //     $map = function($query) use ($condition,$camp_id){
            //         $query->where($condition)->where(['delete_time'=>null])->where(['camp_id'=>0])->whereOr(['camp_id'=>$camp_id]);
            //     };
            // }else{
            //     $map = $condition;
            // }

            $result = $this->CourtService->getCourtList($map);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
    

    //获取训练营下的场地列表
    public function getCourtListOfCampApi(){
        $map = input('post.');
        $result = $this->CourtService->getCourtListOfCamp($map);
        if($result){
            return json(['code'=>200,'msg'=>"OK",'data'=>$result]);
        }else{
            // 不知道为什么判断成功失败都写一样
            // return json(['code'=>200,'msg'=>"OK",'data'=>$result]);
            return json(['code'=>100,'msg'=>__lang('MSG_401')]);
        }
    }

    public function updateCourtApi(){
        try{
            $data = input('post.');
            $court_id = input('param.court_id');
            $camp_id = input('param.camp_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            // 权限
            $CampService = new \app\service\CampService;
            $power = $CampService->isPower($camp_id,$this->memberInfo['id']);
            if($power<2){
                return json(['code'=>100,'msg'=>__lang('MSG_403')]);
            }
            $result = $this->CourtService->updateCourt($data,$court_id);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function createCourtApi(){
        try{
            $data = input('post.');
            $camp_id = input('param.camp_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];

            // dump($data);die;
            // 权限
            $CampService = new \app\service\CampService;
            $power = $CampService->isPower($camp_id,$this->memberInfo['id']);
            if($power<2){
                return json(['code'=>100,'msg'=>__lang('MSG_403')]);
            }
            $result = $this->CourtService->createCourt($data);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

     // 把场地添加到自己的库
    public function ownCourtApi(){
        try{
            $court_id = input('param.court_id');
            $camp_id = input('param.camp_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->CourtService->ownCourt($court_id,$camp_id);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}