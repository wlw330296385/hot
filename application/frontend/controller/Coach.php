<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CoachService;
use app\service\GradeMemberService;
use app\service\ScheduleService;
use think\Db;
class Coach extends Base{
	protected $coachService;
    protected $gradeMemberService;
    protected $scheduleService;
	public function _initialize(){
		parent::_initialize();
		$this->coachService = new CoachService;
		$this->gradeMemberService = new GradeMemberService;
        $this->scheduleService = new ScheduleService;

	}

    // 教练主页
    public function index(){
        $coachInfo = $this->coachService->getCoachInfo(['member_id'=>$this->memberInfo['id']]);
        // 全部课时
        $totalSchedule = db('schedule')->where(['coach_id'=>$this->memberInfo['id']])->count();
        // 全部班级
        $gradeList = db('grade')->where(['coach_id'=>$this->memberInfo['id']])->column('id');
        $totalGrade = count($gradeList);
        // 全部学员
        $totalStudent = db('grade_member')->distinct(true)->field('member_id')->where(['grade_id'=>['in',$gradeList],'type'=>1,'status'=>1])->count();
        // 全部课程
        $totalLesson = db('lesson')->where(['coach_id'=>$this->memberInfo['id']])->count();
        //最新消息
        $messageList = db('message')->limit(10)->select();
        $this->assign('messageList',$messageList);
        $this->assign('totalLesson',$totalLesson);
        $this->assign('totalGrade',$totalGrade);
        $this->assign('totalStudent',$totalStudent);
        $this->assign('totalSchedule',$totalSchedule);
        $this->assign('coachInfo',$coachInfo);
        return view('Coach/index');
    }

