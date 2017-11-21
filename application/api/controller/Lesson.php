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
            $map['isprivate'] = input('param.isprivate', 0);
            $result = $this->LessonService->getLessonList($map,$page);
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
            if($lesson_id){
                $lesson = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
                $hasgradeused = $this->LessonService->hasgradeused($lesson_id);
                if ($hasgradeused) {
                    if ($data['cost'] != $lesson['cost']) {
                        $result = ['code' => 100, 'msg' => '此课程被班级所用，不能修改课程单价'];
                        return json($result);
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
                            return json(['code' => 100,'msg' => '该课程有班级所使用，不能操作']);
                        }
                        $response = $this->LessonService->updateLessonField($lesson['id'], "status", -1);
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
            $result = $this->LessonService->getLessonList($map,1,'hot desc',4);
            if($result){
                shuffle($result);
                if( count($result)<4 ){
                    $res = $this->LessonService->getLessonList(['status'=>1],1,'id desc',(4-count($result)));
                    $result = array_merge($result,$res);
                }
                
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'传参错误']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}