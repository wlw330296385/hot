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

        
    }


    public function createGradeApi(){
        try{
            $data = input('post.');
            $studentList = $data['student_list'];
            $gradeData = $data['gradeData'];
            $gradeData['member_id'] = $this->memberInfo['id'];
            $gradeData['member'] = $this->memberInfo['member'];
            $GradeService = new GradeService;
            $result = $GradeService->createGrade($gradeData);
            if($result['code']==200){
                return json($result);die;
            } 
             // 获取上课学员
            foreach ($studentList as $key => $value) {
                
            }
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }

    	
    }


    public function getGradeListApi(){
        try{
            $member_id = $this->memberInfo['id'];
            $camp_id = input('get.camp_id');
            $map = input('post.');
            $map1 = $map;
            $map1['coach_id']=$member_id;
            $myGradeList = $this->GradeService->getGradeList($map);
            $gradeList = $this->GradeService->getGradeList($map1);
            $myGradeCount = count($myGradeList);
            $gradeListCount = count($gradeList);
            return json(['code'=>100,'msg'=>'ok','data'=>['myGradeCount'=>$myGradeCount,'gradeList'=>$gradeList,'gradeListCount'=>$gradeListCount]]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }
}