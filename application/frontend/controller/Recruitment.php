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
    	$organization_id = input('param.camp_id');
        $lesson_id = input('param.lesson_id');
        $campInfo = db('camp')->where(['id'=>$organization_id])->find();
         // 判读权限
        $CampService = new \app\service\CampService;
        $is_power = $CampService->isPower($organization_id,$this->memberInfo['id']);
        if($is_power < 2){
            $this->error('您没有权限');
        }

        // 课程列表
        $lessonList = db('lesson')->where(['camp_id'=>$organization_id,'status'=>1])->where('delete_time','null')->select();
        //获取招募类型
        $recruitmentcateList = $this->RecruitmentService->getRecruitmentCategory();
        //获取员工列表
        $staffList = db('camp_member')->where(['camp_id'=>$organization_id,'status'=>1])->select();
        // 教练列表
        $coachlist = db('camp_member')->where(['camp_id'=>$organization_id,'status'=>1, 'type' => 2])->select();
        //场地列表
        $courtService = new \app\service\CourtService;
        //$courtList = $courtService->getCourtList(['camp_id'=>$organization_id,'status'=>1]);
        $courtList = $courtService->getCourtListOfCamp(['camp_id'=>$organization_id]);
        // 教案列表
        $PlanService = new \app\service\PlanService;
        $planList = $PlanService->getPlanList(['camp_id'=>$organization_id,'type'=>1]);
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
        // 判读权限
        $CampService = new \app\service\CampService;
        $is_power = $CampService->isPower($recruitmentInfo['camp_id'],$this->memberInfo['id']);
        if($is_power < 2){
            $this->error('您没有权限');
        }
        //获取招募类型
        $recruitmentcateList = $this->RecruitmentService->getRecruitmentCategory();
        //获取员工列表
        $staffList = db('camp_member')->where(['camp_id'=>$recruitmentInfo['camp_id'],'status'=>1])->select();
        //场地列表
        $courtService = new \app\service\CourtService;
        $courtList = $courtService->getCourtList(['camp_id'=>$recruitmentInfo['camp_id'],'status'=>1]);
    	// 获取招募学生
    	$students = $this->RecruitmentService->getRecruitmentMemberList($recruitment_id);

        // 教案列表
        $PlanService = new \app\service\PlanService;
        $planList = $PlanService->getPlanList(['camp_id'=>$recruitmentInfo['camp_id'],'type'=>1]);
        // dump($recruitmentInfo);die;
        $this->assign('delete_time',time());
        $this->assign('planList',$planList);
        $this->assign('courtList',$courtList);
        $this->assign('courtListJson',json_encode($courtList));
        $this->assign('staffList',$staffList);
        $this->assign('recruitmentcateList',$recruitmentcateList);
        $this->assign('recruitmentInfo',$recruitmentInfo);
        $this->assign('students',$students);
    	return view('Recruitment/updateRecruitment');
    }



    public function recruitmentInfo(){
        $recruitment_id = input('recruitment_id');
        $recruitmentInfo = $this->RecruitmentService->getRecruitmentInfo(['id'=>$recruitment_id]);      
        // 招募同学
        $studentList = $this->RecruitmentService->getRecruitmentMemberList($recruitment_id);
        $this->assign('studentList',$studentList);
        $this->assign('recruitmentInfo',$recruitmentInfo);
        return view('Recruitment/recruitmentInfo');
    }

    public function recruitmentInfoOfCamp(){
        $recruitment_id = input('recruitment_id');
        $recruitmentInfo = $this->RecruitmentService->getRecruitmentInfo(['id'=>$recruitment_id]);
        // 招募同学
        $students = $this->RecruitmentService->getRecruitmentMemberList($recruitment_id);
        $this->assign('students',$students);
        $this->assign('recruitmentInfo',$recruitmentInfo);
        $this->assign('updateRecruitment', 1);
        return view('Recruitment/recruitmentInfoOfCamp');
    }

    // 普通招募列表
    public function recruitmentList(){
        $member_id = $this->memberInfo['id'];
        $organization_id = input('param.camp_id');
        $recruitmentList = Db::view('recruitment','recruitment,id,students,recruitmentcate,status')
                    ->view('recruitment_member','recruitment_id,camp_id,member_id','recruitment_member.recruitment_id=recruitment.id')
                    ->where(['recruitment_member.status'=>1])
                    ->where(['recruitment_member.camp_id'=>$organization_id])
                    ->where(['recruitment.camp_id'=>$organization_id])
                    ->where('recruitment.delete_time',null)
                    ->order('recruitment_member.id desc')
                    ->select();
        $countMyRecruitment = 0;
        foreach ($recruitmentList as $key => $value) {
                       if($value['member_id'] == $member_id){
                        $countMyRecruitment++;
                       }
                    }            
        $count = count($recruitmentList);
        $this->assign('countMyRecruitment',$countMyRecruitment);
        $this->assign('recruitmentList',$recruitmentList);
        $this->assign('count',$count);
        return view('Recruitment/recruitmentList');
    }


    // 有权限的招募列表
    public function recruitmentListOfCamp(){
        $member_id = $this->memberInfo['id'];
        $organization_id = input('param.camp_id');
        $map1 = ['camp_id'=>$organization_id,'status'=>1];
        $map0 = ['camp_id'=>$organization_id,'status'=>0]; 
        // 我的招募
        $recruitmentList = $this->RecruitmentService->getRecruitmentList(['camp_id'=>$organization_id]);

        $myRecruitmentList = $this->RecruitmentService->getRecruitmentList(['camp_id'=>$organization_id,'coach_id'=>$member_id]);
        $myCount = count($myRecruitmentList);
        $recruitmentListCount = count($recruitmentList);
        $this->assign('camp_id',$organization_id);
        $this->assign('recruitmentList',$recruitmentList);
        $this->assign('recruitmentListCount',$recruitmentListCount);
        $this->assign('myRecruitmentList',$myRecruitmentList);
        $this->assign('myCount',$myCount);
        return view('Recruitment/recruitmentListOfCamp');
    }
}