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
            if($result['code']==200){
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
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    	
    }


    public function getGradeListApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != '' && $keyword!=NULL){
                $map['court'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $result = $this->GradeService->getGradeList($map,$page);
            return json(['code'=>200,'msg'=>'ok','data'=>$result]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getGradeListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != '' && $keyword!=NULL){
                $map['court'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $result = $this->GradeService->getGradeListByPage($map);
            return json(['code'=>200,'msg'=>'ok','data'=>$result]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
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
            return json(['code'=>100,'msg'=>$e->getMessage()]);
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
            return json(['code'=>100,'msg'=>$e->getMessage()]);
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
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


}