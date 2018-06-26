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
        $lesson_id = input('param.lesson_id');
        $type = input('param.type',2);
        $memberInfo = db('member')->where(['id'=>$member_id])->find();
        $event_member = db('event_member')->where(['event_id'=>$event_id,'member_id'=>$this->memberInfo['id']])->find();
        if ($member_id > 0) {
            $cert = db('cert')->where(['member_id'=>$member_id,'cert_type'=>1])->find();

        } else {
            $cert = [
                'cert_no' => '',
                'photo_positive' => '',
                'cert_type' => '',
                'photo_back' => ''
            ];
        }

        if($type == 2){
            $EventService = new \app\service\EventService();
            $eventInfo = $EventService->getEventInfo(['id'=>$event_id]);
        }elseif($type == 1){
             $LessonService = new \app\service\LessonService();
             $lessonInfo = $LessonService->getLessonInfo(['id'=>$lesson_id]);
        }

        $this->assign('memberInfo',$memberInfo);
        $this->assign('cert',$cert);
        $this->assign('event_member',$event_member);
        $this->assign('eventInfo',$eventInfo);
        return view('apps/appsForm');
    }


    // 购买篮球卡券
    public function buyCouponForm(){
        $member_id = session('memberInfo.id');
        $event_id = input('param.event_id');
        $lesson_id = input('param.lesson_id');
        $memberInfo = db('member')->where(['id'=>$member_id])->find();
        $event_member = db('event_member')->where(['event_id'=>$event_id,'member_id'=>$this->memberInfo['id']])->find();
        
        $EventService = new \app\service\EventService();
        $eventInfo = $EventService->getEventInfo(['id'=>$event_id]);
        $billOrder = '2'.getOrderID(rand(0,9));
        

        $this->assign('billOrder',$billOrder);
        $this->assign('memberInfo',$memberInfo);
        $this->assign('event_member',$event_member);
        $this->assign('eventInfo',$eventInfo);
        return view('apps/buyCouponForm');
    }


}