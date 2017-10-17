<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GradeMemberService;
use think\Db;
use think\Exception;

class GradeMember extends Base{
    protected $GradeMemberService;
	public function _initialize(){
		parent::_initialize();
        $this->GradeMemberService = new GradeMemberService;
	}

    public function getGradeMemberListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->GradeMemberService->getGradeMemberListByPage($map);    
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
