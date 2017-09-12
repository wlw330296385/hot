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
        // 最新消息
        $member_id = $this->memberInfo['id'];
        $messageList = db('message')->page(1,10)->select();
        $campList = db('camp_member')->where(['member_id'=>$member_id,'status'=>1])->select();

        $this->assign('campList',$campList);
        $this->assign('messageList',$messageList);
        return view('Camp/index');
    }

    public function createCamp(){

        
        return view('Camp/createCamp');
    }

    public function campInfo(){
        $camp_id = input('param.camp_id');
        // 教练员
        $coachList = Db::view('camp_member','member_id')
                    ->view('coach','portraits,star','coach.member_id = camp_member.member_id')
                    ->where(['camp_id'=>$camp_id,'type'=>2])
                    ->order('coach.star')
                    ->limit(5)
                    ->select();
        $lessonList = db('lesson')->where(['camp_id'=>1,'status'=>1])->select();
        $lessonCount = count($lessonList);
        $commentList = db('camp_comment')->where(['camp_id'=>$camp_id])->select();
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $this->assign('commentList',$commentList);
        $this->assign('lessonCount',$lessonCount);
        $this->assign('lessonList',$lessonList);
        $this->assign('coachList',$coachList);
        $this->assign('campInfo',$campInfo);
        return view('Camp/campInfo');
    }

    public function campList(){
        $map = input();
        $campList = $this->CampService->campListPage($map);
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
        $campList = Db::view('camp_member','camp_id,member_id')
                        ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo','camp.id=camp_member.camp_id')
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

     public function coachListOfCamp(){
        $camp_id = input('param.camp_id');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $type = input('param.type')?input('param.type'):2;
        $status = input('param.status')?input('param.status'):1;
        $map = ['camp_member.camp_id'=>$camp_id,'camp_member.type'=>$type,'camp_member.status'=>$status];
        $coachList = $this->coachService->getCoachListOfCamp($map);
        $this->assign('campInfo',$campInfo); 
        $this->assign('coachList',$coachList);
        return view('Camp/coachListOfCamp');
    }

    public function campSetting(){
        $camp_id = input('param.camp_id');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        $is_power = $this->CampService->isPower($camp_id,$this->memberInfo['id']);
        if($is_power < 4){
            $this->error('您没有权限');
        }
        // 营业执照
        $campCert = [];
        $memberCert = [];
        $otherCert = [];
        $certList = db('cert')->where(['camp_id'=>$camp_id])->select();
        foreach ($certList as $key => $value) {
            switch ($value['cert_type']) {
                case '1':
                    $memberCert = $value;
                    break;
                case '4':
                    $campCert = $value;
                    break;
                default:
                    $otherCert[] = $value;
                    break;
            }
                
                

        }
        $this->assign('memberCert',$memberCert);
        $this->assign('otherCert',$otherCert);
        $this->assign('campCert',$campCert);
        $this->assign('campInfo',$campInfo); 
        return view('camp/campSetting');
    }
}
