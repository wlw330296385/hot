<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CampService;
use app\service\CoachService;
use app\service\ScheduleService;
use think\Db;
class Camp extends Base{
    protected $CampService;
    protected $CoachService;
	public function _initialize(){
		parent::_initialize();
        $this->CampService = new CampService;
        $this->CoachService = new CoachService;
	}


    public function index() {
        // 最新消息
        $member_id = $this->memberInfo['id'];
        $messageList = db('message')->page(1,10)->select();
        $CampMember = new \app\model\CampMember; 
        $campList = $CampMember->where(['member_id'=>$member_id,'status'=>1])->select();
        
        $this->assign('campList',$campList);
        $this->assign('messageList',$messageList);
        return view('Camp/index');
    }

    public function createCamp(){
        $step = input('step', 1);
        $view = 'Camp/createCamp'.$step;
        $fast = input('fast', 0);
        $campid = input('camp_id');
        $campS = new CampService();
        $camp = $campS->getCampInfo($campid);
        
        $this->assign('fast', $fast);
        $this->assign('camp', $camp);
        return view($view);
    }

    public function registerSuccess() {
        return view('Camp/registerSuccess');
    }

    public function campInfo(){
        $camp_id = input('param.camp_id');
 
        $lessonList = db('lesson')->where(['camp_id'=>1,'status'=>1])->limit(5)->select();
        $lessonCount = count($lessonList);
        $commentList = $this->CampService->getCampCommentListByPage(['camp_id'=>$camp_id]);
        $campInfo = $this->CampService->getCampInfo($camp_id);
        // 查询是否跟训练营有关系
        $isPower = $this->CampService->isPower($camp_id,$this->memberInfo['id']);

        $this->assign('isPower',$isPower);
        $this->assign('commentList',$commentList['data']);
        $this->assign('lessonCount',$lessonCount);
        $this->assign('lessonList',$lessonList);
        $this->assign('campInfo',$campInfo);
        return view('Camp/campInfo');
    }

    public function campList(){
        // $map = input();
        // $campList = $this->CampService->campListPage($map);
        $campList = [];
        $this->assign('campList',$campList);
        return view('Camp/campList');
    }

  

    public function searchCamp(){
        $keyword = input('keyword');
        $province = input('province');
        $city = input('city');
        $area = input('area');
        $map = ['province'=>$province,'city'=>$city,'area'=>$area];
        foreach ($map as $key => $value) {
            if($value == ''){
                unset($map[$key]);
            }
        }
        if($keyword){
            $map['camp'] = ['LIKE',$keyword];
        }
        $campList = $this->CampService->getCampList($map);
        $this->assign('campList',$campList);
        return view('Camp/searchCamp');
    }

    public function searchCampApi(){
        try{
             $keyword = input('keyword');
            $province = input('province');
            $city = input('city');
            $area = input('area');
            $map = ['province'=>$province,'city'=>$city,'area'=>$area];
            foreach ($map as $key => $value) {
                if($value == ''){
                    unset($map[$key]);
                }
            }
            if($keyword){
                $map['camp'] = ['LIKE',$keyword];
            }
            $campList = $this->CampService->campListPage($map);
            return json(['code'=>100,'msg'=>'OK','data'=>$campList]);
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }       
    }


    // 邀请学生入驻
    public function inviteStudent(){
        $data = input('param.');
        $data['member'] = $this->memberInfo['member'];
        $data['member_id'] = $this->memberInfo['id'];
        $data['type'] = 1;
        $data['status'] = 1;
        $is_join = db('camp_member');
        return view('Camp/inviteStudent');
    }



    // 邀请教练入驻
    public function inviteCoach(){
        return view();
    }

    // 学生的训练营
    public function campListOfStudent(){
        $member_id = $this->memberInfo['id'];
        $actCampList = Db::view('camp_member','camp_id,member_id')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo','camp.id=camp_member.camp_id')
                        ->where(['camp_member.member_id'=>$member_id,'camp_member.type'=>1,'camp_member.status'=>1])
                        ->select();
        $restCampList = Db::view('camp_member','camp_id')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo','camp.id=camp_member.camp_id')
                        ->where(['camp_member.member_id'=>$member_id,'camp_member.type'=>1,'camp_member.status'=>2])
                        ->select();
        $this->assign('actCampList',$actCampList);
        $this->assign('restCampList',$restCampList);
        return view('Camp/campListOfStudent');
    }

