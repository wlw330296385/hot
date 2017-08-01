<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\LessonService;
class Lesson extends Base{
	protected $LessonService;
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {
    	
        return view();
    }

    public function lessonInfo(){
    	$id = input('id');
    	$result = $this->LessonService->getLessonOne(['id'=>$id]);
    	$lessonInfo = [];
    	if($result['code']==100){
    		$lessonInfo = $result['data'];
    	}
    	$this->assign('lessonInfo',$lessonInfo);
    	return view();
    }

    // 获取课程
    public function lessonList(){
    	$map = input('post.');
    	$result = $LessonService->getLessonPage($map,10);
    	if($result['code'] == 100){
			$list = $result['data'];
	    	//在线课程
	    	$dateNow = date('Y-m-d',time());
	    	$onlineList = [];

	    	//离线课程
	    	$offlineList = [];
			foreach ($list as $key => $value) {
				if($value['end']<$dateNow || $value['start']>$dateNow){
					$offlineList[] = $value;
				}else{
					$onlineList[] = $value;
				}
				
			}
	    		 	
    	}else{
    		$list = []; 
    	}
    	
  		$this->assign('onlineList',$onlineList);
  		$this->assign('offlineList',$offlineList);
		return view();
    }

    //翻页获取课程接口
    public function getLessonListApi(){
    	$type = input('get.type');
    	$map = input('post.');
    	$result = $LessonService->getLessonPage($map,10);
    	if($result['code'] == 100){
			$list = $result['data'];
	    	//在线课程
	    	$dateNow = date('Y-m-d',time());
	    	$onlineList = [];

	    	//离线课程
	    	$offlineList = [];
			foreach ($list as $key => $value) {
				if($value['end']<$dateNow || $value['start']>$dateNow){
					$offlineList[] = $value;
				}else{
					$onlineList[] = $value;
				}
				
			}
	    		 	
    	}else{
    		return json(['code'=>'200','msg'=>$result['msg']]);die;
    	}
    	switch ($type) {
    		case '1':
    			return json(['code'=>100,'msg'=>'success','data'=>$onlineList]);die;
    			break;
    		case '2':
    			return json(['code'=>100,'msg'=>'success','data'=>$onlineList]);die;
    			break;
    		default:
    			return json(['code'=>200,'msg'=>'???']);die;
    			break;
    	}   		    	
    }
    //编辑|添加课程
    public function updateLesson(){
    	//训练营主教练
    	$camp_id = input('get.camp_id');
    	$coachList = db('grade_member')->where(['type'=>4,'camp_id'=>$camp_id,'status'=>1])->select();
    	$assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
    	$this->assign('coachList',$coachList);
    	$this->assign('assitantList',$assitantList);
    	return view();
    }
    //编辑|添加课程接口
    public function updateLessonApi(){
    	$id = input('get.id');
    	$data = input('post.');
    	if($id){
    		$result = $this->LessonService->updateLesson($data,$id);
    	}else{
    		$result = $this->LessonService->pubLesson($data);
    	}

    	return json($result);die;
    	
    }

}