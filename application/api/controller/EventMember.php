<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\EventMemberService;
use think\Db;
use think\Exception;

class EventMember extends Base{
    protected $EventMemberService;
	public function _initialize(){
		parent::_initialize();
        $this->EventMemberService = new EventMemberService;
	}

    public function getEventMemberListOfCampByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->EventMemberService->getEventMemberListOfCampByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getEventMemberListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->EventMemberService->getEventMemberListByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   
    // 获取与课程|班级|训练营相关的学生|体验生-不带page
    public function getEventMemberListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $EventMember = new \app\model\EventMember;
            $result = $EventMember->where($map)->select();
            if($result){

                return json(['code'=>200,'msg'=>'ok','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'未查到数据,请检查参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


}
