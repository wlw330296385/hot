<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampService;
use app\service\LessonService;
use app\service\GradeService;
use think\Exception;

class Lesson extends Base{
	protected $LessonService;
	protected $GradeService;
	public function _initialize(){
		$this->LessonService = new LessonService;
		$this->GradeService = new GradeService;
		parent::_initialize();
	}

    public function index() {
    	
       
    }

    // 搜索课程
    public function searchLessonApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $camp_id = input('param.camp_id');
            $gradecate_id = input('param.gradecate_id');
            $hot = input('param.hot');
            $order = 'id desc';
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            $lat = input('param.lat',22.52369);
            $lng = input('param.lng',114.0261);
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['lesson'] = ['LIKE','%'.$keyword.'%'];
            }
            if($camp_id){
                $map['camp_id'] = $camp_id;
            }
            if ($hot) {
                $map['hot'] = 1;
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $map['isprivate'] = input('param.isprivate', 0);
            $result = $this->LessonService->getLessonList($map,$page,$order,10,"*,round(6378.138)*2*asin (sqrt(pow(sin(($lat *pi()/180 - lat*pi()/180)/2), 2)+cos($lat *pi()/180)*cos(lat*pi()/180)*pow(sin(($lng *pi()/180 - lng*pi()/180)/2),2))) as distance");
            if($result){
                $res = $result->toArray();
                shuffle($res);
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    // 搜索课程
    public function getLessonListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $city = input('param.city');
            $area = input('param.area');
            $camp_id = input('param.camp_id');
            $gradecate_id = input('param.gradecate_id');
            $hot = input('param.hot');
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
                $map['lesson'] = ['LIKE','%'.$keyword.'%'];
            }
            if($camp_id){
                $map['camp_id'] = $camp_id;
            }
            if ($hot) {
                $map['hot'] = 1;
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $result = $this->LessonService->getLessonListByPage($map);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    // 搜索课程
    public function getLessonListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $city = input('param.city');
            $area = input('param.area');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            $hot = input('param.hot');

            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['lesson'] = ['LIKE','%'.$keyword.'%'];
            }
            if ($hot) {
                $map['hot'] = ['eq',$hot];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->LessonService->getLessonListNoPage($map);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'没有课程数据']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }
    
    //翻页获取课程接口
    public function getLessonListApi(){
        
        try{
            $map = input('post.');
            $page = input('param.page', 1);
            $result =  $this->LessonService->getLessonList($map, $page);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
		    	
    }

    //编辑|添加课程接口
    public function updateLessonApi(){
        try{
            $lesson_id = input('param.lesson_id');
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
            if ($data['isprivate']==1 && $data['memberData'] == "[]") {
                return json(['code' => 100, 'msg' => '私密课程必须选择想要发送私密课程的会员']);
            }
            // 封面图 base64转存
            $data['cover'] = base64_image_content($data['cover'], 'lesson');
            if($lesson_id){
                
                if($data['cost']<>$lessonInfo['cost']){
                    $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
                    $campInfo = db('camp')->where(['id'=>$lessonInfo['camp_id']])->find();
                    if($campInfo['rebate_type'] ==1){
                        //课时版有购买记录或者赠课记录不允许改价
                        if($lesson['resi_giftschedule']>0){
                            return json(['code' => 100, 'msg' => '还剩余未赠送的赠课,不允许修改课程单价']);
                        }
                        $is_bill = db('bill')->where(['goods_type'=>1,'goods_id'=>$lesson_id,'status'=>['lt',0]])->find();
                        if($is_bill){
                            return json(['code' => 100, 'msg' => '已有订单不允许修改课程单价']);
                        }
                    }    
                }
                                

                $result = $this->LessonService->updateLesson($data,$lesson_id);
                if ($result['code'] == 200 && $data['isprivate'] == 1) {
                    $dataLessonAssign['lesson_id'] = $lesson_id;
                    $dataLessonAssign['lesson'] = $data['lesson'];
                    $dataLessonAssign['memberData'] = $data['memberData'];
                    $resultSaveLessonAssign = $this->LessonService->saveLessonAssign($dataLessonAssign);
                    if (!$resultSaveLessonAssign) {
                        return json(['code' => 100, 'msg' => '选择指定会员'.__lang('MSG_400')]);
                    }
                }
            }else{
                $result = $this->LessonService->createLesson($data);
  
                if ($result['code'] == 200 && $data['isprivate'] == 1) {

                    $dataLessonAssign['lesson_id'] = $result['data'];
                    $dataLessonAssign['lesson'] = $data['lesson'];
                    $dataLessonAssign['memberData'] = $data['memberData'];
                    $resultSaveLessonAssign = $this->LessonService->saveLessonAssign($dataLessonAssign);
                    if (!$resultSaveLessonAssign) {
                        return json(['code' => 100, 'msg' => '选择指定会员'.__lang('MSG_400')]);
                    }
                }
            }
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    }

    // 获取购买了课程的没毕业的学生
    public function getStudentListOfLessonApi(){
        try{
            $lesson_id = input('param.lesson_id');
            $map = input('post');
            $map['lesson_id'] = $lesson_id;
            $map['status'] = 1;
            $studentList = db('lesson_member')->where($map)->select();
            return json(['code'=>200,'msg'=>__lang('MSG_201'),'data'=>$studentList]);
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 审核课程
    public function checkLessonApi(){
        try{
            $camp_id = input('param.camp_id');
            if(!$camp_id){
                return json(['code'=>100,'msg'=>'camp_id未传参']);
            }
            $isPower = $this->LessonService->isPower($camp_id,$memberInfo['id']);

            if($isPower<3){
                $lesson_id = input('post.lesson_id');
                $status = input('post.status');
                $result = db('lesson')->save(['status'=>$status],$lesson_id);
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

    // 课程上下架/删除 2017/09/27
    public function removelesson() {
        try {
            $lessonid = input('param.lessonid');
            $action = input('param.action');
            if (!$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }


            $this->LessonService = new LessonService();
            $lesson = $this->LessonService->getLessonInfo(['id' => $lessonid]);
            if (!$lesson) {
                return json(['code' => 100, 'msg' => '没有此课程']);
            }
            $camppower = getCampPower($lesson['camp_id'], $this->memberInfo['id']);
            if ($camppower < 1) { //教练以上可操作
                return json([ 'code' => 100, 'msg' => __lang('MSG_403') ]);
            }

            // 教练身份 只能操作自己创建的课程
            if ($camppower==2) {
                if($lesson['member_id'] != $this->memberInfo['id']) {
                    return json([ 'code' => 100, 'msg' => __lang('MSG_403').',只能操作自己发布的课程' ]);
                }
            }
            $campS = new CampService();
            switch ($lesson['status_num']) {
                case "1": {
                    // 上架课程可操作:下架/设为私密
                    if ($action == 'editstatus') {
                        // 下架课程
                        $hasgradeused = $this->LessonService->hasgradeused($lesson['id']);
                        if ($hasgradeused) {
                            return json(['code' => 100,'msg' => '该课程还有没上完课的班级,不可下架,请先设置班级为预排并删除班级']);
                        }
                        $response = $this->LessonService->updateLessonField($lesson['id'], "status", -1);
                        if($response['code'] == 200){
                            // 校园课程把学生全部设置为毕业
                            if($lesson['is_school'] == 1){
                                db('lesson_member')->where(['lesson_id'=>$lesson['id']])->update(['status'=>4]);
                            }
                        }
                        return json($response);
                    } else {
                        //$response = $this->LessonService->updateLessonField($lesson['id'], "isprivate", )
                        // 根据课程当前私密课程字段内容更新字段内容
                        if ($lesson['isprivate'] == 1) {
                            $response = $this->LessonService->updateLessonField($lesson['id'], "isprivate", 0);
                        } else {
                            $response = $this->LessonService->updateLessonField($lesson['id'], "isprivate", 1);
                        }
                        return json($response);
                    }
                    break;
                }
                case "-1": {
                    // 下架课程可操作:上架/删除
                    if ($action == 'editstatus') {
                        // 上架课程
                        $campstatus = $campS->getCampcheck($lesson['camp_id']);
                        if (!$campstatus) {
                            return json(['code' => 100, 'msg' => '训练营尚未审核，课程不能上架']);
                        }

                        $response = $this->LessonService->updateLessonField($lesson['id'], "status", 1);
                        return json($response);
                    } else {
                        $response = $this->LessonService->SoftDeleteLesson($lesson['id']);
                        return json($response);
                    }
                    break;
                }
            }
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    public function getHotLessonListApi(){
        try{
            $map = input('post.');
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            $result = $this->LessonService->getLessonList($map,1,['hot'=>'asc','students'=>'asc'],4);
            
            if($result){
                $res = $result->toArray();
                shuffle($res);
                if( count($result)<4 && !isset($map['camp_id']) ){
                    $res = $this->LessonService->getLessonList(['status'=>1,'isprivate'=>0],1,['hot'=>'asc','students'=>'asc'],(4-count($result)));
                    
                    $result = array_merge($result,$res);
                }
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'获取成功','data'=>$result]);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 2017-11-22 会员是否能购买课程
    public function canbuylesson() {
        try {
            // 获取lesson id 查询课程数据是否为私密课程
            $lesson_id = input('param.lesson_id');
            if (!$lesson_id) {
                return json(['code' => 100, 'msg' => '购买课程'.__lang('MSG_402')]);
            }
            $lessonS = new LessonService();
            $lesson = $lessonS->getLessonInfo(['id' => $lesson_id]);
            if (!$lesson) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            if ($lesson['status_num'] == -1) {
                return json(['code' => 100, 'msg' => '此课程已下架，不能购买']);
            }
            // 非私密课程 可直接购买
            if ($lesson['isprivate'] != 1) {
                return json(['code' => 200, 'msg' => __lang('MSG_201'.',可购买此课程')]);
            }
            //dump($lesson);
            // 私密课程 判断当前会员是否在可购买名单
            $inAssign = $lessonS->isInAssignMember($lesson['id'], $this->memberInfo['id']);
            // 不在名单中 提示不可购买
            if (!$inAssign) {
                $response = ['code' => 100, 'msg' => __lang('您不能购买此课程，请联系咨询教练或训练营')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201').',可购买此私密课程'];
            }
            return json($response);
        } catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 预约体验课
    public function bookLessonApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['type'] =2;
            $data['rest_schedule']=0;
            $data['status'] = 1;
            $result = $this->LessonService->bookLesson($data);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}