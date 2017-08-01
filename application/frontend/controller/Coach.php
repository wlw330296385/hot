<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CoachService;
use app\service\GradeMemberService;
use app\service\ScheduleService;
class Coach extends Base{
	protected $coachService;
	public function _initialize(){
		parent::_initialize();
		$this->coachService = new CoachService;
		$this->gradeMemberService = new GradeMemberService;
        $this->scheduleService = new ScheduleService;

	}

	// 教练首页
    public function index(){
        $coach_id = input('coach_id');
    	// 获取教练档案
    	$coachInfo = $this->coachService->getCoachInfo(['member_id'=>$coach_id]);
    	// dump($coachInfo);
    	//教练的班级
    	$gradeOfCoach1 = $this->gradeMemberService->getGradeOfCoach(['member_id'=>$coach_id,'type'=>4,'status'=>1,'grade_id'=>['neq','']]);
        $gradeOfCoach0 = $this->gradeMemberService->getGradeOfCoach(['member_id'=>$coach_id,'type'=>4,'grade_id'=>['neq','']]);
        $gradeOfCoach = array_merge($gradeOfCoach0,$gradeOfCoach1);
        $count0 = count($gradeOfCoach0);
        $count1 = count($gradeOfCoach1);
        
        //获取教练的课量
        $m = input('m')?input('m'):date('m');
        $y = input('y')?input('y'):date('Y');
        $begin_m = mktime(0,0,0,$m,1,$y);
        $end_m = mktime(23,59,59,$m,30,$y)-1;
        $begin_y = mktime(0,0,0,1,1,$y);
        $end_y = mktime(23,59,59,12,30,$y)-1;

        $scheduleOfCoach = $this->scheduleService
                            ->getScheduleList([
                            'coach_id'=>$coach_id,
                            // 'type'=>1,
                            'lesson_time'=>['BETWEEN',[$begin_m,$end_m]]
                            ]);
        // echo 3;
        $monthScheduleOfCoach = count($scheduleOfCoach);
        $yearScheduleOfCoachList = $this->scheduleService
                            ->getScheduleList([
                            'coach_id'=>$coach_id,
                            // 'type'=>1,
                            'lesson_time'=>['BETWEEN',[$begin_y,$end_y]]
                            ]);
        $yearScheduleOfCoach = count($yearScheduleOfCoachList); 
        //教练工资
        
        dump($scheduleOfCoach);
        echo '班级数量'.$count0;
        echo '<br />';
        echo '全部班级数量'.$count1;
        dump($gradeOfCoach);die;
        return view();
    }



}