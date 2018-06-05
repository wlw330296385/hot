<?php 
namespace app\index\controller;
use app\frontend\controller\Base;
/**
* 
*/
class Apps extends Base
{
	
	public function _initialize(){
        parent::_initialize();
    }

    public function appsForm(){
    	$member_id = session('memberInfo.id');
    	$event_id = input('param.event_id');
    	$memberInfo = db('member')->where(['id'=>$member_id])->find();
    	$cert = db('cert')->where(['member_id'=>$member_id,'cert_type'=>1])->find();
    	$eventInfo = db('event')->where(['id'=>$event_id])->find();


    	$this->assign('memberInfo',$memberInfo);
    	$this->assign('cert',$cert);
    	$this->assign('eventInfo',$eventInfo);
    	return view('apps/appsForm');

    }


	// public function appsForm1(){

    	
    // 	return view('apps/appssForm1');

	// }
	
	public function appsForm1(){
		$member_id = session('memberInfo.id');
    	$event_id = input('param.event_id');
    	$memberInfo = db('member')->where(['id'=>$member_id])->find();
    	$cert = db('cert')->where(['member_id'=>$member_id,'cert_type'=>1])->find();
    	$eventInfo = db('event')->where(['id'=>$event_id])->find();


    	$this->assign('memberInfo',$memberInfo);
    	$this->assign('cert',$cert);
    	$this->assign('eventInfo',$eventInfo);
   		 return view('apps/appsForm1');
    }
}