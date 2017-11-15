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
        $campInfo = db('camp')->where(['id'=>$organization_id])->find();
         // 判读权限
        $power = $this->RecruitmentService->isPower($campInfo['id'],$this->memberInfo['id']);
        $power = $this->RecruitmentService->isPower($organization_id,$this->memberInfo['id']);
        if($power < 2){
            $this->error('您没有权限');
        }
        //获取员工列表
        $CampMember = new \app\model\CampMember;
        $staffList = $CampMember::with('member')->where(['camp_id'=>$organization_id,'status'=>1,'type'=>['gt',2]])->where('delete_time','null')->select();
        dump($staffList->toArray());die;
        $this->assign('staffList',$staffList->toArray());
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
        $CampMember = new \app\model\CampMember;
        $staffList = $CampMember::with('member')->where(['camp_id'=>$organization_id,'status'=>1,'delete_time'=>'null','type'=>['gt',2]])->select();
        // dump($staffList->toArray());die;
        $this->assign('staffList',$staffList->toArray());
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