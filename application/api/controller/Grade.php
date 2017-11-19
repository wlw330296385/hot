<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GradeService;
use app\service\GradeMemberService;
class Grade extends Base{

    protected $GradeService;

    public function _initialize(){
        parent::_initialize();
        $this->GradeService = new GradeService;
    }

    public function index() {

        dump($this->memberInfo);
    }


    public function createGradeApi(){
        try{
            $data = input('post.');
            $studentList = $data['studentList'];
            $gradeData = $data['gradeData'];
            $gradeData['member_id'] = $this->memberInfo['id'];
            $gradeData['member'] = $this->memberInfo['member'];
            if($gradeData['assistants']){
                $assistan_list = explode(',', $gradeData['assistants']);
                $seria = serialize($assistan_list);
                $gradeData['assistant'] = $seria;
            }
            $GradeService = new GradeService;
            $result = $GradeService->createGrade($gradeData);
            if($result['code']==100){
                $grade_id = $result['data'];
                //重组上课学员
                foreach ($studentList as $key => $value) {
                    $studentList[$key]['grade_id'] = $grade_id;
                    $studentList[$key]['grade'] = $gradeData['grade'];
                }
                $StudentService = new \app\service\StudentService;
                $res = $StudentService->saveAllStudent($studentList);
                return json($res);
            }else{
                return json($result);
            } 
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }

    	
    }


    public function getGradeListApi(){
        try{
            $member_id = $this->memberInfo['id'];
            $camp_id = input('param.camp_id');
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $map1['coach_id']=$member_id;
            $myGradeList = $this->GradeService->getGradeList($map,$page);
            $gradeList = $this->GradeService->getGradeList($map,$page);
            $myGradeCount = count($myGradeList);
            $gradeListCount = count($gradeList);
            return json(['code'=>100,'msg'=>'ok','data'=>['myGradeCount'=>$myGradeCount,'gradeList'=>$gradeList,'gradeListCount'=>$gradeListCount]]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }



    public function updateGradeApi(){
        try{
            $grade_id = input('param.grade_id');
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            if($data['assistants']){
                $assistan_list = explode(',', $data['assistants']);
                $seria = serialize($assistan_list);
                $data['assistant'] = $seria;
            }
            $GradeService = new GradeService;
            $result = $GradeService->updateGrade($data,$grade_id);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }



    // 一个班级学生名单变动
    public function updateGradeMemberApi(){
         try{
            $data = input('post.');
            $id = input('param.id');
            $StudentService = new \app\service\StudentService;
            $result = $StudentService->updateGradeMember($data,$id);
            return json($result); 
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    // 批量班级学生名单变动
    public function updateGradeMemberAllApi(){
         try{
            $data = input('post.');
            $StudentService = new \app\service\StudentService;
            $result = $StudentService->saveAllStudent($data);
            return json($result); 
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }


}