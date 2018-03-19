<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\ScheduleMemberService;
use think\Db;

class ScheduleMember extends Base{
    protected $ScheduleMemberService;
	public function _initialize(){
		parent::_initialize();
        $this->ScheduleMemberService = new ScheduleMemberService;
	}

    // 获取训练营下的课程
    public function getScheduleMemberListOfCampByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if (!isset($map['status'])) {
                $map['status'] = 1;
            }
            $result = $this->ScheduleMemberService->getScheduleMemberListOfCampByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getScheduleMemberListByPageApi(){
        try{
            $map = input('post.');
            $y = input('param.y');
            $m = input('param.m');
            $d = input('param.d',1);
            if($y&&$m){
                $betweenTime = getStartAndEndUnixTimestamp($y,$m,$d);
                $map['schedule_time'] = ['BETWEEN',[$betweenTime['start'],$betweenTime['end']]];
            }
            
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['user'] = ['LIKE','%'.$keyword.'%'];
            } 

            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if (!isset($map['status'])) {
                $map['status'] = 1;
            }
            $result = $this->ScheduleMemberService->getScheduleMemberListByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   
    // 获取课时-不带page
    public function getScheduleMemberListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['user'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $ScheduleMember = new \app\model\ScheduleMember;
            $result = $ScheduleMember->where($map)->select();

            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


}
