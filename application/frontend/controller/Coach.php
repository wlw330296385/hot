<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CoachService;
use app\service\GradeMemberService;
use app\service\ScheduleService;
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
    public function coachInfo(){
        $coach_id = input('coach_id');
    	// 获取教练档案
    	$coachInfo = $this->coachService->getCoachInfo(['member_id'=>$coach_id]);
    	//教练的班级
    	$gradeOfCoach1 = $this->gradeMemberService->getGradeOfCoach(['member_id'=>$coach_id,'type'=>4,'status'=>1,'grade_id'=>['neq','']]);
        $gradeOfCoach0 = $this->gradeMemberService->getGradeOfCoach(['member_id'=>$coach_id,'type'=>4,'grade_id'=>['neq','']]);
        $gradeOfCoachList = array_merge($gradeOfCoach0,$gradeOfCoach1);
        $count0 = count($gradeOfCoach0);
        $count1 = count($gradeOfCoach1);
        
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
        $this->assign('scheduleOfCoachList',$scheduleOfCoachList);//教练当月的课量
        $this->assign('monthScheduleOfCoach',$monthScheduleOfCoach);//当月课量数量
        $this->assign('gradeOfCoachList',$gradeOfCoachList);//教练班级
        $this->assign('yearScheduleOfCoachList',$yearScheduleOfCoachList);//当年课量
        $this->assign('yearScheduleOfCoach',$yearScheduleOfCoach);//当年课量数量
        $this->assign('coachInfo',$coachInfo);
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
        $result = $this->CoachService->getCoachList($map);
        $this->assign('campList',$result['data']);
        return view();
    }

    public function searchCoachList(){
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
        $campList = $this->CoachService->getCoachListPage($map);
        return json($campList);
    }
}