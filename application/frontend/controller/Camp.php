<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\model\CampMember;
use app\service\CampService;
use app\service\CoachService;
use app\service\MemberService;
use app\service\ScheduleService;
use think\Db;
class Camp extends Base{
    protected $CampService;
    protected $CoachService;
    protected $campInfo;
	public function _initialize(){
		parent::_initialize();
        $this->CampService = new CampService;
        $this->CoachService = new CoachService;
        $camp_id = input('param.camp_id', 0);
        $camp = $this->CampService->getCampInfo(['id'=>$camp_id]);
        $this->campInfo = $camp;
        $this->assign('camp_id', $camp_id);
        $this->assign('campInfo', $camp);
	}


    public function index() {
        // 最新消息
        $member_id = $this->memberInfo['id'];
        $messageList = db('message')->page(1,10)->select();
        $CampMember = new \app\model\CampMember; 
        if($this->o_id > 0 && $this->o_type == 1){
            $campList = $CampMember::with('camp')->where(['camp_id'=>$this->o_id,'member_id'=>$member_id,'status'=>1])->select();
        }else{
            $campList = $CampMember::with('camp')->where(['member_id'=>$member_id,'status'=>1])->select();
        }
        // $campList = $CampMember::with('camp')->where(['member_id'=>$member_id,'status'=>1])->select();
        if($campList){
            $campList = $campList->toArray();
        }
        $this->assign('campList',$campList);
        $this->assign('messageList',$messageList);
        return view('Camp/index');
    }

    public function createCamp(){
        $step = input('step', 1);
        $view = 'Camp/createCamp'.$step;
        $fast = input('fast', 0);
        $camp_id = input('camp_id');
        $campS = new CampService();
        $camp = $campS->getCampInfo(['id'=>$camp_id]);
        
        $this->assign('fast', $fast);
        $this->assign('camp', $camp);
        return view($view);
    }

    public function registerSuccess() {
        return view('Camp/registerSuccess');
    }

    public function campInfo(){
        $camp_id = input('param.camp_id');
        $LessonService = new \app\service\LessonService;
        $lessonList = $LessonService->getLessonList(['camp_id'=>$camp_id,'status'=>1]);
        $lessonCount = count($lessonList);
        $campInfo = $this->CampService->getCampInfo(['id'=>$camp_id]);
        // 查询是否跟训练营有关系
        $isPower = $this->CampService->isPower($camp_id,$this->memberInfo['id']);

        $this->assign('isPower',$isPower);
        $this->assign('lessonCount',$lessonCount);
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
                        ->order('camp_member.id desc')
                        ->select();
        $restCampList = Db::view('camp_member','camp_id')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo','camp.id=camp_member.camp_id')
                        ->where(['camp_member.member_id'=>$member_id,'camp_member.type'=>1,'camp_member.status'=>2])
                        ->order('camp_member.id desc')
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
                        ->order('camp_member.id desc')
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
                            ->order('camp_member.id desc')
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
        // 获取会员在训练营角色
        $power = $this->CampService->isPower($camp_id,$member_id);
        // 若是教练 获取教练权限
        $level = 0;
        if($power==2) {
            $level = $this->CampService->getCampMemberLevel($camp_id,$member_id);
        }
        $campInfo = $this->CampService->getCampInfo(['id'=>$camp_id]);
        // 班级总数
        $gradeCount = db('grade')->where(['camp_id'=>$camp_id])->where('delete_time', null)->count();
        // 课时总数
        $scheduleList = db('schedule')->where(['camp_id'=>$camp_id])->where('delete_time', null)->select();
        $totalSchedule = count($scheduleList);//已上课量
        $totalScheduleStudent = 0;//上课人次;
        foreach ($scheduleList as $key => $value) {
            $totalScheduleStudent = $totalScheduleStudent + $value['students'];
        }
        // 课程总数
        $lessonCount = db('lesson')->where(['camp_id'=>$camp_id])->where('delete_time', null)->count();
        
        // 学生总数
        $totalStudentList = db('lesson_member')->distinct(true)->field('student_id')->where(['camp_id'=>$camp_id])->where('delete_time', null)->select();
        $totalStudent = count($totalStudentList);
        //购买次数
        $totalBill = db('bill')->where(['camp_id'=>$camp_id,'is_pay'=>1])->where('delete_time', null)->count();

        $this->assign('power',$power);
        $this->assign('level', $level);
        $this->assign('totalStudent',$totalStudent);//全部学生
        $this->assign('totalBill',$totalBill);//购买次数
        $this->assign('totalScheduleStudent',$totalScheduleStudent);//上课人次
        $this->assign('gradeCount',$gradeCount);//全部班级
        $this->assign('totalSchedule',$totalSchedule);//已上课量
        $this->assign('lessonCount',$lessonCount);//全部课程
        $this->assign('campInfo',$campInfo); 
        return view('Camp/powerCamp');
    }

