<?php 
namespace app\api\controller;
use app\api\controller\Base;
use think\Db;
use app\model\SportPlan as SportPlanModel;
class SportPlan extends Base{
    private $SportPlan;
    public function _initialize(){
        parent::_initialize();
        $this->SportPlan = new SportPlanModel;
    }


    // 获取运动计划主表列表带page
    public function getSportPlanListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->SportPlan->where($map)->paginate(10);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   
    // 不带page
    public function getSportPlanListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            
            $result = $this->SportPlan->where($map)->select();
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 提交计划,写入一条
    public function createSportPlanApi(){
        try{
            $data = input('post.');
            $sport_plan_id = input('param.sport_plan_id');
            if($sport_plan_id){
                $result = $this->SportPlan->save($data,$sport_plan_id);
            }else{
                $result = $this->SportPlan->save($data);
            }
            if($result){
                return json(['code'=>200,'msg'=>'提交成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'提交失败']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }





    // 添加运动日程(批量)
    public function createSportPlanScheduleListApi(){
        try {
            $sportPlanScheduleData = input('post.sportPlanScheduleData');
            $data = json_decode($sportPlanScheduleData,true);
            $SportPlanSchedule = new \app\model\SportPlanSchedule;
            $result = $SportPlanSchedule->saveAll($data);
            if($result){
                return json(['code'=>200,'msg'=>'提交成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'提交失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取运动日程(不分页)
    public function getSportPlanScheduleListApi(){
        try {
            $map = input('post.');
            $SportPlanSchedule = new \app\model\SportPlanSchedule;
            $result = $SportPlanSchedule->where($map)->paginate(100);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'获取失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}