	// 教练首页
    public function coachInfoOfCamp(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $coach_id = input('param.coach_id');
        $camp_id = input('param.camp_id');
        if(!$camp_id){
            $this->error('找不到训练营');
        }            	
        if(!$coach_id){
            // 获取教练档案
            $coachInfo = $this->coachService->getCoachInfo(['member_id'=>$member_id]);
            $coach_id = $coachInfo['id'];
        }else{
            $coachInfo = $this->coachService->getCoachInfo(['id'=>$coach_id]);
        }
    	//教练的班级
        $GradeService = new \app\service\GradeService;
    	$gradeOfCoachList = $GradeService->getGradeList(['coach_id'=>$member_id,'camp_id'=>$camp_id]);
        // 教练的证件
        $cert = db('cert')->where(['member_id'=>$member_id,'status'=>1])->select();
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
        if(empty($$coachCert)){
            $coachCert = ['photo_positive'=>'/static/frontend/images/uploadDefault.jpg','photo_back'=>'/static/frontend/images/uploadDefault.jpg'];
        }
        //获取教练的课量
        $m = input('m')?input('m'):date('m');
        $y = input('y')?input('y'):date('Y');
        $begin_m = mktime(0,0,0,$m,1,$y);
        $end_m = mktime(23,59,59,$m,30,$y)-1;
        $begin_y = mktime(0,0,0,1,1,$y);
        $end_y = mktime(23,59,59,12,30,$y)-1;

        $monthScheduleOfCoachList = $this->scheduleService
                            ->getScheduleList([
                            'coach_id'=>$member_id,
                            // 'type'=>1,
                            'camp_id'=>$camp_id,
                            'create_time'=>['BETWEEN',[$begin_m,$end_m]]
                            ]);
                         
        $monthScheduleOfCoach = count($monthScheduleOfCoachList);
        $yearScheduleOfCoachList = $this->scheduleService
                            ->getScheduleList([
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
        return view('Coach/coachInfoOfCamp');
        
    }

    // 教练档案
    public function coachAechives(){
        return view('Coach/coachAechives');
    }

     public function searchCoach(){
        $map = [];
        $keyword = input('keyword');
        // $province = input('province');
        // $city = input('city');
        // $area = input('area');
        // $map = ['province'=>$province,'city'=>$city,'area'=>$area];
        // foreach ($map as $key => $value) {
        //     if($value == ''){
        //         unset($map[$key])
        //     }
        // }
        if($keyword){
            $map['camp'] = ['LIKE',$keyword];
        }
        $result = $this->coachService->getCoachList($map);
        $this->assign('coachList',$result['data']);
        return view();
    }

    public function coachList(){
        // $map = input();
        // $coachList = $this->coachService->getCoachList($map);
        $coachList = [];
        $this->assign('coachList',$coachList);
        return view('Coach/coachList');
    }

   


    public function searchCoachListApi(){
        $map = [];
        $keyword = input('keyword');
        // $province = input('province');
        // $city = input('city');
        // $area = input('area');
        // $map = ['province'=>$province,'city'=>$city,'area'=>$area];
        // foreach ($map as $key => $value) {
        //     if($value == ''){
        //         unset($map[$key])
        //     }
        // }
        if($keyword){
            $map['camp'] = ['LIKE',$keyword];
        }
        $coachList = $this->CoachService->getCoachListPage($map);
        return json($coachList);
    }


    public function coachInfo(){
        $coach_id = input('param.coach_id');
        if($coach_id){
            $coachInfo = $this->coachService->getCoachInfo(['id'=>$coach_id]);
        }else{
            $coachInfo = $this->coachService->getCoachInfo(['member_id'=>$this->memberInfo['id']]);
        }
        
        // 全部班级
        $gradeList = db('grade')->where(['coach_id'=>$this->memberInfo['id']])->column('id');
        $gradeCount = count($gradeList);
        // 全部学员
        $studentCount = db('grade_member')->distinct(true)->field('member_id')->where(['grade_id'=>['in',$gradeList],'type'=>1,'status'=>1])->count();
        // 执教过多少课时
        $scheduleCount = $this->scheduleService->countSchedules(['coach_id'=>$coachInfo['id'],'status'=>1]);
        //教练评论
        $commentList = db('coach_comment')->where(['coach_id'=>$coach_id])->select();
        //所属训练营
        $campList = Db::view('camp_member','camp_id')
                    ->view('camp','*','camp.id = camp_member.camp_id')
                    ->where(['camp_member.member_id'=>$this->memberInfo['id'],'camp_member.type'=>2,'camp_member.status'=>1])
                    ->select();
        $myCampList = db('camp_member')->where(['type'=>['gt',2],'status'=>1,'member_id'=>$this->memberInfo['id']])->select();

        $this->assign('myCampList',$myCampList);
        $this->assign('campList',$campList);
        $this->assign('commentList',$commentList);
        $this->assign('scheduleCount',$scheduleCount);
        $this->assign('studentCount',$studentCount);
        $this->assign('gradeCount',$gradeCount);
        $this->assign('coachInfo',$coachInfo);
        return view('Coach/coachInfo');
    }

    //教练员注册
    public function createCoach(){
        return view('Coach/createCoach');
    }

    public function updateCoach(){
       // 会员刚完成注册就执行
      /*  $fast = input('param.fast');
        if ($fast) {
            //dump($this->memberInfo);
            $isCoach = db('coach')->where('member_id', $this->memberInfo['id'])->find();
            if ( !$isCoach ) {
                db('coach')->insertGetId([
                    'member_id' => $this->memberInfo['id'],
                    'create_time' => time()
                ]);
            }
        }*/
        // 会员刚完成注册就执行 end

        $coach_id = input('param.coach_id');
        if($coach_id){
            $coachInfo = $this->coachService->getCoachInfo(['id'=>$coach_id]);
        }else{
            $coachInfo = $this->coachService->getCoachInfo(['member_id'=>$this->memberInfo['id']]);
        }
        $certList = db('cert')->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>0])->select();
        $identCert = [];
        $coachCert = [];
        if($certList){
            foreach ($certList as $key => $value) {
                switch ($value['cert_type']) {
                    case '1':
                        $identCert = $value;
                        break;
                     case '3':
                        $coachCert = $value;
                        break;
                }
            }
        }
        //dump($identCert);

        $this->assign('coachInfo',$coachInfo);
        $this->assign('identCert',$identCert);
        $this->assign('coachCert',$coachCert);
        return view('Coach/updateCoach');
    }
    // 教练员注册1
    public function coachRegister1(){
        return view();
    }

    // 教练员注册1
    public function coachRegister2(){
        return view();
    }

    // 教练员注册1
    public function coachRegister3(){
        return view();
    }

    //注册成功
    public function registerSuccess(){
        return view('Coach/registerSuccess');
    }

    // 教练的训练营列表
    public function campListOfCoach(){
        $member_id = input('param.member_id')? input('param.member_id'):$this->memberInfo['id'];
        $campList = Db::view('camp_member','camp_id')
                ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo,id,total_member,total_lessons','camp.id=camp_member.camp_id')
                ->where(['camp_member.member_id'=>$member_id,'camp_member.type'=>2,'camp_member.status'=>1])
                ->select();
        $this->assign('campList',$campList);
        return view('Coach/campListOfCoach');
    }

    // 训练营下的人员
    public function coachListOfCamp(){
        $camp_id = input('param.camp_id');
        $CampService = new \app\service\CampService;
        $campInfo = $CampService->getCampInfo($camp_id);
        $type = input('param.type')?input('param.type'):2;
        $status = input('param.status')?input('param.status'):1;
        $map = ['camp_member.camp_id'=>$camp_id,'camp_member.type'=>$type,'camp_member.status'=>$status];
        $coachList = $this->coachService->getCoachListOfCamp($map);
        // dump($coachList);die;
        $this->assign('campInfo',$campInfo); 
        $this->assign('coachList',$coachList);
        return view('Coach/coachListOfCamp');
    }
}