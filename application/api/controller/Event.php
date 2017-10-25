<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampService;
use app\service\EventService;
use app\service\GradeService;
use think\Exception;

class Event extends Base{
	protected $EventService;
	protected $GradeService;
	public function _initialize(){
		$this->EventService = new EventService;
		$this->GradeService = new GradeService;
		parent::_initialize();
	}

    public function index() {
    	
       
    }

    // 搜索活动
    public function searchEventApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $camp_id = input('param.camp_id');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['Event'] = ['LIKE','%'.$keyword.'%'];
            }
            if($camp_id){
                $map['camp_id'] = $camp_id;
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $result = $this->EventService->getEventList($map,$page);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    // 搜索活动
    public function getEventListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $order = input('param.order','id desc');
            if( isset($map['order']) ){
                unset($map['order']);
            }
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }

            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['Event'] = ['LIKE','%'.$keyword.'%'];
            }
            $result = $this->EventService->getEventListByPage($map,$order);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }
    
    //翻页获取活动接口
    public function getEventListApi(){
        try{
            $map = input('post.');
            $page = input('param.page', 1);
            $order = input('param.order','id desc');
            if( isset($map['order']) ){
                unset($map['order']);
            }
            $result =  $this->getEventList($map, $page,$order);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
		    	
    }

    //编辑|添加活动接口
    public function updateEventApi(){
        try{
            $event_id = input('param.event_id');
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            if($data['address']){
                $address = explode(' ', $data['address']);
                $data['province'] = $address[0];
                $data['city'] = $address[1];
                if($address[2]){
                    $data['area'] = $address[2];
                }else{
                    $data['area'] = $address[1];
                }             
            }
            if($event_id){
                $result = $this->EventService->updateEvent($data,$event_id);
                
            }else{
                $result = $this->EventService->createEvent($data);
            }

            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    	
    }

    


    // 审核活动
    public function checkEventApi(){
        try{
            $camp_id = input('param.camp_id');
            if(!$camp_id){
                return json(['code'=>100,'msg'=>'camp_id未传参']);
            }
            $isPower = $this->EventService->isPower($camp_id,$memberInfo['id']);

            if($isPower<3){
                $event_id = input('post.event_id');
                $status = input('post.status');
                $result = db('Event')->save(['status'=>$status],$event_id);
                if($result){
                    return json(['code'=>200,'msg'=>__lang('MSG_200')]);
                }else{
                    return json(['code'=>100,'msg'=>__lang('MSG_400')]);
                }
                
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_403')]);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 录入活动
    public function recordEventApi(){
        try{
            $event_id = input('param.event_id');
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            if($data['address']){
                $address = explode(' ', $data['address']);
                $data['province'] = $address[0];
                $data['city'] = $address[1];
                if($address[2]){
                    $data['area'] = $address[2];
                }else{
                    $data['area'] = $address[1];
                }             
            }
            $result = $this->EventService->updateEvent($data,$event_id);
            if($result['code'] == 200){
                if($data['memberData']){
                    $memberData = json_decode($data['memberData'],true);
                    $res = $this->EventService->saveAllMmeber($memberData,$event_id,$data['event']);
                    return json($res);
                }
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}