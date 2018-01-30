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

    // 获取训练营相同价格的课程带分页带搜索
    public function getSamePriceLessonMemberListByPageApi(){
        try{
            $lesson_id = input('param.lesson_id');
            $keyword = input('param.keyword');
            $rest_schedule = input('param.rest_schedule');
            $lessonInfo = db('lesson')->where(['id'=>$lesson_id])->find();
            $model = new \app\model\LessonMember();
            $map = [];
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['lesson_member.student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if(isset($rest_schedule)){
                $map['lesson_member.rest_schedule'] = ['lt',$rest_schedule];
            }
            $result = Db::view('lesson','id lid,cost,camp_id')
                    ->view('lesson_member','*','lesson_member.lesson_id = lesson.id')
                    ->where($map)
                    ->where("lesson.cost={$lessonInfo['cost']} and lesson.camp_id={$lessonInfo['camp_id']}")
                    // ->having("lesson.cost=$cost and lesson.camp_id=$camp_id")
                    ->order('lesson_member.id desc')
                    ->paginate(30);
                    // ->select();
            if($result){
                $list = $result->toArray();
                foreach ($list['data'] as $k => $val) {
                    $lessonmember = $model->where(['id' => $val['id']])->find();
                    if ($lessonmember) {
                        $lessonmemberArr = $lessonmember->toArray();
                        $list['data'][$k]['type'] = $lessonmemberArr['type'];
                        $list['data'][$k]['status'] = $lessonmemberArr['status'];
                    }
                }
                return json(['code'=>200,'msg'=>'ok','data'=>$list]);
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
            $original_lesson_id = $data['original_lesson_id'];
            $new_lesson = $data['new_lesson'];
            $student_ids = json_decode($data['studentData'],true);
            // print_r($student_ids);die;
            $isGrade = db('grade_member')->where(['lesson_id'=>$original_lesson_id,'student_id'=>['in',$student_ids],'status'=>1])->find();
            if($isGrade){
                return json(['code'=>100,'msg'=>'请先把学生移除出'.$isGrade['grade'].'班级']);
            }
            $newLessonInfo = db('lesson')->where(['id'=>$new_lesson_id])->find();
            $lessonInfo = db('lesson')->where(['id'=>$original_lesson_id])->find();
            if($newLessonInfo['cost']<>$lessonInfo['cost']){
                return json(['code'=>100,'msg'=>'课程单价不一样,不允许转课']);
            }
            $LessonMember = new \app\model\LessonMember;
            $lessonMemberList = $LessonMember->where(['lesson_id'=>$original_lesson_id,'student_id'=>['in',$student_ids],'status'=>1])->select();
            if(!$lessonMemberList){
                return json(['code'=>100,'msg'=>'学生状态已改变']);
            }    
            $lessonMemberList = $lessonMemberList->toArray();        
            $data1 = [];
            $data2 = [];
            $msg = '';
            
            // $TransferLesson = new \app\model\TransferLesson;
            foreach ($lessonMemberList as $key => &$value) {
                if($value['transfer'] <> 0 && $value['rest_schedule'] == 0){
                    $msg.= $value['stduent'].',';
                    continue;
                }

                
                $transferData = ['new_lesson_id'=>$new_lesson_id,'new_lesson'=>$new_lesson,'original_lesson_id'=>$value['lesson_id'],'original_lesson'=>$value['lesson'],'camp_id'=>$value['camp_id'],'camp'=>$value['camp'],'student_id'=>$value['student_id'],'student'=>$value['student'],'member_id'=>$value['member_id'],'member'=>$value['member'],'rest_schedule'=>$value['rest_schedule'],'total_schedule'=>$value['total_schedule'],'hamal'=>session('memberInfo.member','','think'),'hamal_id'=>session('memberInfo.id','','think'),'create_time'=>time(),'remarks'=>$remarks];
                // 转课记录
                $res = Db::transaction(function() use ($transferData){
                    
                    db('transfer_lesson')->insert($transferData); 
                    // return $TransferLesson->id;
                });
                //旧的
                $data1 = ['transfer'=>1,'system_remarks'=>'转课操作','lesson_id'=>$new_lesson_id,'lesson'=>$new_lesson,'status'=>1,'camp'=>$value['camp'],'camp_id'=>$value['camp_id']];
                $map1[] = $value['id'];
               
                
            } 
            // if($lessonMemberInfo['transfer']==1){
            //     return json(['code'=>100,'msg'=>'该生已转过课,不允许再次转课']);
            // }
                
           
            
            // $LessonMember = new \app\model\LessonMember;
            // $res = $LessonMember->saveAll($data2);
            if(empty($data1)){
                return json(['code'=>100,'msg'=>$msg.'已经转过课或者课时为0不允许再次转课']);
            }
            $result = $this->LessonMemberService->updateLessonMember($data1,['id'=>['in',$map1]]);
            if($result['code']==200){
                if($msg == ''){
                    return json(['code'=>200,'msg'=>'全部操作成功']);
                }else{
                    return json(['code'=>200,'msg'=>$msg.'已经转过课或者课时为0不允许再次转课,剩下的操作成功']);
                }
            }else{
                return json($result);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
