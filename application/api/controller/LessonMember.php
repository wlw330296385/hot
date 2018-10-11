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
            $map = ['lesson_member.is_school'=>-1];
            $map = ['lesson_member.status'=>1];
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
            $keyword = input('param.keyword');

            // 已分配的学生IDs
            $IDs = db('grade_member')->where($map)->where('delete_time','null')->column('student_id');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['lesson_member.student'] = ['LIKE','%'.$keyword.'%'];
            }
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


    // 设置过期时间
    public function setExpireApi(){
        try {
            $expire_time = input('param.expire_time');
            $lesson_member_id = input('param.lesson_member_id');
            if ($expire_time && $lesson_member_id) {
                if($expire_time == -1){
                    $expire = 0;
                }else{
                    $expire = strtotime($expire_time) + 86399;
                }
                
                $result = db('lesson_member')->where(['id'=>$lesson_member_id])->update(['expire'=>$expire]);
                if($result){
                    return json(['code'=>200,'msg'=>'操作成功']);
                }else{
                    return json(['code'=>100,'msg'=>'操作失败']);
                }
            }else{
                return json(['code'=>100,'msg'=>'缺少参数']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取拥有订单的LessonMember数据不分页
    public function getLessonMemberJoinBillListNoPageApi(){
        try {
            $lesson_id = input('param.lesson_id');
            // $result = db('lesson_member lm')
            //         ->field('lm.*,b.id b_id,b.total_gift as b_total,b.status as b_status,b.bill_order,b.create_time as b_c')
            //         ->join('bill b','b.goods_id = lm.lesson_id and b.student_id = lm.student_id')
            //         ->where(['lm.lesson_id'=>$lesson_id])
            //         ->where(['lm.is_school'=>-1])
            //         ->where(['b.status'=>1])
            //         ->where(['b.total_gift'=>0])
            //         ->order('b.id desc')
            //         ->select();

            $sql = "SELECT lm.*,b.id b_id,b.total_gift as b_total,b.status as b_status,b.bill_order,b.create_time as b_c FROM bill as b inner join lesson_member as lm
                    on b.student_id = lm.student_id AND b.goods_id = lm.lesson_id
                    WHERE
                    b.`id`
                    in
                    (SELECT max(`id`) FROM bill WHERE status = 1 AND total_gift = 0 group by `student_id`)
                    AND lm.lesson_id = :lesson_id
                    AND lm.status = 1";

            $result = Db::query($sql,['lesson_id'=>$lesson_id]);
            return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function getLessonMemberJoinGradeMemberListApi(){
        try {
            $lesson_id = input('param.lesson_id');
            $result = db('lesson_member')
                    ->field('lesson_member.*,grade_member.student_id as gs_id,grade_member.lesson_id as gl_id,grade_member.grade_id as g_id')
                    ->join('grade_member','grade_member.student_id = lesson_member.student_id and grade_member.lesson_id = lesson_member.lesson_id','left')
                    ->where(['lesson_member.lesson_id'=>$lesson_id,'lesson_member.status'=>1])
                    ->order('lesson_member.id desc')
                    ->select();
            return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);        
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 把学生设置离赢
    public function intakeStudentApi(){
        try {
            $l_id = input('param.l_id');
            $intake = input('param.intake');
            $camp_id = db('lesson_member')->where(['id'=>$l_id])->value('camp_id');
            $isPower = db('camp_member')->where(['camp_id'=>$camp_id,'member_id'=>$this->memberInfo['id'],'status'=>1])->value('type');
            if(!$isPower || $isPower<3){
                return json(['code'=>100,'msg'=>'权限不足']);
            }
            $res = db('lesson_member')->where(['id'=>$l_id])->update(['intake'=>$intake]);
            if($res){
                return json(['code'=>200,'msg'=>'操作成功']);
            }else{
                return json(['code'=>100,'msg'=>'未改变任何状态']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
