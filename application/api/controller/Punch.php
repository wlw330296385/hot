<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\PunchService;
use think\Db;
class Punch extends Base{
   protected $PunchService;
 
    public function _initialize(){
        parent::_initialize();
       $this->PunchService = new PunchService;
    }
 
    // 获取打卡列表
    public function getPunchListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->PunchService->getPunchList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
     // 获取打卡列表 无page
    public function getPunchListNoPageApi(){
         try{
            $map = input('post.');
            $result = $this->PunchService->getPunchListNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
    // 获取打卡列表带page
     public function getPunchListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PunchService->getPunchListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取社群打卡带page
    public function getGroupPunchListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PunchService->getGroupPunchListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 操作打卡
    public function editPunchApi(){
        try{
           $data = input('post.');
           $punch_id = input('param.punch_id');
           $data['member_id'] = $this->memberInfo['id'];
           $data['member'] = $this->memberInfo['member'];
           $result = db('punch')->where(['id'=>$punch_id])->update($data);
           if($result){
                return json(['code'=>200,'msg'=>'ok']);
            }
            return json(['code'=>100,'msg'=>'失败']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //创建打卡
    public function createPunchApi(){
        Db::startTrans();
         try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->PunchService->createPunch($data);
            
            if(!empty($data['groupList']) && $data['groupList'] != '[]' && $result['code']== 200){
                foreach ($data['groupList'] as $key => &$value) {
                    $value['punch'] = $data['punch'];
                    $value['punch_id'] = $result['data'];
                }
                $groupList = json_decode($data['groupList'],true);
                $GroupPunch = new \app\model\GroupPunch;
                $GroupPunch->saveAll($groupList);
            }
            Db::commit();   
            return json($result);   
         }catch (Exception $e){
            Db::rollback();
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


 
    //打卡关联社群
    public function createPunchMemberApi(){
         try{
            $punch_id = input('param.punch_id');
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            $result = $this->PunchService->createPunchMember($member_id,$member,$punch_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    
}