<?php
namespace app\management\controller;

use app\management\controller\Camp;
use app\service\EventService;
class Event extends Camp {
    private $EventService; 
	public function _initialize(){
		parent::_initialize();
        $this->EventService = new EventService();
	}
    public function eventList() {
        $field = '请选择搜索关键词';
        $map = ['organization_id'=>$this->campInfo['id'],'organization_type'=>1];

        $field = input('param.field');
        $keyword = input('param.keyword');
        if($keyword == ''){
            $field = '请选择搜索关键词';
        }else{
            if($field){
                $map = [$field=>['like',"%$keyword%"]];
            }else{
                $field = '请选择搜索关键词';
                $map = function($query) use ($keyword){
                    $query->where(['title'=>['like',"%$keyword%"]]);
                };
            }
        }
       
        $eventList = db('event')->where($map)->paginate(10);
        // dump($eventList);
        $this->assign('field',$field);
        $this->assign('eventList',$eventList);    
        return view('Event/eventList');
    	
    }

    public function eventInfo(){
        $event_id = input('param.event_id');
        $map['id'] = $event_id;
        $eventInfo = $this->EventService->getEventInfo($map);

        $this->assign('eventInfo',$eventInfo);
        return  view('Event/eventInfo');
    }

    public function createEvent(){
        if(request()->isPost()){
            $data = input('post.');
            $data['member_id']=$this->management['id'];
            $data['member'] = $this->management['username'];
            $result = $this->EventService->createEvent($data);
            if($result['code'] == 200){
                $this->success($result['msg'],'/management/Event/eventList');
            }else{
                $this->error($result['msg']);
            }
        }

        return view('Event/createEvent');
    }


    public function updateEvent(){
        $event_id = input('param.event_id');
        $map['id'] = $event_id;
        $eventInfo = $this->EventService->getEventInfo($map);


        if(request()->isPost()){
            $data = input('post.');
            $id = $data['id'];

            $data['member_id']=$this->management['id'];
            $data['member'] = $this->management['username'];
            $result = $this->EventService->updateEvent($data,['id'=>$id]);
            if($result['code'] == 200){
                $this->success($result['msg'],url('management/Event/eventInfo',['event_id'=>$event_id]));
            }else{
                $this->error($result['msg']);
            }
        }


        $this->assign('eventInfo',$eventInfo);

        return view('Event/updateEvent');
    }

}
