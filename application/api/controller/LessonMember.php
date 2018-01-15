<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\LessonMemberService;
use think\Db;

class LessonMember extends Base{
    protected $LessonMemberService;
	public function _initialize(){
		parent::_initialize();
        $this->LessonMemberService = new LessonMemberService;
	}

    // 搜索学生带page
    public function searchLessonMemberByPageApi(){
        try{

            $map = input('post.');

            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->LessonMemberService->getLessonMemberListByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }

        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 搜索课程学生不带page
    public function searchLessonMemberNoPageApi(){
        try{

            $map = input('post.');

            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(isset($map['rest_schedule'])){
                $map['rest_schedule'] = ['lt',$map['rest_schedule']];
            }
            $LessonMember = new \app\model\LessonMember;
            $res =  $LessonMember->where($map)->select();
            if($res){
                $result = $res->toArray();
                // 遍历获取数据原始值
                foreach ($result as $k => $val) {
                    $getData = $LessonMember->where(['id' => $val['id']])->find()->getData();
                    $result[$k]['type_num'] = $getData['type'];
                    $result[$k]['status_num'] = $getData['status'];
                }
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }

        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取训练营下的学生带page(唯一)
    public function getLessonMemberListOfCampByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(isset($map['rest_schedule'])){
                $map['rest_schedule'] = ['lt',$map['rest_schedule']];
            }
            $result = $this->LessonMemberService->getLessonMemberListOfCampWithStudentByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取课程学生数据带page
    public function getLessonMemberListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(isset($map['rest_schedule'])){
                $map['rest_schedule'] = ['lt',$map['rest_schedule']];
            }
            $result = $this->LessonMemberService->getLessonMemberListWithStudentByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   
    // 获取与课程|班级|训练营相关的学生|体验生-不带page
    public function getLessonMemberListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(isset($map['rest_schedule'])){
                $map['rest_schedule'] = ['lt',$map['rest_schedule']];
            }
            $LessonMember = new \app\model\LessonMember;
            $result = $LessonMember->where($map)->select();
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取未分配班级的学生列表-带page
    public function getNoGradeMemberListByPageApi(){
        try{
            $map = input('post.');
            // 已分配的学生IDs
            $IDs = db('grade_member')->where($map)->where('delete_time','null')->column('student_id');
            $map['student_id']=['not in',$IDs];
            $result = $this->LessonMemberService->getLessonMemberListWithStudentByPage($map);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'查不到学生信息,请检查参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 课程转移
    public function transferLessonApi(){
        try{
            $data = input('post.');
            $remarks = input('param.remarks');
            $new_lesson_id = $data['new_lesson_id'];
            $lesson_id = $data['original_lesson_id'];
            $student_ids = json_decode($data['studentData'],true);
            // print_r($student_ids);die;
            $isGrade = db('grade_member')->where(['lesson_id'=>$lesson_id,'student_id'=>['in',$student_ids],'status'=>1])->find();
            if($isGrade){
                return json(['code'=>100,'msg'=>'请先把学生移除出'.$isGrade['grade'].'班级']);
            }
            $newLessonInfo = db('lesson')->where(['id'=>$new_lesson_id])->find();
            $lessonInfo = db('lesson')->where(['id'=>$lesson_id])->find();
            if($newLessonInfo['cost']<>$lessonInfo['cost']){
                return json(['code'=>100,'msg'=>'课程单价不一样,不允许转课']);
            }
            $LessonMember = new \app\model\LessonMember;
            $lessonMemberList = $LessonMember->where(['lesson_id'=>$lesson_id,'student_id'=>['in',$student_ids],'status'=>1])->select();
            if(!$lessonMemberList){
                return json(['code'=>100,'msg'=>'学生状态已改变']);
            }    
            $lessonMemberList = $lessonMemberList->toArray();        
            $data1 = [];
            $data2 = [];
            $msg = '';
            foreach ($lessonMemberList as $key => &$value) {
                if($value['transfer'] == 1 && $value['rest_schedule'] == 0){
                    $msg.= $value['stduent'].',';
                    continue;
                }
                //旧的
                $data1 = ['rest_schedule'=>0,'status'=>2,'transfer'=>1,'remarks'=>$remarks,'system_remarks'=>'转课转走'];
                $map1[] = $value['id'];
                // 新的
                $value['transfer'] = 1;
                $value['create_time'] = time();
                $value['status'] = 1;
                $value['type'] = 1;
                $value['system_remarks'] = '转课学生';
                unset($value['id']);
                unset($value['update_time']);
                $data2[] = $value;
            }
            // if($lessonMemberInfo['transfer']==1){
            //     return json(['code'=>100,'msg'=>'该生已转过课,不允许再次转课']);
            // }
            
            
            
            $LessonMember = new \app\model\LessonMember;
            $res = $LessonMember->saveAll($data2);
            if($res){
                $result = $this->LessonMemberService->updateLessonMember($data1,['id'=>['in',$map1]]);

                if($msg == ''){
                    return json(['code'=>200,'msg'=>'操作成功']);
                }else{
                    return json(['code'=>200,'msg'=>$msg.'已经转过课或者课时为0不允许再次转课']);
                }
                
            }else{
                return json($res);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
