<?php 
namespace app\frontend\controller;
use app\frontend\controller\Frontend;
use app\service\EventService;
class Event extends Frontend{
	private $EventService;
	public function _initialize(){
		parent::_initialize();
        $this->EventService = new EventService;
	}

    public function index() {
  
        return view('Event/index');
    }


    public function comfirmBill() {
  
        return view('Event/comfirmBill');
    }

    // 创建活动
    public function createEvent() {
        $camp_id = input('param.camp_id');
        $campService = new \app\service\CampService;
        $campInfo = $campService->getCampInfo(['id'=>$camp_id]);


        $this->assign('campInfo',$campInfo);
        $this->assign('camp_id', $camp_id);
        return view('Event/createEvent');
    }

    public function eventInfo() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);



        $this->assign('eventInfo',$eventInfo);
        return view('Event/eventInfo');
    }

    public function eventInfoOfCamp() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);



        $this->assign('eventInfo',$eventInfo);
        return view('Event/eventInfoOfCamp');
    }

    public function eventList() {
        
        return view('Event/eventList');
    }

    public function eventListOfCamp() {
        $camp_id = input('param.camp_id');



        $this->assign('camp_id', $camp_id);
        return view('Event/eventListOfCamp');
    }
    // 活动编辑
    public function updateEvent() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);



        $this->assign('eventInfo',$eventInfo);
        return view('Event/updateEvent');
    }
    
    // 活动录入
    public function recordEvent() {
        $event_id = input('param.event_id');
        $eventInfo = $this->EventService->getEventInfo(['id'=>$event_id]);



        $this->assign('eventInfo',$eventInfo);
        return view('Event/recordEvent');
    }

}