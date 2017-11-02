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
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
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

   
    // 获取与课程|班级|训练营相关的学生|体验生-不带page
    public function getScheduleMemberListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $ScheduleMember = new \app\model\ScheduleMember;
            $result = $ScheduleMember->where($map)->select();

            if($result){
                $res = $result->toArray();
                foreach ($res as $k => $val) {
                    $temp = $ScheduleMember->where(['id' => $val['id']])->find()->getData();
                    $res[$k]['status_num'] = $temp['status'];
                    $res[$k]['type_num'] = $temp['type'];
                }
                return json(['code'=>200,'msg'=>'ok','data'=>$res]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


}
