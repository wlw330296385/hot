<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CourtService;
use think\Db;
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
            $result = $this->CourtService->getCourtList($map,$page);
             if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    // 分页获取数据
    public function getCourtListNoPageApi(){
        try{
            $camp_id = input('param.camp_id')?input('param.camp_id'):0;

//            $result = db('court_camp')->where(['camp_id'=>$camp_id])->select();
            $result = Db::view('court_camp', ['id', 'court_id', 'court', 'camp_id', 'camp'])
                ->view('court', ['id' => 'courtid', 'location'], 'court.id=court_camp.court_id')
                ->where(['camp_id' => $camp_id])
                ->select();
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
    // 分页获取数据（带分页、有页码）
    public function getCourtListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
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
            $result = $this->CourtService->getCourtListbyPage($map);
             if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //获取训练营下的场地列表（带分页）
    public function getCourtListOfCampApi(){
        $map = input('post.');
        $page = input('param.page', 1);
        $result = $this->CourtService->getCourtListOfCamp($map, $page);
        if($result){
            return json(['code'=>200,'msg'=>"OK",'data'=>$result]);
        }else{
            // 不知道为什么判断成功失败都写一样
            // return json(['code'=>200,'msg'=>"OK",'data'=>$result]);
            return json(['code'=>100,'msg'=>__lang('MSG_401')]);
        }
    }

    //获取训练营下的场地列表（有分页页码）
    public function getCourtListOfCampPageApi(){
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

    // 场地上下架/删除 2017/9/28
    public function removecourt() {
        try {
            $courtcampid = input('param.courtcampid');
            $campid = input('param.campid');
            $action = input('param.action');
            if (!$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }

            $camppower = getCampPower($campid, $this->memberInfo['id']);
            if ($camppower < 3) { //管理员以上可操作
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }

            // 删除场地-训练营关联关系
            $courtS = new CourtService();
            $result = $courtS->delCourtCamp($courtcampid);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}