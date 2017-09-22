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

    // 搜索课程
    public function searchLessonApi(){
        try{
            $map = [];
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $camp_id = input('param.camp_id');
            $gradecate_id = input('param.gradecate_id');
            $map = ['province'=>$province,'city'=>$city,'area'=>$area,'gradecate_id'=>$gradecate_id];
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['lesson'] = ['LIKE','%'.$keyword.'%'];
            }
            if($camp_id){
                $map['camp_id'] = $camp_id;
            }
            $lessonList = $this->LessonService->getLessonPage($map,$page);
            return json(['code'=>100,'msg'=>'OK','data'=>$lessonList]);
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }       
    }


    //翻页获取课程接口
    public function getLessonListApi(){
        
        try{
            // $type = input('param.type');
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $result = $this->LessonService->getLessonPage($map,$page);

            if($result){
                //在线课程
                // $dateNow = date('Y-m-d',time());
                // $onlineList = [];

                // //离线课程
                // $offlineList = [];
                // foreach ($result as $key => $value) {
                //     if($value['end']<$dateNow || $value['start']>$dateNow){
                //         $offlineList[] = $value;
                //     }else{
                //         $onlineList[] = $value;
                //     }
                    
                // }
                return json(['code'=>'100','msg'=>'获取成功','data'=>$result]);die;        
            }else{
                return json(['code'=>'200','msg'=>[]]);die;
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
            return json(['code'=>200,'msg'=>$e->getMessage()]);
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
            if($lesson_id){
                $result = $this->LessonService->updateLesson($data,$lesson_id);
            }else{
                $result = $this->LessonService->createLesson($data);
            }

            return json($result);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    	
    }

    // 获取购买了课程的学生
    public function getActiveLessonStudentsApi(){
        try{
            $lesson_id = input('param.lesson_id');
            $studentList = db('grade_member')->where(['lesson_id'=>$lesson_id,'type'=>1,'status'=>1])->where('grade_id','neq','')->field('student,id')->select();
            return json(['code'=>100,'msg'=>'获取成功','data'=>$studentList]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    // 获取毕业学生
    public function getEduatedStudentsApi(){
        try{
            $lesson_id = input('param.lesson_id');
            $studentList = db('grade_member')->where(['lesson_id'=>$lesson_id,'type'=>1,'status'=>4])->field('student,id')->select();
            return json(['code'=>100,'msg'=>'获取成功','data'=>$studentList]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    // 获取没有被分配班级的学生
    public function getInactiveStudentsApi(){
        try{
            $lesson_id = input('param.lesson_id');
            $studentList = db('grade_member')->where(['lesson_id'=>$lesson_id,'type'=>1,'status'=>1])->where('grade_id','neq','')->field('student,id')->select();
            return json(['code'=>100,'msg'=>'获取成功','data'=>$studentList]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }


    // 获取购买了课程的没毕业的学生
    public function getStudentListOfLessonApi(){
        try{
            $lesson_id = input('param.lesson_id');
            $map = input('post');
            $studentList = db('grade_member')->where(['lesson_id'=>$lesson_id,'status'=>1])->where($map)->where('grade_id','neq','')->field('student,id')->select();
            return json(['code'=>100,'msg'=>'获取成功','data'=>$studentList]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }


    // 审核课程
    public function checkLessonApi(){
        try{
            $camp_id = input('param.camp_id');
            if(!$camp_id){
                return json(['code'=>200,'msg'=>'camp_id未传参']);
            }
            $isPower = $this->LessonService->isPower($camp_id,$memberInfo['id']);

            if($isPower<3){
                $lesson_id = input('post.lesson_id');
                $status = input('post.status');
                $result = db('lesson')->save(['status'=>$status],$lesson_id);
                if($result){
                    return json(['code'=>100,'msg'=>'操作成功']);
                }else{
                    return json(['code'=>200,'msg'=>'操作失败']);
                }
                
            }else{
                return json(['code'=>200,'msg'=>'权限不足']);
            }
            
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }
    
}