<?php 
namespace app\api\controller;
use app\api\controller\Base;
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
    	
       
    }



    //翻页获取课程接口
    public function getLessonListApi(){
        try{
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
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
		    	
    }

    //编辑|添加课程接口
    public function updateLessonApi(){
        try{
            $id = input('get.id');
            $data = input('post.');
            if($id){
                $result = $this->LessonService->updateLesson($data,$id);
            }else{
                $result = $this->LessonService->pubLesson($data);
            }

            return json($result);die;
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    	
    }


    

}