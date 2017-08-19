<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\LessonService;
use app\service\GradeService;
class Lesson extends Base{
	protected $LessonService;
	protected $GradeService;
	public function _initialize(){
		$this->LessonService = new LessonService;
		$this->GradeService = new GradeService;
		parent::_initialize();
	}

    public function index() {
    	
        $a = ['10','20','30'];
        dump(serialize($a));
    }

    public function lessonInfo(){
    	$lesson_id = input('param.lesson_id');
    	$lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
     
        $lessonInfo['doms'] =  unserialize($lessonInfo['dom']);
        unset($lessonInfo['dom']);
        $this->assign('lessonInfoJson',json_encode($lessonInfo));
    	$this->assign('lessonInfo',$lessonInfo);
    	return view();
    }

    // 课程列表
    public function lessonList(){
    	$map = input();
    	$map = $map?$map:[];
    	$result = $this->LessonService->getLessonPage($map,10);
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
    //编辑课程
    public function updateLesson(){
    	//训练营主教练
    	$camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $lessonInfo = $this->LessonService->getLessonInfo(['id'=>$lesson_id]);
        $lessonInfo['doms'] = unserialize($lessonInfo['dom']);

    	$coachList = db('grade_member')->where(['type'=>4,'camp_id'=>$camp_id,'status'=>1])->select();
    	$assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
    	$gradeCategoryList = $this->GradeService->getGradeCategory(1);
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['status'=>$camp_id]);
        $this->assign('lessonInfo',$lessonInfo);
    	$this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
    	$this->assign('coachList',$coachList);
    	$this->assign('assitantList',$assitantList);
    	return view();
    }

    // 添加课程
    public function createLesson(){
        //训练营主教练
        $camp_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $coachList = db('grade_member')->where(['type'=>4,'camp_id'=>$camp_id,'status'=>1])->select();
        $assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
        $gradeCategoryList = $this->GradeService->getGradeCategory(1);
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['status'=>$camp_id]);
        // dump($assitantList);die;
        $this->assign('gradeCategoryList',$gradeCategoryList);
        $this->assign('courtList',$courtList);
        $this->assign('coachList',$coachList);
        $this->assign('assitantList',$assitantList);
        return view();
    }

    //编辑|添加课程接口
    public function updateLessonApi(){
    	$id = input('param.id');
    	$data = input('post.');
    	if($id){
    		$result = $this->LessonService->updateLesson($data,$id);
    	}else{
    		$result = $this->LessonService->pubLesson($data);
    	}

    	return json($result);die;
    	
    }

    // 购买课程
    public function buyLesson(){
        $studentInfo = db('student')->where(['member_id'=>$this->memberInfo['id']])->select();        
        $this->assign('studentInfo',$studentInfo); 
    	return view();
    }

    //课程订单支付
    public function comfirmBill(){
    // 生成订单号
    $billOrder = '1'.date('YmrHis',time()).rand(0000,9999);
    // 生成微信参数

    $this->assign('billOrder',$billOrder);
    return view();
    }

    public function bookBill(){
        // 生成订单号
        $billOrder = '1'.date('YmrHis',time()).rand(0000,9999);
        // 生成微信参数

        $this->assign('billOrder',$billOrder);
        return view();
    }
    // 邀请体验课程
    public function inviteStudent(){
        
        return view();
    }

    public function campLessonInfo(){
        $id = input('id');
        $result = $this->LessonService->getLessonOne(['id'=>$id]);
        $lessonInfo = [];
        if($result['code']==100){
            $lessonInfo = $result['data'];
        }
        $this->assign('lessonInfoJson',json_encode($lessonInfo));
        $this->assign('lessonInfo',$lessonInfo);
        return view();
    }
}