    // 教练身份的训练营
    public function campListOfCoach(){
        $coach_id = input('param.coach_id');
        if(!$coach_id){
            $member_id = $this->memberInfo['id'];
            $coachInfo = db('coach')->where(['member_id'=>$member_id])->find();
            $this->assign('coachInfo',$coachInfo);
            $coach_id = $coachInfo['id'];
        }else{
            $coachInfo = db('coach')->where(['id'=>$coach_id])->find();
            $member_id = $coachInfo['member_id'];
        }
        $campList = Db::view('camp_member','camp_id,member_id,type,status')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo,id','camp.id=camp_member.camp_id')
                        ->where(['camp_member.member_id'=>$member_id,'camp_member.type'=>2,'camp_member.status'=>1])
                        ->select();
        $this->assign('campList',$campList);
        return view('Camp/campListOfCoach');
    }

    // 申请列表
    public function applyListOfCoach(){
        $camp_id = input('param.camp_id');
        $applyListOfCoach = Db::view('camp_member','member_id,remarks')
                            ->view('coach','star,coach,coach_level,lesson_flow,portraits','coach.member_id=camp_member.member_id')
                            ->view('member','sex,birthday','coach.member_id=member.id')
                            ->where(['camp_member.camp_id'=>$camp_id,'camp_member.type'=>2,'camp_member.status'=>0])
                            ->select();
        // 计算年龄
        foreach ($applyListOfCoach as $key => $value) {
            $applyListOfCoach[$key]['age'] = ceil(( time() - strtotime($value['birthday']))/31536000) ;
        }
        $count = count($applyListOfCoach);
        $this->assign('count',$count);
        // dump($applyListOfCoach);die;
        $this->assign('applyListOfCoach',$applyListOfCoach);
        return view('Camp/applyListOfCoach');
    }


    public function studentInfo(){

        return view('Camp/studentInfo');
    }

    // 没啥权限的campInfo菜单
    public function indexCamp(){

        return view('Camp/indexCamp');
    }

    // 管理员的camp菜单
    public function powerCamp(){
        $camp_id = input('param.camp_id');
        $member_id = $this->memberInfo['id'];
        $power = $this->CampService->isPower($camp_id,$member_id);
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $gradeCount = db('grade')->where(['camp_id'=>$camp_id])->count();
        $scheduleCount = db('schedule')->where(['camp_id'=>$camp_id])->count();
        $lessonCount = db('lesson')->where(['camp_id'=>$camp_id])->count();
        $this->assign('power',$power);
        $this->assign('gradeCount',$gradeCount);
        $this->assign('scheduleCount',$scheduleCount);
        $this->assign('lessonCount',$lessonCount);
        $this->assign('campInfo',$campInfo); 
        return view('Camp/powerCamp');
    }

