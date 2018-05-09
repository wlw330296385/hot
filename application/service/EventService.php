<?php

namespace app\service;

use app\model\Event;
use think\Db;
use app\model\EventMember;
use app\common\validate\EventVal;
class EventService {
    private $EventModel;
    private $EventMemberModel;
    public function __construct(){
        $this->EventModel = new Event;
        $this->EventMemberModel = new EventMember;
    }


    // 获取所有活动
    public function getEventList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = Event::where($map)->order(['start'=>'desc','end'=>'asc'])->page($page,$paginate)->select();

        if($result){
            $res = $result->toArray();
            foreach ($res as $key => &$value) {
                $value['doms'] = json_decode($value['dom'],true);
                $value['event_times'] = date('Y-m-d H:i',$value['event_time']);
                $value['ends'] = date('Y-m-d H:i',$value['end']);
                $value['starts'] = date('Y-m-d H:i',$value['start']);
            }
            return $res;
        }else{
            return $result;
        }
    }
    // 获取所有活动和报名人员
    public function getEventWithEventMemberList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = Event::with('eventMember')->where($map)->order(['start'=>'desc','end'=>'asc'])->page($page,$paginate)->select();

        if($result){
            $res = $result->toArray();
            foreach ($res as $key => &$value) {
                $value['doms'] = json_decode($value['dom'],true);
                $value['event_times'] = date('Y-m-d H:i',$value['event_time']);
                $value['ends'] = date('Y-m-d H:i',$value['end']);
                $value['starts'] = date('Y-m-d H:i',$value['start']);
            }
            return $res;
        }else{
            return $result;
        }
    }

    // 分页获取活动
    public function getEventListByPage($map=[], $order='',$paginate=10){
        $result = Event::where($map)->order($order)->paginate($paginate);
        if($result){
            $res =  $result->toArray();
            foreach ($res['data'] as $key => &$value) {
                $value['doms'] = json_decode($value['dom'],true);
                $value['event_times'] = date('Y-m-d H:i',$value['event_time']);
                $value['ends'] = date('Y-m-d H:i',$value['end']);
                $value['starts'] = date('Y-m-d H:i',$value['start']);
            }
            return $res;
        }else{
            return $result;
        }
    }

    // 软删除
    public function SoftDeleteEvent($id) {
        $result = Event::destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个活动
    public function getEventInfo($map) {
        $result = Event::where($map)->find();
        if ($result){
            $res = $result->toArray();
            if($res['dom']){
                $res['doms'] = json_decode($res['dom'],true);
            }else{
                $res['doms'] = ['name'=>'默认套餐','price'=>0];
            }
            $res['status_num'] = $result->getData('status');
            $res['event_times'] = date('Y-m-d H:i',$res['event_time']);
            $res['ends'] = date('Y-m-d H:i',$res['end']);
            $res['starts'] = date('Y-m-d H:i',$res['start']);
            return $res;
        }else{
            return $result;
        }
    }




    // 编辑活动
    public function updateEvent($data,$id){
        $is_power = $this->isPower($data['organization_type'],$data['organization_id'],$data['member_id']);
        if($is_power<2){
            return ['code'=>100,'msg'=> __lang('MSG_403')];
        }
        $validate = validate('EventVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        if( isset($data['event_times']) ){
            $data['event_time'] = strtotime($data['event_times']);
        }
        if(isset($data['starts'])){
            $data['start'] = strtotime($data['starts']);
        }
        if(isset($data['ends'])){
            $data['end'] = strtotime($data['ends']);
        }
        $result = $this->EventModel->allowField(true)->save($data,['id'=>$id]);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 新增活动
    public function createEvent($data){
        // 查询是否有权限
        $is_power = $this->isPower($data['organization_type'],$data['organization_id'],$data['member_id']);
        if($is_power<2){
            return ['code'=>100,'msg'=> __lang('MSG_403')];
        }
        if(isset($data['starts'])){
            $data['start'] = strtotime($data['starts']);
        }
        if(isset($data['ends'])){
            $data['end'] = strtotime($data['ends']);
        }
        $validate = validate('EventVal');
        if(!$validate->scene('add')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->EventModel->allowField(true)->save($data);
        if($result){
            db('camp')->where(['id'=>$data['organization_id']])->setInc('total_events');
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->EventModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 参加活动
    public function joinEvent($event_id,$member_id,$member,$total){
        $eventInfo = $this->getEventInfo(['id'=>$event_id]);
        if($eventInfo['status']!= '正常'){
            return ['msg'=>"该活动已{$eventInfo['status']},不可再参与", 'code' => 100];
        }
        // 查询是否已报名
        // $is_join = $this->EventMemberModel->get(['id'=>$event_id,'member_id'=>$member_id]);
        // if($is_join){
        //     return ['msg'=>"您已报名,不可重复报名", 'code' => 100];
        // }
        // 检测是否已满人
        if($eventInfo['is_max'] == -1){
             return ['msg'=>"该活动已满人,不可再参与", 'code' => 100];   
        }

        if(($eventInfo['max']-$eventInfo['participator'])<$total){
            return ['msg'=>"可参与人数小于$total,请重新选择人数", 'code' => 100];   
        }
        // 检测是否已结束
        if(time() > $eventInfo['end']){
             return ['msg'=>"该活动已结束,不可再参与", 'code' => 100];   
        }

        $result = $this->EventModel->where(['id'=>$event_id])->setInc('participator',$total);
        // 更改状态
        if($eventInfo['max'] <= ($eventInfo['participator']+$total)){
            $this->EventModel->save(['is_max'=>-1],['id'=>$event_id]); 
        }
        // 发送个人模板消息
        $MessageService = new \app\service\MessageService;
        if($eventInfo['is_free'] == 1){
            $MessageData = [
                "touser" => session('memberInfo.openid'),
                "template_id" => config('wxTemplateID.eventBook'),
                "url" => url('frontend/event/eventInfo',['event_id'=>$event_id],'',true),
                "topcolor"=>"#FF0000",
                "data" => [
                    'first' => ['value' => "{$member}已成功报名{$eventInfo['event']}。"],
                    'keyword1' => ['value' => $eventInfo['event']],
                    'keyword2' => ['value' => $eventInfo['starts'].'至'.$eventInfo['ends']],
                    'keyword3' => ['value' => $eventInfo['location']],
                    'keyword4' => ['value' => "点击此消息查看"],
                    'remark' => ['value' => '篮球管家']
                ]
            ];
        }else{
            $MessageData = [
                "touser" => session('memberInfo.openid'),
                "template_id" => config('wxTemplateID.eventJoin'),
                "url" => url('frontend/bill/billList',['event_id'=>$event_id],'',true),
                "topcolor"=>"#FF0000",
                "data" => [
                    'first' => ['value' => "尊敬的{$member}，您已成功报名{$eventInfo['event']}。"],
                    'keyword1' => ['value' => $member],
                    'keyword2' => ['value' => $eventInfo['event']],
                    'keyword3' => ['value' => $eventInfo['starts'].'至'.$eventInfo['ends']],
                    'keyword4' => ['value' => $total],
                    'keyword5' => ['value' =>$total*$eventInfo['price']],
                    'remark' => ['value' => '点击此消息查看[活动详情],具体订单信息请查看[我的订单]']
                ]
            ];
        }
        $saveData1 = [
                        'title'=>"[{$eventInfo['event']}]报名成功",
                        'content'=>$member."报名活动成功",
                        'url'=>url('frontend/event/eventInfo',['event_id'=>$event_id],'',true),
                        'member_id'=>$member_id
                    ];
        $saveData2 = [
                        'title'=>"[{$eventInfo['event']}]报名成功",
                        'content'=>$member."报名活动成功",
                        'url'=>url('frontend/event/eventInfoOfCamp',['event_id'=>$event_id],'',true),
                        'member_id'=>$eventInfo['member_id']
                    ];
        // 发布者的member
        $memberInfo = db('member')->where(['id'=>$eventInfo['member_id']])->find();
        $MessageData2 = [
                "touser" => $memberInfo['openid'],
                "template_id" => config('wxTemplateID.eventBook'),
                "url" => url('frontend/event/eventInfoOfCamp',['event_id'=>$event_id],'',true),
                "topcolor"=>"#FF0000",
                "data" => [
                    'first' => ['value' => "{$member}已成功报名{$eventInfo['event']}。"],
                    'keyword1' => ['value' => $eventInfo['event']],
                    'keyword2' => ['value' => $eventInfo['starts'].'至'.$eventInfo['ends']],
                    'keyword3' => ['value' => $eventInfo['location']],
                    'keyword4' => ['value' => "点击此消息查看"],
                    'remark' => ['value' => '篮球管家']
                ]
            ];
        $MessageService->sendMessageMember($member_id,$MessageData,$saveData1);   //发给报名的人
        $MessageService->sendMessageMember($eventInfo['member_id'],$MessageData2,$saveData2);  //发给发布者        
        if($result){
            return ['msg'=>"报名成功", 'code' => 200];
        }else{
            return ['msg'=>"报名失败", 'code' => 100];
        }
        
    }


    //关联表的更新
    public function saveAllMmeber($memberData){
        //参加活动的人员
        $result = $this->EventMemberModel->saveAll($memberData);
        if($result){
            return ['code'=>200,'msg'=>__lang('MSG_200'),'data'=>$result];
        }else{
            return ['code'=>100,'msg'=>$this->EventMemberModel->getError()];
        }
    }

    // 活动权限
    public function isPower($organization_type,$organization_id,$member_id){
        switch ($organization_type) {
            case '1':
                 $is_power = db('camp_member')
                    ->where([
                        'camp_id'   =>$organization_id,
                        'status'    =>1,
                        'member_id'  =>$member_id,
                        ])
                    ->value('type');
                break;
            case '2':
                 //学校权限
                break;
            default:
                # code...
                break;
        }
       

        return $is_power?$is_power:0;
    }

    // 修改活动上架/下架状态 2017/09/28
    public function updateEventStatus($Eventid, $status) {
        $model = new Event();
        $res = $model->update(['id' => $Eventid, 'status' => $status]);
        if (!$res) {
            return [ 'code' => 100, 'msg' => __lang('MSG_400'), 'data' => $model->getError() ];
        } else {
            return [ 'code' => 200, 'msg' => __lang('MSG_200'), 'data' => $res ];
        }
    }
}

