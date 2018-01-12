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
            $new_lesson_id = $data['new_lesson_id'];
            $lesson_id = $data['lesson_id'];
            $student_id = $data['student_id'];
            $isGrade = db('grade_member')->where(['lesson_id'=>$lesson_id,'student_id'=>$student_id,'status'=>1])->find();
            if($isGrade){
                return json(['code'=>100,'msg'=>'请先把学生移除出'.$isGrade['grade'].'班级']);
            }
                        
            $result = $this->LessonMemberService->updateLessonMember($data,$map);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
