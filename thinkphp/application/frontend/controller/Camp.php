<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CampService;
use think\Db;
class Camp extends Base{
    protected $CampService;
	public function _initialize(){
		parent::_initialize();
        $this->CampService = new CampService;
	}


    public function index() {

        return view();
    }

    public function createCamp(){

        
        return view();
    }

    public function campInfo(){
        $camp_id = input('param.camp_id');
        // 教练员
        $coachList = Db::view('grade_member','member_id')->view('coach','portraits,star','coach.member_id = grade_member.member_id')->where(['camp_id'=>$camp_id,'type'=>4])->order('star')->limit(5)->select();
        $lessonList = db('lesson')->where(['camp_id'=>1,'status'=>1])->select();
        $lessonCount = count($lessonList);
        $commentList = db('camp_comment')->where(['camp_id'=>$camp_id])->select();
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $this->assign('commentList',$commentList);
        $this->assign('lessonCount',$lessonCount);
        $this->assign('lessonList',$lessonList);
        $this->assign('coachList',$coachList);
        $this->assign('campInfo',$campInfo);
        return view();
    }

    public function campList(){
        $map = input();
        $campList = $this->CampService->campListPage($map);
        $this->assign('campList',$campList);
        return view();
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
        return view();
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
        $is_join = db('grade_member');
        return view();
    }



    // 邀请教练入驻
    public function inviteCoach(){
        return view();
    }

    // 学生的训练营
    public function campListOfStudent(){
        $member_id = $this->memberInfo['id'];
        // $actCampList = db('grade_member')->where(['member_id'=>$member_id,'type'=>1,'status'=>1])->select();
        $actCampList = Db::view('grade_member','camp_id')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo','camp.id=grade_member.camp_id')
                        ->where(['grade_member.member_id'=>$member_id,'grade_member.type'=>1,'grade_member.status'=>1])
                        ->select();
        // $restCampList = db('grade_member')->where(['member_id'=>$member_id,'type'=>1,'status'=>0])->select();
        $restCampList = Db::view('grade_member','camp_id')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo','camp.id=grade_member.camp_id')
                        ->where(['grade_member.member_id'=>$member_id,'grade_member.type'=>1,'grade_member.status'=>0])
                        ->select();
        $this->assign('actCampList',$actCampList);
        $this->assign('restCampList',$restCampList);

        return view();
    }

    // 教练的训练营
    public function campListOfCoach(){
        $member_id = $this->memberInfo['id'];
        $campList = Db::view('grade_member','camp_id')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo','camp.id=grade_member.camp_id')
                        ->where(['grade_member.member_id'=>$member_id,'grade_member.type'=>4,'grade_member.status'=>1])
                        ->select();
        $this->assign('campList',$campList);
        return view();
    }

    // 申请列表
    public function applyListOfCoach(){
        $camp_id = input('param.camp_id');
        $applyListOfCoach = Db::view('grade_member','coach_id,remarks')
                            ->view('coach','star,coach,coach_level,lesson_flow,portraits','coach.member_id=grade_member.member_id')
                            ->view('member','sex,birthday','coach.member_id=member.id')
                            ->where(['grade_member.camp_id'=>$camp_id,'grade_member.type'=>4,'grade_member.status'=>0])
                            ->select();
        // 计算年龄
        foreach ($applyListOfCoach as $key => $value) {
            $applyListOfCoach[$key]['age'] = ceil(( time() - strtotime($value['birthday']))/31536000) ;
        }
        $count = count($applyListOfCoach);
        $this->assign('count',$count);
        // dump($applyListOfCoach);die;
        $this->assign('applyListOfCoach',$applyListOfCoach);
        return view();
    }


    public function studentInfo(){

        return view();
    }

    // 没啥权限的campInfo菜单
    public function indexCamp(){

        return view();
    }

    // 管理员的camp菜单
    public function powerCamp(){
        $camp_id = input('param.camp_id');
        $member_id = $this->memberInfo['id'];
        $is_power = $this->CampService->isPower234($camp_id,$member_id);
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
        return view();
    }

    // 教练的camp菜单
    public function coachCamp(){
        $camp_id = input('param.camp_id');
        $member_id = $this->memberInfo['id'];
        $is_power = $this->CampService->isPower234($camp_id,$member_id);
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
        return view();
    }

     public function coachListOfCamp(){
        $camp_id = input('param.camp_id');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $type = input('param.type')?input('param.type'):4;
        $status = input('param.status')?input('param.status'):1;
        $map = ['grade_member.camp_id'=>$camp_id,'grade_member.type'=>$type,'grade_member.status'=>$status];
        $coachList = $this->coachService->getCoachListOfCamp($map);
        $this->assign('campInfo',$campInfo); 
        $this->assign('coachList',$coachList);
        return view();
    }
}
