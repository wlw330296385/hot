<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GradeService;
use app\service\GradeMemberService;
class Grade extends Frontend{

    protected $GradeService;

    public function _initialize(){
        parent::_initialize();
        $this->GradeService = new GradeService;
    }

    public function index() {

        
    }


    public function createGradeApi(){
        try{
            $data = input('post.');
            $gradeData['member_id'] = $this->memberInfo['id'];
            $gradeData['member'] = $this->memberInfo['member'];
            $GradeService = new GradeService;
            $result = $GradeService->createGrade($data);
            return json($result);
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
            $gradeData['member_id'] = $this->memberInfo['id'];
            $gradeData['member'] = $this->memberInfo['member'];
            $GradeService = new GradeService;
            $result = $GradeService->updateGrade($data,$grade_id);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }



    // 班级学生变动
    public function updateGradeMemberApi(){
         try{
            $data = input('post.');
            $id = input('param.id');
            $StudentService = new \app\service\StudentService;
            $res = $StudentService->updateGradeMember($data,$id);
            return json($result); 
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }
}