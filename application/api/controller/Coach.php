<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CoachService;
use app\service\GradeMemberService;
use app\service\ScheduleService;
class Coach extends Frontend{
	protected $coachService;
	public function _initialize(){
		parent::_initialize();
		$this->coachService = new CoachService;
		$this->gradeMemberService = new GradeMemberService;
        $this->scheduleService = new ScheduleService;

	}

    // 搜索教练
    public function searchCoachListApi(){
        try{
            $map = [];
            $keyword = input('param.keyword');
            $province = input('param.province');
            $city = input('param.city');
            $area = input('param.area');
            $sex = input('param.sex');
            $map = ['province'=>$province,'city'=>$city,'area'=>$area];
            foreach ($map as $key => $value) {
                if($value == ''){
                    unset($map[$key]);
                }
            }
            if($sex){
                $map['sex'] = $sex;
            }
            if($keyword){
                $map['coach'] = ['LIKE','%'.$keyword.'%'];
            }
            $coachList = $this->coachService->getCoachList($map);
            if($coachList){
                return json(['code'=>100,'msg'=>'OK','data'=>$coachList]);
            }else{
                return json(['code'=>100,'msg'=>'OK','data'=>'']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    public function createCoachApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            if($data['pid']){
                
            }
            $result = $this->coachService->createCoach($data);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updateCoachApi(){
        try{
            $data = input('post.');
            $coach_id = input('param.coach_id');
            if(!$coach_id){
                return json(['code'=>200,'msg'=>'找不到教练信息']);
            }
            $result = $this->coachService->updateCoach($data,$coach_id);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getCoachListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $coachList = $this->coachService->getCoachList($map,$page);
            return json(['code'=>100,'msg'=>'OK','data'=>$coachList]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取教练下的训练营
    public function campListOfCaochApi(){
        try{
            $member_id = input('param.member_id')? input('param.member_id'):$this->memberInfo['id'];
            $campList = Db::view('grade_member','camp_id')
                    ->view('camp','camp,act_member,finished_lessons,star,province,city,area,logo,id,total_member,total_lessons','camp.id=grade_member.camp_id')
                    ->where(['grade_member.member_id'=>$member_id,'grade_member.type'=>4,'grade_member.status'=>1])
                    ->select();
            return json(['code'=>100,'msg'=>'OK','data'=>$campList]);        
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}