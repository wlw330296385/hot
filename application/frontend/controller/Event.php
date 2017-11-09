<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\EventService;
class Event extends Base{
	private $EventService;
	public function _initialize(){
		parent::_initialize();
        $this->EventService = new EventService;
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        $this->assign('eventInfo',$eventInfo);
	}

    public function index() {
  
        return view('Event/index');
    }


    public function comfirmBill() {
  
        return view('Event/comfirmBill');
    }

    // 创建活动
    public function createEvent() {
        $organization_id = input('param.organization_id');
        $CampService = new \app\service\CampService;
        $campInfo = $CampService->getCampInfo(['id'=>$organization_id]);
        $isPower = $this->EventService->isPower($organization_id,$this->memberInfo['id']);
        // 我是班主任的班级
        $GradeModel = new \app\model\Grade;
        $gradeList = $GradeModel->where(['teacher_id'=>$this->memberInfo['id']])->select();


        $this->assign('gradeList',$gradeList);
        $this->assign('power',$isPower);
        $this->assign('campInfo',$campInfo);
        $this->assign('organization_id', $organization_id);
        return view('Event/createEvent');
    }

    public function eventInfo() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        $variable = 1;
        if($eventInfo['status']=='下架'){
            $variable = 2 ;
        }
        if($eventInfo['is_max'] == '已满人'){
            $variable = 3 ;
        }

        if($eventInfo['is_overdue'] == '已过期'){
            $variable = 4 ;
        }

        $this->assign('variable',$variable);
        $this->assign('eventInfo',$eventInfo);
        return view('Event/eventInfo');
    }

    public function eventInfoOfCamp() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);

        $power = $this->EventService->isPower($eventInfo['organization_type'],$eventInfo['organization_id'],$this->memberInfo['id']);

        $this->assign('power',$power);
        $this->assign('eventInfo',$eventInfo);
        return view('Event/eventInfoOfCamp');
    }

    public function eventList() {
        $target_type = input('param.target_type/d', 1);
        $this->assign('target_type', $target_type);
        return view('Event/eventList');
    }

    public function eventListOfCamp() {
        $organization_id = input('param.organization_id');



        $this->assign('organization_id', $organization_id);
        return view('Event/eventListOfCamp');
    }
    // 活动编辑
    public function updateEvent() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        if($eventInfo['member_id'] != $this->memberInfo['id']){
            $isPower = $this->EventService->isPower($eventInfo['organization_type'],$eventInfo['organization_id'],$eventInfo['organization_id'],$this->memberInfo['id']);
            if($isPower<3){
                $this->error('您没有权限');
            }
        }


        $this->assign('eventInfo',$eventInfo);
        return view('Event/updateEvent');
    }
    
    // 活动录入
    public function recordEvent() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);
        if($eventInfo['member_id'] != $this->memberInfo['id']){
            $isPower = $this->EventService->isPower($eventInfo['organization_type'],$eventInfo['organization_id'],$this->memberInfo['id']);
            if($isPower<3){
                $this->error('您没有权限');
            }
        }


        $this->assign('eventInfo',$eventInfo);
        return view('Event/recordEvent');
    }

}