    // 非管理员的camp菜单
    public function clientOfcamp(){
        $camp_id = input('param.camp_id');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $GradeMember = new \app\model\GradeMember;
        $objStudentList = $GradeMember->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>$camp_id])->select();
        if($objStudentList){
            $studentList = $objStudentList->toArray();
        }else{
            $studentList = [];
        }
        $this->assign('studentList',$studentList);
        $this->assign('campInfo',$campInfo); 
        return view('Camp/clientOfcamp');
    }

    // 教练的camp菜单
    public function coachCamp(){
        $camp_id = input('param.camp_id');
        $member_id = $this->memberInfo['id'];
        $is_power = $this->CampService->isPower($camp_id,$member_id);
        if($is_power == 0){
            $this->error('您没有权限');
        }
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $gradeCount = db('grade')->where(['camp_id'=>$camp_id])->count();
        $scheduleCount = db('schedule')->where(['camp_id'=>$camp_id])->count();
        $lessonCount = db('lesson')->where(['camp_id'=>$camp_id])->count();

        $this->assign('gradeCount',$gradeCount);
        $this->assign('scheduleCount',$scheduleCount);
        $this->assign('lessonCount',$lessonCount);
        $this->assign('campInfo',$campInfo); 
        return view('Camp/coachCamp');
    }

    /* public function coachListOfCamp(){
        $camp_id = input('param.camp_id');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $type = input('param.type')?input('param.type'):2;
        $status = input('param.status')?input('param.status'):1;
        $map = ['camp_member.camp_id'=>$camp_id,'camp_member.type'=>$type,'camp_member.status'=>$status];
        $coachList = $this->CoachService->getCoachListOfCamp($map);
        $this->assign('campInfo',$campInfo); 
        $this->assign('coachList',$coachList);
        return view('Camp/coachListOfCamp');
    }*/

    // 训练营设置
    public function campSetting(){
         $step = input('param.step', 1);
        $view = 'Camp/campSetting'.$step;
        $camp_id = input('param.camp_id');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $is_power = $this->CampService->isPower($camp_id,$this->memberInfo['id']);

        if($is_power < 4){
            $this->error('您没有权限');
        }
        // 营业执照
        $campS = new CampService();
        $campcert = $campS->getCampCert($camp_id);

        $this->assign('campInfo',$campInfo);
        $this->assign('campcert', $campcert);
        return view($view);
    }

    // 训练营设置成功
    public function editsuccess() {
        $edit = input('param.edit', 0);
        $this->assign('edit', $edit);
        return view('Camp/editsuccess');
    }

    // 训练营教练列表
    public function coachListOfCamp() {
        $camp_id = input('camp_id');
        $status = input('status', 1);
        if ($camp_id) {
            $map['camp_member.camp_id'] = $camp_id;
        } else {
            $campS = new CampService();
            $owncamp = $campS->getOnecamp(['member_id' => $this->memberInfo['id']]);
//            dump($owncamp);
            if ($owncamp && $owncamp['check_status']) {
                $map['camp_member.camp_id'] = $owncamp['id'];
            }
        }
        $map['camp_member.status'] = $status;
        $map['camp_member.type'] = ['egt', 2];
        $list= Db::view('camp_member','camp_id')
            ->view('coach','*','coach.member_id=camp_member.member_id')
            ->where($map)
            ->select();
//        dump($list);

        $this->assign('coachlist', $list);
        $this->assign('camp_id', $camp_id);
        $view = $status ? 'Camp/coachListOfCamp' : 'Camp/coachapplylist';
        return view($view);
    }

    // 训练营教练加入申请
    public function coachapply() {
        $coach_id = input('param.coach_id');
        $coachS = new CoachService();
        if($coach_id){
            $coachInfo = $coachS->getCoachInfo(['id'=>$coach_id]);
        }

        // 申请留言
        $campmember = db('camp_member')->where(['member_id' => $coachInfo['member_id'], 'camp_id' => input('camp_id'), 'type' => 2])->find();

        // 全部班级
        $gradeList = db('grade')->where(['coach_id'=>$this->memberInfo['id']])->column('id');
        $gradeCount = count($gradeList);
        // 全部学员
        $studentCount = db('grade_member')->distinct(true)->field('member_id')->where(['grade_id'=>['in',$gradeList],'type'=>1,'status'=>1])->count();
        // 执教过多少课时
        $scheduleS = new ScheduleService();
        $scheduleCount =$scheduleS->countSchedules(['coach_id'=>$coachInfo['id'],'status'=>1]);
        //教练评论
        $commentList = db('coach_comment')->where(['coach_id'=>$coach_id])->select();
        //所属训练营
        $campList = Db::view('camp_member','camp_id')
            ->view('camp','logo','camp.id=camp_member.camp_id')
            ->where(['camp_member.member_id'=>$coachInfo['member_id'], 'camp_member.type'=> 2,'camp_member.status'=>1])
            ->select();

        $this->assign('campmember', $campmember);
        $this->assign('campList',$campList);
        $this->assign('commentList',$commentList);
        $this->assign('scheduleCount',$scheduleCount);
        $this->assign('studentCount',$studentCount);
        $this->assign('gradeCount',$gradeCount);
        $this->assign('coachInfo',$coachInfo);
        return view('Camp/coachapply');
    }

    // 训练营下教练档案
    public function coachInfoOfcamp(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $coach_id = input('param.coach_id');
        $camp_id = input('param.camp_id');


        $coachS = new CoachService();
        if(!$coach_id){
            // 获取教练档案
            $coachInfo = $coachS->getCoachInfo(['member_id'=>$member_id]);
            $coach_id = $coachInfo['id'];
        }else{
            $coachInfo =$coachS->getCoachInfo(['id'=>$coach_id]);
        }
        //教练的班级
        $GradeService = new \app\service\GradeService;
        $gradeOfCoachList = $GradeService->getGradeList(['coach_id'=>$member_id,'camp_id'=>$camp_id]);
        // 教练的证件
        $cert = db('cert')->where(['member_id'=>$member_id])->select();
        $identCert = [];
        $coachCert = [];
        foreach ($cert as $key => $value) {
            if($value['cert_type'] == 1){
                $identCert = $value;
            }

            if($value['cert_type'] == 3){
                $coachCert = $value;
            }
        }
        // dump($identCert);die;
        if(empty($identCert)){
            $identCert['cert_no'] = '未认证';
        }
        if(empty($coachCert)){
            $coachCert = ['photo_positive'=>'/static/frontend/images/uploadDefault.jpg','photo_back'=>'/static/frontend/images/uploadDefault.jpg'];
        }
        //获取教练的课量
        $m = input('m')?input('m'):date('m');
        $y = input('y')?input('y'):date('Y');
        $begin_m = mktime(0,0,0,$m,1,$y);
        $end_m = mktime(23,59,59,$m,30,$y)-1;
        $begin_y = mktime(0,0,0,1,1,$y);
        $end_y = mktime(23,59,59,12,30,$y)-1;

        $scheduleS = new ScheduleService();
        $monthScheduleOfCoachList = $scheduleS->getScheduleList([
                'coach_id'=>$member_id,
                // 'type'=>1,
                'camp_id'=>$camp_id,
                'create_time'=>['BETWEEN',[$begin_m,$end_m]]
            ]);

        $monthScheduleOfCoach = count($monthScheduleOfCoachList);
        $yearScheduleOfCoachList = $scheduleS->getScheduleList([
                'coach_id'=>$member_id,
                // 'type'=>1,
                'camp_id'=>$camp_id,
                'create_time'=>['BETWEEN',[$begin_y,$end_y]]
            ]);
        $yearScheduleOfCoach = count($yearScheduleOfCoachList);
        //教练工资
        $SalaryInService = new \app\service\SalaryInService($member_id);
        $salaryList = $SalaryInService->getSalaryInList(['member_id'=>$member_id,'type'=>1,'camp_id'=>$camp_id]);
        // 平均月薪
        $averageSalaryByMonth = $SalaryInService->getAverageSalaryByMonth($member_id,$camp_id);
        // 平均年薪
        $averageSalaryByYear = $SalaryInService->getAverageSalaryByYear($member_id,$camp_id);
        // dump($salaryList);die;
        $this->assign('monthScheduleOfCoachList',$monthScheduleOfCoachList);//教练当月的课量
        $this->assign('monthScheduleOfCoach',$monthScheduleOfCoach);//当月课量数量
        $this->assign('gradeOfCoachList',$gradeOfCoachList);//教练班级

        $this->assign('yearScheduleOfCoachList',$yearScheduleOfCoachList);//当年课量
        $this->assign('yearScheduleOfCoach',$yearScheduleOfCoach);//当年课量数量
        $this->assign('y',$y);
        $this->assign('m',$m);
        $this->assign('salaryList',$salaryList);
        $this->assign('coachInfo',$coachInfo);
        $this->assign('identCert',$identCert);
        $this->assign('coachCert',$coachCert);
        $this->assign('averageSalaryByMonth',$averageSalaryByMonth);
        $this->assign('averageSalaryByYear',$averageSalaryByYear);
        return view('Camp/coachInfoOfCamp');
    }

    // 训练营的场地列表
    public function courtListOfCamp(){
        $camp_id = input('param.camp_id')?input('param.camp_id'):0;
        // $CourtService = new \app\service\CourtService;
        // $courtList = $CourtService->getCourtList(['camp_id'=>$camp_id,'status'=>1]);
        // $campInfo = $this->CampService->getCampInfo(['id'=>$camp_id]);

        // dump($courtList);die;
        // $this->assign('campInfo',$campInfo);
        // $this->assign('courtList',$courtList);
        $this->assign('camp_id',$camp_id);
        return view('Camp/courtListOfCamp');
    }

}
