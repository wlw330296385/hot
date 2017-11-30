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
            $order = input('param.order','id desc');
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
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['event'] = ['LIKE','%'.$keyword.'%'];
            }

            if( isset($map['order']) ){
                unset($map['order']);
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $result = $this->EventService->getEventList($map,$page,$order);
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
            if( isset($map['order']) ){
                unset($map['order']);
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['event'] = ['LIKE','%'.$keyword.'%'];
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
            $result =  $this->EventService->getEventList($map, $page,$order);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
		    	
    }

    //翻页获取班级活动接口
    public function getEventListOfGradeApi(){
        try{
            $map = input('post.');
            $page = input('param.page', 1);
            $order = input('param.order','id desc');
            if( isset($map['order']) ){
                unset($map['order']);
            }
            $map['target_type'] = 3;
            $member_id = $this->memberInfo['id'];
            $gradeIDS = db('grade_member')->where(['member_id'=>8,'status'=>1])->column('grade_id');
            $map['target_id'] = ['in',$gradeIDS];
            $result =  $this->EventService->getEventList($map, $page,$order);
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
                unset($data['address']);
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
                if($data['memberData'] && $data['memberData']!='[]'){
                    $memberData = json_decode($data['memberData'],true);
                    $res = $this->EventService->saveAllMmeber($memberData,$event_id,$data['event']);
                    return json($res);
                }
            }
            return $result;
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 参加活动
    public function joinEventApi(){
        try{
            $event_id = input('param.event_id');
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            $total = input('param.total');
            $data = input('post.');
            $res = $this->EventService->joinEvent($event_id,$member_id,$member,$total);
            if($res['code'] == 200){
                if( !empty($data['memberData']) && $data['memberData'] != '[]' ){
                    $memberData = json_decode($data['memberData'],true);
                    foreach ($memberData as $key => &$value) {
                        $value['contact'] = $data['contact'];
                        $value['linkman'] = $data['linkman'];
                        $value['remarks'] = $data['remarks'];
                    }
                    $result = $this->EventService->saveAllMmeber($memberData);
                    return json($result);
                }
            }else{
                return json($res);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 2017-11-21 活动操作状态/软删除
    public function removeevent() {
        try {
            // 接收参数，检查参数是否符合
            $event_id = input('param.eventid');
            $action = input('action');
            if (!$event_id || !$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 查询活动数据，不存在活动数据抛出提示
            $eventS = new EventService();
            $event= $eventS->getEventInfo(['id' => $event_id]);
            if (!$event) {
                return json(['code' => 100, 'msg' => '活动'.__lang('MSG_401')]);
            }
            // 判断可操作会员身份 教练及以上才能操作
            $power = getCampPower($event['organization_id'], $this->memberInfo['id']);
            if ($power < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }
            // 根据活动当前状态(1上架,2下架)+不允许操作条件
            // 根据action参数 editstatus执行上下架/del删除操作
            // 更新数据 返回结果
            switch ( $event['status_num'] ) {
                case 1 : {
                    if ($action == 'editstatus') {
                        $response = $eventS->updateEventStatus($event['id'], 2);
                    } else {
                        $response = $eventS->SoftDeleteEvent($event['id']);
                    }
                    return json($response);
                    break;
                }
                case 2 : {
                    if ($action == 'editstatus') {
                        $response = $eventS->updateEventStatus($event['id'], 1);
                    } else {
                        $response = $eventS->SoftDeleteEvent($event['id']);
                    }
                    return json($response);
                    break;
                }
            }
        } catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}