    // 非管理员的camp菜单
    public function clientOfcamp(){
        $camp_id = input('param.camp_id');
        $campInfo = $this->CampService->getCampInfo(['id'=>$camp_id]);
        $LessonMember = new \app\model\LessonMember;
        $objStudentList = $LessonMember->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>$camp_id])->select();
        if($objStudentList){
            $studentList = $objStudentList->toArray();
        }else{
            $studentList = [];
        }
        $Grade = new \app\model\Grade;
        $leaderList = $Grade->where(['camp_id'=>$camp_id,'leader_id'=>$this->memberInfo['id']])->select();

        $teacherList = $Grade->where(['camp_id'=>$camp_id,'teacher_id'=>$this->memberInfo['id']])->select();
        $this->assign('teacherList',$teacherList);
        $this->assign('leaderList',$leaderList);
        $this->assign('studentList',$studentList);
        $this->assign('campInfo',$campInfo); 
        return view('Camp/clientOfCamp');
    }

    // 教练的camp菜单
    public function coachCamp(){
        $camp_id = input('param.camp_id');
        $member_id = $this->memberInfo['id'];
        $is_power = $this->CampService->isPower($camp_id,$member_id);
        if($is_power == 0){
            $this->error('您没有权限');
        }
        $campInfo = $this->CampService->getCampInfo(['id'=>$camp_id]);
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
        $campInfo = $this->CampService->getCampInfo(['id'=>$camp_id]);
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
        $campInfo = $this->CampService->getCampInfo(['id'=>$camp_id]);
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
        $map['camp_member.type'] = ['in', '2,4'];
        $list= Db::view('camp_member','camp_id')
            ->view('coach','*','coach.member_id=camp_member.member_id')
            ->where($map)
            ->order('camp_member.id desc')
            ->select();

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

        // 教练的证件
        $cert = db('cert')->where(['member_id'=>$coachInfo['member_id']])->select();
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
            ->order('camp_member.id desc')
            ->select();

        $this->assign('campmember', $campmember);
        $this->assign('campList',$campList);
        $this->assign('commentList',$commentList);
        $this->assign('scheduleCount',$scheduleCount['sum']);
        $this->assign('studentCount',$studentCount);
        $this->assign('gradeCount',$gradeCount);
        $this->assign('coachInfo',$coachInfo);
        $this->assign('identCert',$identCert);
        $this->assign('coachCert',$coachCert);
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
        $gradeOfCoachList = $GradeService->getGradeList(['coach_id'=>$coachInfo['id'],'camp_id'=>$camp_id]);
        // 教练的证件
        $cert = db('cert')->where(['member_id'=>$coachInfo['member_id']])->select();
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
                'coach_id'=>$coachInfo['member_id'],
                // 'type'=>1,
                'camp_id'=>$camp_id,
                'create_time'=>['BETWEEN',[$begin_m,$end_m]]
            ]);

        $monthScheduleOfCoach = count($monthScheduleOfCoachList);
        $yearScheduleOfCoachList = $scheduleS->getScheduleList([
                'coach_id'=>$coachInfo['member_id'],
                // 'type'=>1,
                'camp_id'=>$camp_id,
                'create_time'=>['BETWEEN',[$begin_y,$end_y]]
            ]);
        $yearScheduleOfCoach = count($yearScheduleOfCoachList);
        //教练工资
        $SalaryInService = new \app\service\SalaryInService($member_id);
        $salaryList = $SalaryInService->getSalaryInList(['member_id'=>$coachInfo['member_id'],'type'=>1,'camp_id'=>$camp_id]);

        // 本月工资
        $monthStamp = getStartAndEndUnixTimestamp(date('Y'), date('m'));
        $mapMonth = [
            'camp_id' => $camp_id,
            'member_id' => $coachInfo['member_id'],
            'schedule_time' => ['between', [$monthStamp['start'], $monthStamp['end']]],
            //'member_type' => ['lt', 5]
            'type' => 1,
        ];
        // 本年工资
        $yearStamp = getStartAndEndUnixTimestamp(date('Y'));
        $mapYear = [
            'camp_id' => $camp_id,
            'member_id' => $coachInfo['member_id'],
            'schedule_time' => ['between', [$yearStamp['start'], $yearStamp['end']]],
            //'member_type' => ['lt', 5]
            'type' => 1,
        ];
        // 如果教练是训练营营主 统计算入营主的份额
        $coachIsCampPower4 = getCampPower($camp_id, $coachInfo['member_id']);
        if ($coachIsCampPower4 && $coachIsCampPower4 != 4) {
            $mapMonth['member_type'] = ['lt', 5];
            $mapYear['member_type'] = ['lt', 5];
        }
        
        $SalaryMonth = $SalaryInService->countSalaryin($mapMonth);
        $SalaryYear = $SalaryInService->countSalaryin($mapYear);
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
        $this->assign('SalaryMonth',$SalaryMonth);
        $this->assign('SalaryYear',$SalaryYear);
        $this->assign('camp_id', $camp_id);
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

    // 训练营-教务人员列表
    public function teachlistofcamp() {
        $camp_id = input('camp_id', 0);
        $status = input('status', 1);
        $this->assign('camp_id',$camp_id);
        $view = $status ? 'Camp/teachlistOfCamp' : 'Camp/teachapplylist';
        return view($view);
    }

    // 训练营-教务人员详情
    public function teachinfoofcamp() {
        $member_id = input('member_id');
        $camp_id = input('camp_id');

        $memberS = new MemberService();
        $member = $memberS->getMemberInfo(['id' => $member_id]);
        $campmember = $memberS->campmemberInfo(['member_id'=>$member_id, 'camp_id'=>$camp_id]);

        $this->assign('memberInfo', $member);
        $this->assign('campmember', $campmember);
        return view('Camp/teachInfoOfCamp');
    }

    // 训练营-粉丝列表
    public function fanslist() {
        return view('Camp/fansList');
    }


    // 注销训练营申请
    public function cancell() {
        $camp_id = input('camp_id');
        $campCancellInfo = $this->CampService->getCampCancellByCampId($camp_id);
        return view('Camp/cancell', [
            'campCancellInfo' => $campCancellInfo
        ]);
    }





    // 训练营统计表
    public function campStatistics(){
        $campInfo = $this->campInfo;
        $Time = new \think\helper\Time;
        $campInfo = db('camp')->where(['id'=>$campInfo['id']])->find();

        // 一个月的收益
        $monthIncome = db('income')->where(['camp_id'=>$campInfo['id']])->whereTime('create_time','m')->where('delete_time',null)->sum('income');
        if($campInfo['rebate_type'] == 2){
            $monthOutput = db('output')->where(['camp_id'=>$campInfo['id']])->where('type',
                'not in',[-1,-2,3])->whereTime('create_time','m')->where('delete_time',null)->sum('output');
            $monthOutput = $monthOutput?$monthOutput:0;
            $monthIncome = $monthIncome - $monthOutput;
        }   
        // 总收益
        $totalIncome = db('income')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->sum('income');
        // 赠课总人数
        $totalGift = db('schedule_giftrecord')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->sum('student_num');
        
        
        //总已上课量
        $totalSchedule = 0;
        $totalScheduleList = db('schedule')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->select();
        $totalSchedule = count($totalScheduleList);
        // 上课总人次
        $totalStudents = 0;
        foreach ($totalScheduleList as $key => $value) {
            $totalStudents+=$value['students'];
        }
        //本月已上课量
        $monthSchedule = 0;
        $monthScheduleList = db('schedule')->where(['camp_id'=>$campInfo['id']])->whereTime('lesson_time','m')->where('delete_time',null)->select();
        $monthSchedule = count($monthScheduleList);
        // 本月上课总人次
        $monthStudents = 0;
        foreach ($monthScheduleList as $key => $value) {
            $totalStudents+=$value['students'];
        }
        // 总营业额
        $totalBill = db('bill')->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->sum('balance_pay');
        //本月营业额
        $monthBill = db('bill')->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('pay_time','m')->sum('balance_pay');
        // 在学会员
        $monthCampStudents = db('monthly_students')->where(['camp_id'=>$campInfo['id']])->limit(2)->select();
        // 本月新增会员
        $monthNewStudents = 0;
        //本月离营学员
        $monthofflineStudents = 0;
        //在学会员
        $onlineStudents = 0;
        if (count($monthCampStudents) == 2) {
            $monthNewStudents = $monthCampStudents[0]['online_students'] - $monthCampStudents[1]['online_students'];
            $monthofflineStudents = $monthCampStudents[0]['offline_students'] - $monthCampStudents[1]['offline_students'];
            $onlineStudents = $monthCampStudents[0]['onlesson_students'];
        }elseif (count($monthCampStudents) == 1){
            $monthNewStudents = $monthCampStudents[0]['online_students'];
            $monthofflineStudents = $monthCampStudents[0]['offline_students'];
            $onlineStudents = $monthCampStudents[0]['onlesson_students'];
        }
        

    



        // 月营业额总量曲线图
        $billList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m%d') as days,goods_type")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('create_time','m')->group('days')->select();
        $month = $Time::month();
        $lessonBill = [];
        $eventBill = [];

        $dateStart = date('Ymd',$month[0]);
        $dateEnd = date('Ymd',$month[1]);
        for ($i=$dateStart; $i <= $dateEnd ; $i++) { 
            $lessonBill[] = 0;
            $eventBill[] = 0;
        }

        foreach ($billList as $key => $value) {
            $kk = $value['days'] - $dateStart;
            if($value['goods_type'] == 1){
                
                // echo "$kk------{$value['days']}---{$value['s_balance_pay']}<br/>";
                $lessonBill[$kk] = $value['s_balance_pay'];

            }elseif ($value['goods_type'] == 2) {
                $eventBill[$kk] = $value['s_balance_pay'];
            }
        }



        // 教学点分布
        $gradeCourt = db('grade')->field('sum(students) as s_students,court')->where(['status'=>1,'camp_id'=>$campInfo['id']])->group('court_id')->select();
        $gradeCourtData = [];
        foreach ($gradeCourt as $key => $value) {
            $gradeCourtData['legend'][] = $value['court'];
            $gradeCourtData['series'][] = ['value'=>$value['s_students'],'name'=>$value['court']];
        }


        // 课程购买饼图
        $lessonBuy = db('bill')->field("sum(total) as s_total,goods,goods_id")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1,'goods_type'=>1])->group('goods_id')->select();
        $lessonBuyData = [];
        foreach ($lessonBuy as $key => $value) {
            $lessonBuyData['legend'][] = $value['goods'];
            $lessonBuyData['series'][] = ['value'=>$value['s_total'],'name'=>$value['goods']];
        }


        // 年营业额折线图
        $billMonthList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m') as month,goods_type")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('create_time','y')->group('month')->select();
        $month = $Time::year();
        $lessonBillYear = [];
        $eventBillYear = [];

        $dateStartMonth = date('Ym',$month[0]);
        $dateEndMonth = date('Ym',$month[1]);
        for ($i=$dateStartMonth; $i <= $dateEndMonth ; $i++) { 
            $lessonBillYear[] = 0;
            $eventBillYear[] = 0;
        }

        foreach ($billMonthList as $key => $value) {
            $kk = $value['month'] - $dateStartMonth;
            if($value['goods_type'] == 1){
                $lessonBillYear[$kk] = $value['s_balance_pay'];

            }elseif ($value['goods_type'] == 2) {
                $eventBillYear[$kk] = $value['s_balance_pay'];
            }
        }



        // 学员总人数折线图(年)  
        $year = $Time::year();
        $yearStart = date('Ym',$year[0]);
        $yearEnd = date('Ym',$year[1]);
        $monthlyStudentsData = [0,0,0,0,0,0,0,0,0,0,0,0];
        $monthly_students = db('monthly_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->column('online_students');
        foreach ($monthly_students as $key => $value) {
            $monthlyStudentsData[$key] = $value;
        }


        $monthlyCourtStudentsData = [];
        $monthly_court_students = db('monthly_court_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->select();
        foreach ($monthly_court_students as $key => $value) {
            $monthlyCourtStudentsData[$key] = $value;
        }
        
        
        $this->assign('monthlyCourtStudentsData',json_encode($monthlyCourtStudentsData));
        $this->assign('monthlyStudentsData',json_encode($monthlyStudentsData));
        $this->assign('lessonBuyData',json_encode($lessonBuyData,true));
        $this->assign('gradeCourtData',json_encode($gradeCourtData,true));
        $this->assign('lessonBillYear',json_encode($lessonBillYear));
        $this->assign('eventBillYear',json_encode($eventBillYear));
        $this->assign('lessonBill',json_encode($lessonBill));
        $this->assign('eventBill',json_encode($eventBill));

        $this->assign('monthBill',$monthBill?$monthBill:0);
        $this->assign('totalBill',$totalBill?$totalBill:0);
        $this->assign('monthIncome',$monthIncome?$monthIncome:0);   
        $this->assign('totalIncome',$totalIncome?$totalIncome:0);
        $this->assign('monthCampStudents',$monthCampStudents?$monthCampStudents:0);
        $this->assign('totalGift',$totalGift?$totalGift:0);
        $this->assign('totalStudents',$totalStudents?$totalStudents:0);
        $this->assign('monthStudents',$monthStudents?$monthStudents:0);
        $this->assign('monthSchedule',$monthSchedule?$monthSchedule:0);
        $this->assign('totalSchedule',$totalSchedule?$totalSchedule:0);


        $this->assign('monthNewStudents',$monthNewStudents?$monthNewStudents:0);
        $this->assign('monthofflineStudents',$monthofflineStudents?$monthofflineStudents:0);
        $this->assign('onlineStudents',$onlineStudents?$onlineStudents:0);
        return view('Camp/campStatistics');
    }
}
