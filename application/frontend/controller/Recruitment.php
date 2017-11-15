<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\RecruitmentService;
use think\Db;
class Recruitment extends Base{
	public function _initialize(){
		parent::_initialize();
		$this->RecruitmentService = new RecruitmentService;
	}
	// 招募详情
    public function index() {
    	$recruitment_id = input('recruitment_id');
        $recruitmentInfo = $this->RecruitmentService->getRecruitmentInfo(['id'=>$recruitment_id]);
    	// 获取招募学生
    	$students = db('recruitment_member')->where(['recruitment_id'=>$recruitment_id,'status'=>1])->select();

    	$this->assign('recruitmentInfo',$recruitmentInfo);
        return view('Recruitment/index');
    }


    public function createRecruitment(){
    	$organization_id = input('param.organization_id');
        $lesson_id = input('param.lesson_id');
        $campInfo = db('camp')->where(['id'=>$organization_id])->find();
         // 判读权限
        $CampService = new \app\service\CampService;
        $power = $CampService->isPower($organization_id,$this->memberInfo['id']);
        if($power < 2){
            $this->error('您没有权限');
        }

        // 课程列表
        $lessonList = db('lesson')->where(['organization_id'=>$organization_id,'status'=>1])->where('delete_time','null')->select();
        //获取招募类型
        $recruitmentcateList = $this->RecruitmentService->getRecruitmentCategory();
        //获取员工列表
        $staffList = db('camp_member')->where(['organization_id'=>$organization_id,'status'=>1])->select();
        // 教练列表
        $coachlist = db('camp_member')->where(['organization_id'=>$organization_id,'status'=>1, 'type' => 2])->select();
        //场地列表
        $courtService = new \app\service\CourtService;
        //$courtList = $courtService->getCourtList(['organization_id'=>$organization_id,'status'=>1]);
        $courtList = $courtService->getCourtListOfCamp(['organization_id'=>$organization_id]);
        // 教案列表
        $PlanService = new \app\service\PlanService;
        $planList = $PlanService->getPlanList(['organization_id'=>$organization_id,'type'=>1]);
        $this->assign('delete_time',time());
        $this->assign('lessonList',$lessonList);
        $this->assign('planList',$planList);
        $this->assign('courtList',$courtList);
        $this->assign('courtListJson',json_encode($courtList));
        $this->assign('staffList',$staffList);
        $this->assign('coachlist', $coachlist);
        $this->assign('recruitmentcateList',$recruitmentcateList);
        $this->assign('campInfo',$campInfo);
    	return view('Recruitment/createRecruitment');
    }


    public function updateRecruitment(){
    	$recruitment_id = input('param.recruitment_id');
        $recruitmentInfo = $this->RecruitmentService->getRecruitmentInfo(['id'=>$recruitment_id]);
        $power = $this->RecruitmentService->isPower($recruitmentInfo['organization_id'],$this->memberInfo['id']);
        if($power < 2){
            $this->error('您没有权限');
        }
        //获取员工列表
        $staffList = db('camp_member')->where(['organization_id'=>$recruitmentInfo['organization_id'],'status'=>1])->select();
        $this->assign('delete_time',time());
        $this->assign('staffList',$staffList);
        $this->assign('recruitmentInfo',$recruitmentInfo);
    	return view('Recruitment/updateRecruitment');
    }



    public function recruitmentInfo(){
        $recruitment_id = input('recruitment_id');
        $recruitmentInfo = $this->RecruitmentService->getRecruitmentInfo(['id'=>$recruitment_id]);      
        $this->assign('recruitmentInfo',$recruitmentInfo);
        return view('Recruitment/recruitmentInfo');
    }

    public function recruitmentInfoOfCamp(){
        $recruitment_id = input('recruitment_id');
        $recruitmentInfo = $this->RecruitmentService->getRecruitmentInfo(['id'=>$recruitment_id]);
        // 判断权限
        $power = $this->RecruitmentService->isPower($organization_id,$member_id);

        $this->assign('power',$power);
        $this->assign('recruitmentInfo',$recruitmentInfo);
        return view('Recruitment/recruitmentInfoOfCamp');
    }

    // 普通招募列表
    public function recruitmentList(){
        $member_id = $this->memberInfo['id'];
        $organization_id = input('param.organization_id');
        return view('Recruitment/recruitmentList');
    }


    // 有权限的招募列表
    public function recruitmentListOfCamp(){
        $member_id = $this->memberInfo['id'];
        $organization_id = input('param.organization_id');
        // 判断权限
        $power = $this->RecruitmentService->isPower($organization_id,$member_id);

        $this->assign('power',$power);
        $this->assign('organization_id',$organization_id);
        return view('Recruitment/recruitmentListOfCamp');
    }
}