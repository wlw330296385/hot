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

    // 班级列表（不分页所有数据)
    public function getGradeListAll(){
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
                $map['grade'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }

            $result = $this->GradeService->getGradeAllWithLesson($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
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

    public function getGradeListNoPageApi(){
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

            $result = $this->GradeService->getGradeListNoPage($map);
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
            // 获取班级数据
            $gradeInfo = $GradeService->getGradeInfo(['id' => $grade_id]);
            // 教练底薪，提成基数数值改变，更新班级现有的未审课时相关数据
            if ( $data['coach_salary'] != $gradeInfo['coach_salary']
                || $data['assistant_salary'] != $gradeInfo['assistant_salary']
                || $data['salary_base'] != $gradeInfo['salary_base']
            ) {
                db('schedule')
                    ->where([
                    'grade_id' => $gradeInfo['id'],
                    'status' => -1,
                    'is_settle' => 0
                    ])
                    ->whereNull('delete_time')
                    ->update([
                        'coach_salary' => $data['coach_salary'],
                        'assistant_salary' => $data['assistant_salary'],
                        'salary_base' => $data['salary_base']
                    ]);
            }

            if ( !empty($data['studentData']) && $data['studentData'] != '[]' ) {
                $studentData = json_decode($data['studentData'], true);
                $resSaveGradeMember = $GradeService->saveAllGradeMember($studentData,$grade_id);
                if ($resSaveGradeMember['code'] == 100) {
                    return json($resSaveGradeMember);
                }
            }

            $result = $GradeService->updateGrade($data, $data['grade_id']);
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
                }else{
                    return json($result);
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

    // 操作班级当前/预排状态 2017/10/2
    public function removegrade() {
        $gradeId = input('grade_id');
        if (!$gradeId) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 查询班级数据
        $gradeS = new GradeService();
        $grade = $gradeS->getGradeInfo(['id' => $gradeId]);
        if (!$grade) {
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
        // 训练营角色权限 教练以上才能操作
        $power = getCampPower($grade['camp_id'], $this->memberInfo['id']);
        if ($power < 2) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 若是教练角色 区分全职教练与兼职教练，全职教练可上下架班级+不能删除班级，兼职教练都不能操作
        if ($power == 2) {
            // 获取教练等级
            $powerLevel = getCampMemberLevel($grade['camp_id'], $this->memberInfo['id']);
            if ($powerLevel == 1) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }
        }
        // status字段更新值
        $statusTo = ($grade['status_num'] == 1) ? -1 : 1;
        try {
            $res = $gradeS->updateGradeStatus($grade['id'], $statusTo);
        } catch ( Exception $e ) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        // 返回结果
        if ($res) {
            $response = json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } else {
            $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return $response;
    }

    // 删除班级
    public function delgrade() {
        $gradeId = input('grade_id');
        if (!$gradeId) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 查询班级数据
        $gradeS = new GradeService();
        $grade = $gradeS->getGradeInfo(['id' => $gradeId]);
        if (!$grade) {
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
        // 训练营角色权限 教练以上才能操作
        $power = getCampPower($grade['camp_id'], $this->memberInfo['id']);
        if ($power < 3) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 当前班级不能删除，改为预排班级才能操作删除
        if ($grade['status_num'] == 1) {
            return json(['code' => 100, 'msg' => '当前班级不能删除,请先将班级设为预排班级']);
        }
        // 获取班级下学生名单
        $gradeStudentList = $gradeS->getGradeStudents(['grade_id' => $grade['id']]);
        // log_grade_member数据组合
        $dataLogDeleteGradeMember = [
            'member_id' => $this->memberInfo['id'],
            'member' => $this->memberInfo['member'],
            'action' => 'delete',
            'data' => json_encode($gradeStudentList, JSON_UNESCAPED_UNICODE),
            'referer' => input('server.http_referer'),
            'create_time' => date('YmdH:i', time())
        ];
        try {
            // 删除班级学员数据
            db('grade_member')->where(['grade_id' => $grade['id']])->delete();
            // 记录grade_member日志
            db('log_grade_member')->insert($dataLogDeleteGradeMember);
            // 软删除grade
            $res = $gradeS->delGrade($grade['id']);
        } catch ( Exception $e ) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        if ($res) {
            $response = json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } else {
            $response = json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return $response;
    }


    // 获取教练下的班级
    public function getGradeListOfCoachByPageApi(){
        try{
            $coach_id = input('param.coach_id');
            $camp_id = input('param.camp_id');
            if($camp_id){
                $map = function ($query) use ($coach_id,$camp_id){
                    $query->where(['grade.coach_id'=>$coach_id,'grade.camp_id'=>$camp_id])->whereOr('grade.assistant_id','like',"%\"$coach_id\"%");
                };
            }else{
                $map = function ($query) use ($coach_id){
                    $query->where(['grade.coach_id'=>$coach_id])->whereOr('grade.assistant_id','like',"%\"$coach_id\"%");
                };
            }
            
            $result = $this->GradeService->getGradeListByPage($map);
            if($result){
                return json(['code' => 200, 'msg' => '获取成功','data'=>$result]);
            }else{
                return json(['code' => 100, 'msg' =>'获取失败']);
            }
            
        }catch (Exception $e){
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取所有身份的班级
    
}