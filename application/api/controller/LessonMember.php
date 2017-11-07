<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\LessonMemberService;
use think\Db;

class LessonMember extends Base{
    protected $LessonMemberService;
	public function _initialize(){
		parent::_initialize();
        $this->LessonMemberService = new LessonMemberService;
	}

    public function getLessonMemberListOfCampByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->LessonMemberService->getLessonMemberListOfCampByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getLessonMemberListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->LessonMemberService->getLessonMemberListByPage($map);    
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
    public function getLessonMemberListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $LessonMember = new \app\model\LessonMember;
            $result = $LessonMember->where($map)->select();
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 查询没有分班的学生
    public function getOutJoinGradeMmeberListByPage(){
        try{
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
