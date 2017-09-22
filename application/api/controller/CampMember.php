<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampService;
use think\Db;

class CampMember extends Base{
    protected $CampService;
	public function _initialize(){
		parent::_initialize();
        $this->CampService = new CampService;
	}

    // 关注训练营
    public function focusApi(){
        $type = input('param.type');
        $camp_id = input('param.camp_id');
        $remarks = input('param.remarks');
        $campInfo = $this->CampService->getCampInfo($camp_id);
        if(!$campInfo){
            return json(['code'=>200,'msg'=>'不存在此训练营']);
        }
        if(!$type || $type>3 || $type<-1){
            return json(['code'=>200,'msg'=>'不存在这个身份']);
        }
        //是否已存在身份
        $isType = db('camp_member')->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>$camp_id,'status'=>1])->find();
        if($isType){
            return json(['code'=>200,'msg'=>'你已经是训练营的一员']);
        }
        $result = db('camp_member')->insert(['camp_id'=>$campInfo['id'],'camp'=>$campInfo['camp'],'member_id'=>$this->memberInfo['id'],'member'=>$this->memberInfo['member'],'type'=>-1,'status'=>1,'create_time'=>time()]);
        $msg = '你已经成为该训练营的粉丝!';
        if($result){
            return json(['code'=>100,'msg'=>$msg]);
        }else{
            return json(['code'=>200,'msg'=>'申请失败']);
        }
    }

    // 申请成为训练营的某个身份
    public function applyApi(){
        try{
            $type = input('param.type');
            $camp_id = input('param.camp_id');
            $remarks = input('param.remarks');
            $campInfo = $this->CampService->getCampInfo($camp_id);
            if(!$campInfo){
                return json(['code'=>200,'msg'=>'不存在此训练营']);
            }
            if(!$type ||$type>3 || $type<-1){
                return json(['code'=>200,'msg'=>'不存在这个身份']);
            }
            //是否已存在身份
            $isType = db('camp_member')->where(['member_id'=>$this->memberInfo['id'],'camp_id'=>$camp_id])->find();
            if($isType){
                if($isType['status'] == 1) {
                    return json(['code'=>200,'msg'=>'你已经是训练营的一员']);
                } else {
                    return json(['code'=>200,'msg'=>'你已申请加入训练营,请等待审核']);
                }
            }
            $result = db('camp_member')->insert(['camp_id'=>$campInfo['id'],'camp'=>$campInfo['camp'],'member_id'=>$this->memberInfo['id'],'member'=>$this->memberInfo['member'],'type'=>$type,'status'=>0,'create_time'=>time()]);
            if($result){
                return json(['code'=>100,'msg'=>'申请成功']);
            }else{
                return json(['code'=>200,'msg'=>'申请失败']);
            }
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    // 训练营人员审核
    public function ApproveApplyApi(){
        try{
            $id = input('param.id');
            $status = input('param.status');
            if(!$id || !$status || ($status!=1|| $status!=-1)){
                return json(['code'=>200,'msg'=>'请正确传参']);
            }
            $campMemberInfo = db('camp_member')->where(['id'=>$id,'status'=>0])->find();
            if(!$campMemberInfo){
                return json(['code'=>200,'msg'=>'不存在该申请']);
            }
            $isPower = $this->CampService->isPower($campMemberInfo['camp_id'],$this->memberInfo['id']);

            if($isPower<3 && $type>2){
                return json(['code'=>200,'msg'=>'您没有这个权限']);
            }

            $result = db('camp_member')->where(['id'=>$id])->update(['status'=>1]);
            if($result){
                return json(['code'=>100,'msg'=>'操作成功']);
            }else{
                return json(['code'=>200,'msg'=>'操作失败']);
            }
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }  
    }



    //训练营人员变更
    public function modifyApi(){
        try{
            $id = input('param.id');
            $type = input('param.type');
            if(!$id || !$type || ($type!=2|| $type!=5||$type!=3)){
                return json(['code'=>200,'msg'=>'请正确传参']);
            }

            $campMemberInfo = db('camp_member')->where(['id'=>$id,'status'=>1])->find();
            if(!$campMemberInfo){
                return json(['code'=>200,'msg'=>'不存在该人员']);
            }
            $isPower = $this->CampService->isPower($campMemberInfo['camp_id'],$this->memberInfo['id']);

            if($isPower<4){
                return json(['code'=>200,'msg'=>'您没有这个权限']);
            }

            $result = db('camp_member')->where(['id'=>$id])->update(['type'=>$type]);
            if($result){
                return json(['code'=>100,'msg'=>'操作成功']);
            }else{
                return json(['code'=>200,'msg'=>'操作失败']);
            }
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }  
    }
   
    // 获取一条记录
    public function getCampMemberApi(){
        try{
            $camp_id = input('param.camp_id');
            $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
            $CampMember =new  \app\model\CampMember;
            $result = $CampMember->where(['member_id'=>$member_id,'camp_id'=>$camp_id])->find();
            if($result){
                return json(['code'=>100,'msg'=>'OK','data'=>$result]);
            }else{
                return json(['code'=>200,'msg'=>'查询失败,请正确传参']);
            }
            
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        } 
    }


    // 获取有教练身份的训练营员工
    public function getCoachListApi(){
        try{
            $camp_id = input('param.camp_id');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $result = Db::view('camp_member','camp_id')
                    ->view('coach','*','coach.member_id=camp_member.member_id')
                    ->where(['camp_member.status'=>1,'camp_member.camp_id'=>$camp_id])
                    ->where(['camp_member.type'=>['egt',2]])
                    ->where(['coach.coach'=>['like','%'.$keyword.'%'],'status'=>1])
                    ->select();
            }else{
                $result = Db::view('camp_member','camp_id')
                    ->view('coach','*','coach.member_id=camp_member.member_id')
                    ->where(['camp_member.status'=>1,'camp_member.camp_id'=>$camp_id])
                    ->where(['camp_member.type'=>['egt',2]])
                    ->select();
            }
            
            return json(['code'=>100,'msg'=>'OK','data'=>$result]);        
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


}
