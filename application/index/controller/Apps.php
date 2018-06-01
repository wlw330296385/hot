<?php 
namespace app\index\controller;
use think\Controller;
/**
* 
*/
class Apps extends Controller
{
	
	public function _initialize(){

    }

    public function appsForm(){
    	$member_id = input('param.member_id');
    	$event_id = input('param.event_id');
    	$memberInfo = db('member')->where(['id'=>$member_id])->find();
    	$cert = db('cert')->where(['member_id'=>$member_id,'cert_type'=>1])->find();
    	$eventInfo = db('event')->where(['id'=>$event_id])->find();


    	$this->assign('memberInfo',$memberInfo);
    	$this->assign('cert',$cert);
    	$this->assign('eventInfo',$eventInfo);
    	return view('apps/appsForm');

    }


	public function appsForm1(){

    	
    	return view('apps/appssForm1');

    }
}