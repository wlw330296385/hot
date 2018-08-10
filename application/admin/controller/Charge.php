<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\ChargeService;
class Charge extends Backend {
	private $ChargeService;
	public function _initialize(){
		parent::_initialize();
		$this->ChargeService = new ChargeService;
	}
    public function index() {

    	
    }

    public function chargeList(){
    	$charge_order = input('param.charge_order');
    	$member = input('param.member');
    	$type = input('param.type');
        $create_time = input('param.create_time');

    	$map = [];
    	if($type){
    		$map['type'] = $type;
    	}
    	if($member){
    		$map['member'] = ['like',"%$member%"];
    	}
    	if($charge_order){
    		$map['charge_order'] = $charge_order;
    	}
        if($create_time){
            $c_t = explode(' - ', $create_time);
            $s = strtotime($c_t[0]);
            $e = strtotime($c_t[1]);
            $map['create_time'] = ['between',[$s,$e]];
        }
    	$chargeList = $this->ChargeService->getChargeListbyPage($map);

    	$this->assign('chargeList',$chargeList);
    	$this->assign('member',$member);
    	return view('Charge/chargeList');
    }
}
