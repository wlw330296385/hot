<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CourtService;
use think\Db;
use think\Exception;

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

    // 分页获取lat,lng最近数据（带分页）
    public function getCourtListOrderByDistanceApi(){
        try{
            $lat = input('param.lat',22.52369);
            $lng = input('param.lng',114.0261);
            $page = input('param.page',1);
            $pe = $page*10;
            $ps = ($page-1)*10;
            $orderby = input('param.orderby','distance asc');
            $camp_id = input('param.camp_id');
            $map = ['status'=>1];
            if($camp_id){
                $map['camp_id'] = $camp_id;
            }
            
            // $result = Db::query('select *,round(6378.138)*2*asin (sqrt(pow(sin((? *pi()/180 - lat*pi()/180)/2), 2)+cos(? *pi()/180)*cos(lat*pi()/180)*pow(sin((? *pi()/180 - lng*pi()/180)/2),2))) as distance from court where status=1 order by ? limit ?,?',
            // [$lat,$lat,$lng,$orderby,$ps,$pe]
            // );
            $result = db('court')->field("`court`.*,round(6378.138)*2*asin (sqrt(pow(sin(($lat *pi()/180 - `court`.lat*pi()/180)/2), 2)+cos($lat *pi()/180)*cos(`court`.lat*pi()/180)*pow(sin(($lng *pi()/180 - `court`.lng*pi()/180)/2),2))) as distance")->where($map)->page($page)->order($orderby)->select();

            if($result){
                foreach ($result as $key => $value) {
                    if($value['cover']){
                        $result[$key]['covers'] = unserialize($value['cover']);
                    }
                    
                }
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'失败']);
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
            return json(['code'=>100,'msg'=>__lang('MSG_401')]);
        }
    }

    //获取训练营下的场地列表（有分页页码）
    public function getCourtListOfCampPageApi(){
        $result = $this->CourtService->getCourtListOfCamp($map);
        if($result){
            return json(['code'=>200,'msg'=>"OK",'data'=>$result]);
        }else{
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

    // 控制台修改场地
    public function adminupdatecourtapi() {
        try{
            if (!session('?admin')) {
                return json(['code'=>100,'msg'=>__lang('MSG_403')]);
            }
            $data = input('post.');
            $court_id = input('param.court_id');
            $data['member_id'] = session('admin.id');
            $data['member'] = session('admin.username');
            $data['system_remark'] = 'system:{'.session('admin.username').'}修改场地信息';
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


    // 获取courtcamp列表
    public function getCourtCampListOfPageApi(){
        try{
            $map = input('post.');
            $result = $this->CourtService->getCourtCampListByPage($map);
            if($result){
                return json(['code'=>200,'msg'=>'请求成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'请求成功','data'=>$result]);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取courtcamp记录(无page无分页)
    public function getCourtCampListNoPageApi(){
        try{
            $court_id = input('param.court_id');
            $status = input('param.status',1);
            $result = Db::view('court_camp','court_id,camp_id,status,id')
                    ->view('camp','logo,camp,banner','camp.id = court_camp.camp_id')
                    ->where(['court_camp.court_id'=>$court_id,'court_camp.status'=>$status])
                    ->select();
            if($result){
                return json(['code'=>200,'msg'=>'请求成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'请求成功','data'=>$result]);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}