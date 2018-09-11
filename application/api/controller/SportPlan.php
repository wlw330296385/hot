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
            if($data['starts']){
                $data['start'] = strtotime($data['starts']);
            }

            if($data['ends']){
                $data['end'] = strtotime($data['ends'])+86399;
            }
            $data['period'] = ($data['end']-$data['start'])/86400;

            $sport_plan_id = input('param.sport_plan_id');
            if($sport_plan_id){
                $result = $this->SportPlan->save($data,$sport_plan_id);
            }else{
                $result = $this->SportPlan->save($data);
            }
            if($result){
                return json(['code'=>200,'msg'=>'提交成功','data'=>$this->SportPlan->id]);
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
            $finalArray = array();
            foreach ($data as $row) {
                $row["sport_time"] = strtotime($row["sport_time"]);
                array_push($finalArray, $row);
            }
            $SportPlanSchedule = new \app\model\SportPlanSchedule;
            $result = $SportPlanSchedule->saveAll($finalArray);
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
            $result = $SportPlanSchedule->where($map)->order('sport_time asc')->paginate(100);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'获取失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 获取运动日程(不分页)
    public function getSportPlanScheduleListNoPageApi(){
        try {
            $map = input('post.');
            $SportPlanSchedule = new \app\model\SportPlanSchedule;
            $result = $SportPlanSchedule->where($map)->order('id asc')->select();
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'获取失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 编辑运动计划
    public function updateSportPlanApi(){
        try {
            $sport_plan_id = input('param.sport_plan_id');
            $sportPlanInfo = $this->SportPlan->where(['id'=>$sport_plan_id])->find();
            if(!$sportPlanInfo){
                return json(['code'=>100,'msg'=>'传参错误']);
            }
            if($sportPlanInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足,请重新登陆']);
            }
            
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 编辑运动计划日程
    public function updateSportPlanScheduleApi(){
        try {
            $sport_plan_schedule_id = input('param.sport_plan_schedule_id');
            $SportPlanSchedule = new \app\model\SportPlanSchedule;
            $sportPlanScheduleInfo = $SportPlanSchedule->where(['id'=>$sport_plan_schedule_id])->find();
            if(!$sportPlanScheduleInfo){
                return json(['code'=>100,'msg'=>'传参错误']);
            }
            if($sportPlanScheduleInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足,请重新登陆']);
            }
            if($sportPlanScheduleInfo['punch_id']){
                return json(['code'=>100,'msg'=>'已有打卡,不可操作']);
            }
            $data = input('post.');
            $data["sport_time"] = strtotime($data["sport_time"]);
            $result = $SportPlanSchedule->save($data,['id'=>$sport_plan_schedule_id]);
            if($result){
                return json(['code'=>200,'msg'=>'操作成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
 
    //获取单个日程
    public function getSportPlanScheduleInfoApi(){
        try {
            $sport_plan_schedule_id = input('param.sport_plan_schedule_id');
            $SportPlanSchedule = new \app\model\SportPlanSchedule;
            $result = $SportPlanSchedule->where(['id'=>$sport_plan_schedule_id])->find();
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