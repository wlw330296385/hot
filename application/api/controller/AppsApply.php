<?php 
namespace app\api\controller;
use app\api\controller\Base;
use think\Db;
use app\model\AppsApply as AppsApplyModel;
class AppsApply extends Base{
    private $AppsApply;
    public function _initialize(){
        parent::_initialize();
        $this->AppsApply = new AppsApplyModel;
    }



    public function getAppsApplyListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->AppsApply->where($map)->paginate(10);    
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
    public function getAppsApplyListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            
            $result = $this->AppsApply->where($map)->select();
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 提交报名,写入一条
    public function createAppsApplyApi(){
        try{
            $data = input('post.');
            $apps_apply_id = input('param.apps_apply_id');
            if($apps_apply_id){
                $result = $this->AppsApply->save($data,$apps_apply_id);
            }else{
                $result = $this->AppsApply->save($data);
                if($result){
                    switch ($data['type']) {
                        case 1:
                            $EventService = new \app\service\EventService;
                            $res = $EventService->joinEvent($data['f_id'],$this->memberInfo['id'],$this->memberInfo['member'],1);
                            dump($res);
                            if($res['code'] == 100){
                                $msg = $res['msg'];
                                $this->AppsApply->save(['system_remarks'=>$msg],$this->AppsApply->id);
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
            if($result){
                return json(['code'=>200,'msg'=>'提交成功']);
            }else{
                return json(['code'=>100,'msg'=>'提交失败']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


}