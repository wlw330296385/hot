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
                $map['camp'] = ['LIKE',$keyword];
            }
            $campList = $this->CoachService->getCoachListPage($map);
            return json($campList);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    }
}