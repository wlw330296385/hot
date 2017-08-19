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
    	$a = input();
    	$b = ['b'=>123];
    	$c = array_merge($a,$b);
    	dump($c);
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
        $commemtList = db('camp_comment')->where(['camp_id'=>$camp_id])->select();
        $campInfo = $this->CampService->CampOneById($camp_id);
        $this->assign('commemtList',$commemtList);
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

    public function campListOfCaoch(){
        $coach_id = input('param.coach_id');
        $campList = Db::view('grade_member','camp_id')
                ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo,id,total_member,total_lessons','camp.id=grade_member.camp_id')
                ->where(['grade_member.member_id'=>$coach_id,'grade_member.type'=>4,'grade_member.status'=>1])
                ->select();
        $this->assign('campList',$campList);
        return view();
    }

    public function searchCamp(){
        $keyword = input('keyword');
        $province = input('province');
        $city = input('city');
        $area = input('area');
        $map = ['province'=>$province,'city'=>$city,'area'=>$area];
        // dump($map);die;
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
        $data = input('get.');
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
    public function studentCampList(){
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


    // 申请列表
    public function applyListOfCoach(){
        $camp_id = input('param.camp_id');
        $applyListOfCoach = Db::view('grade_member','coach_id')
                            ->view('coach','star,coach,coach_level,lesson_flow,portraits','coach.member_id=grade_member.member_id')
                            ->view('member','sex,birthday','coach.member_id=member.id')
                            ->where(['grade_member.camp_id'=>$camp_id,'grade_member.type'=>4,'grade_member.status'=>0])
                            ->select();
        // 计算年龄
        foreach ($applyListOfCoach as $key => $value) {
            $applyListOfCoach[$key]['age'] = ceil(( time() - strtotime($value['birthday']))/31536000) ;
        }

        // dump($applyListOfCoach);die;
        $this->assign('applyListOfCoach',$applyListOfCoach);
        return view();
    }


    public function studentInfo(){

        return view();
    }
}
