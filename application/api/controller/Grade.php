<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GradeService;
use app\service\GradeMemberService;
use think\Exception;

class Grade extends Base{

    protected $GradeService;

    public function _initialize(){
        parent::_initialize();
        $this->GradeService = new GradeService;
    }

    public function index() {

        
    }


    


    public function getGradeListApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page', 1);
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
            $map['status'] = input('status',1);
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
            $GradeService = new GradeService;
            $result = $GradeService->updateGrade($data,$data['grade_id']);
            if($result['code']==200){
                if( !empty($data['studentData']) && $data['studentData'] != '[]' ){
                    $studentData = json_decode($data['studentData'],true);
                    $StudentService = new \app\service\StudentService;
                    $res = $StudentService->saveAllStudent($studentData);
                    return json($res);
                }
                
            }
            return json($result);
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function createGradeApi(){
        try{
            $data = input('post.');
            $GradeService = new GradeService;
            // 检查同训练营是否存在同名班级
            $hasgrade = $GradeService->getGradeInfo(['grade' => $data['grade'],'camp_id' => $data['camp_id']]);
            if ($hasgrade) {
                return json(['code' => 100, 'msg' => '训练营已存在同名班级,请填写其他班级名称']);
            }

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
            $result = $GradeService->createGrade($data);
            if($result['code']==200){
                $grade_id = $result['data'];
               if(!empty($data['studentData']) && $data['studentData'] != '[]'){
                    $studentData = json_decode($data['studentData'],true);
                    $StudentService = new \app\service\StudentService;
                    foreach ($studentData as $key => $value) {
                       $studentData[$key]['grade'] = $data['grade'];
                       $studentData[$key]['grade_id'] = $grade_id;
                    }
                    $res = $StudentService->saveAllStudent($studentData);
                    return json($res);
                }
            }else{
                return json($result);
            }
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

    // 操作班级 当前/预排/删除 2017/10/2
    public function removegrade() {
        try {
            $gradeid = input('gradeid');
            $action = input('action');
            if (!$gradeid || !$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }

            $gradeS = new GradeService();
            $grade = $gradeS->getGradeInfo(['id' => $gradeid]);
            if (!$grade) {
                return json(['code' => 100, 'msg' => __lang('MSG_401')]);
            }

            $power = getCampPower($grade['camp_id'], $this->memberInfo['id']);
            if ($power < 2) { //教练以上才能操作
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }

            switch ( $grade['status_num'] ) {
                case "1" : {
                    // 操作当前班级
                    if ($action == 'editstatus') {
                        $res = $gradeS->updateGradeStatus($grade['id'], -1);
                        if ($res) {
                            $response = json(['code' => 200, 'msg' => __lang('MSG_200')]);
                        } else {
                            $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
                        }
                    } else {
                        // 当前班级不能删除
                        $response = json(['code' => 100, 'msg' => '当前班级不能删除,请先下架班级']);
                    }
                    return $response;
                    break;
                }
                case "-1": {
                    // 操作预排班级
                    if ($action == 'editstatus') {
                        $res = $gradeS->updateGradeStatus($grade['id'], 1);
                        if ($res) {
                            $response = json(['code' => 200, 'msg' => __lang('MSG_200')]);
                        } else {
                            $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
                        }
                    } else {
                        $res = $gradeS->delGrade($grade['id']);
                        if ($res) {
                            $response = json(['code' => 200, 'msg' => __lang('MSG_200')]);
                        } else {
                            $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
                        }
                    }
                    return $response;
                    break;
                }
            }
        } catch ( Exception $e ) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

    }


    // 获取教练下的班级
    public function getGradeListOfCoachByPageApi(){
        try{
            $coach_id = input('param.coach_id');
            $map = function ($query) use ($coach_id){
                $query->where(['grade.coach_id'=>$coach_id])->whereOr('grade.assistant_id','like',"%\"$coach_id\"%");
            };
            $result = $this->GradeService->getGradeListByPage($map);
            return json($result);
        }catch (Exception $e){
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


}