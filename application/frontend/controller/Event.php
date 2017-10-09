<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;

class Event extends Base{
	
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {
  
        return view('Event/index');
    }


    public function comfirmBill() {
  
        return view('Event/comfirmBill');
    }

    public function createEvent() {
  
        return view('Event/createEvent');
    }

    public function eventInfo() {
  
        return view('Event/eventInfo');
    }

    public function eventInfoOfCamp() {
  
        return view('Event/eventInfoOfCamp');
    }

    public function eventList() {
  
        return view('Event/eventList');
    }

    public function eventListOfCamp() {
  
        return view('Event/eventListOfCamp');
    }

    public function updateEvent() {
  
        return view('Event/updateEvent');
    }
    

}