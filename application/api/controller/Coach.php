<?php 
namespace app\api\controller;
use app\api\controller\Base;
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

    public function searchCoachListApi(){
        try{
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
            $result = $this->coachService->createCoach($data);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getCoachList(){
        try{
            $map = intpu('post.');
            $coachList = $this->coachService->getCoachList($map);
            return json(['code'=>100,'msg'=>'OK','data'=>$coachList]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}