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

    public function index(){
        $coachInfo = $this->coachService->getCoachInfo(['member_id'=>$this->memberInfo['id']]);
        // 全部课时
        $totalSchedule = db('schedule')->where(['coach_id'=>$this->memberInfo['id']])->count();
        // 全部学员
        $totalStudent = db('grade_member')->distinct(true)->field('member_id')->where(['coach_id'=>$this->memberInfo['id'],'type'=>1,'status'=>1])->count();
        // 全部课程
        $totalLesson = db('lesson')->where(['coach_id'=>$this->memberInfo['id']])->count();
        // 全部班级
        $totalGrade = db('grade')->where(['coach_id'=>$this->memberInfo['id']])->count();
        //最新消息
        $messageList = db('message')->limit(10)->select();
        $this->assign('messageList',$messageList);
        $this->assign('totalLesson',$totalLesson);
        $this->assign('totalGrade',$totalGrade);
        $this->assign('totalStudent',$totalStudent);
        $this->assign('totalSchedule',$totalSchedule);
        $this->assign('coachInfo',$coachInfo);
        return view();
    }

	// 教练首页
    public function coachInfoOfCamp(){
        $coach_id = input('param.coach_id');            	
        if(!$coach_id){
            // 获取教练档案
            $coachInfo = $this->coachService->getCoachInfo(['member_id'=>$this->memberInfo['id']]);
            $coach_id = $coachInfo['id'];
            $member_id = $coachInfo['member_id'];
        }else{
            $coachInfo = $this->coachService->getCoachInfo(['id'=>$coach_id]);
            $member_id = $coachInfo['member_id'];
        }
    	//教练的班级
    	$gradeOfCoach1 = $this->gradeMemberService->getGradeOfCoach(['member_id'=>$member_id,'type'=>4,'status'=>1,'grade_id'=>['neq','']]);
        $gradeOfCoach0 = $this->gradeMemberService->getGradeOfCoach(['member_id'=>$member_id,'type'=>4,'grade_id'=>['neq','']]);
        $gradeOfCoachList = array_merge($gradeOfCoach0,$gradeOfCoach1);
        $count0 = count($gradeOfCoach0);
        $count1 = count($gradeOfCoach1);
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
        // dump($cert);
        // dump($identCert);
        //获取教练的课量
        $m = input('m')?input('m'):date('m');
        $y = input('y')?input('y'):date('Y');
        $begin_m = mktime(0,0,0,$m,1,$y);
        $end_m = mktime(23,59,59,$m,30,$y)-1;
        $begin_y = mktime(0,0,0,1,1,$y);
        $end_y = mktime(23,59,59,12,30,$y)-1;

        $scheduleOfCoachList = $this->scheduleService
                            ->getScheduleList([
                            'coach_id'=>$coach_id,
                            // 'type'=>1,
                            'lesson_time'=>['BETWEEN',[$begin_m,$end_m]]
                            ]);

        $monthScheduleOfCoach = count($scheduleOfCoachList);
        $yearScheduleOfCoachList = $this->scheduleService
                            ->getScheduleList([
                            'coach_id'=>$coach_id,
                            // 'type'=>1,
                            'lesson_time'=>['BETWEEN',[$begin_y,$end_y]]
                            ]);
        $yearScheduleOfCoach = count($yearScheduleOfCoachList); 
        //教练工资
        $SalaryInService = new \app\service\SalaryInService($member_id);
        $salaryList = $SalaryInService->getSalaryInList(['member_id'=>$member_id,'type'=>1]);
        // 平均月薪
        $averageSalaryByMonth = $SalaryInService->getAverageSalaryByMonth($member_id);
        // 平均年薪
        $averageSalaryByYear = $SalaryInService->getAverageSalaryByYear($member_id);
        // dump($salaryList);die;
        $this->assign('scheduleOfCoachList',$scheduleOfCoachList);//教练当月的课量
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
        return view();
    }

    // 教练档案
    public function coachAechives(){
        return view();
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
        $map = input();
        $coachList = $this->coachService->getCoachList($map);
        // dump($coachList);die;
        $this->assign('coachList',$coachList);
        return view();
    }

    public function coachListOfCamp(){
        $camp_id = input('param.camp_id');
        $type = input('param.type');
        $status = input('param.status');
        $map = ['grade_member.camp_id'=>$camp_id,'grade_member.type'=>$type,'grade_member.status'=>$status];
        $coachList = $this->coachService->getCoachListOfCamp($map);
        $this->assign('coachList',$coachList);
        return view();
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
            $coachInfo = $this->coachService->coachInfo(['id'=>$coach_id]);
        }else{
            $coachInfo = $this->coachService->coachInfo(['member_id'=>$this->memberInfo['id']]);
        }
        
        // 执教过多少个班级
        $gradeService = new \app\service\GradeService;
        $gradeCount = $gradeService->countGrades(['coach_id'=>$coachInfo['id'],'status'=>1]);
        // 执教过多少个学生
        $studentCount = $this->gradeMemberService->countMembers(['coach_id'=>$coachInfo['id'],'type'=>1]);
        // 执教过多少课时
        $scheduleCount = $this->scheduleService->countSchedules(['coach_id'=>$coachInfo['id'],'status'=>1]);
        //教练评论
        $commentList = db('coach_comment')->where(['coach_id'=>$coach_id])->select();
        //所属训练营
        $campList = Db::view('grade_member','camp_id')
                    ->view('camp','logo','camp.id=grade_member.camp_id')
                    ->where(['grade_member.member_id'=>$this->memberInfo['id'],'grade_member.type'=>4,'grade_member.status'=>1])
                    ->select();
        $this->assign('campList',$campList);
        $this->assign('commentList',$commentList);
        $this->assign('scheduleCount',$scheduleCount);
        $this->assign('studentCount',$studentCount);
        $this->assign('gradeCount',$gradeCount);
        $this->assign('coachInfo',$coachInfo);
        return view();
    }

    //教练员注册
    public function createCoach(){
        $referer = input('param.referer');
        $pid = input('param.pid');
        $this->assign('pid',$pid);
        $this->assign('referer',$referer);
        return view();
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
        return view();
    }
}