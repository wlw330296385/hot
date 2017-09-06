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
            $type = input('param.type');
            $map = input('post.');
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
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
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

    // 获取已经被分配的学生
    public function getActiveLessonStudentsApi(){
        try{
            $lesson_id = input('lesson_id');
            $students = db('grade_member')->where(['lesson_id'=>$lesson_id,'type'=>1,'status'=>1])->where('grade_id','neq','')->field('student,id')->select();
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取毕业学生
    public function getEduatedStudentsApi(){
        try{
            $lesson_id = input('lesson_id');
            $students = db('grade_member')->where(['lesson_id'=>$lesson_id,'type'=>1,'status'=>4])->field('student,id')->select();
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取没有被分配班级的学生
    public function getInactiveStudentsApi(){
        try{
            $lesson_id = input('lesson_id');
            $students = db('grade_member')->where(['lesson_id'=>$lesson_id,'type'=>1,'status'=>1])->where('grade_id','eq','')->field('student,id')->select();
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    
}