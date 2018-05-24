<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\model\TemplatePlatform as TemplatePlatformModel;
use app\admin\service\TemplateService;
class TemplateApi extends Backend{
    protected $TemplatePlatform;
    protected $TemplateService;
    public function _initialize(){
        parent::_initialize();
        $this->TemplateService = new TemplateService;
        $this->TemplatePlatform = new TemplatePlatformModel;
    }

    public function getTemplateListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->TemplateService->getTemplateList($map)
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getTemplateListByPageApi(){
         try{
            $map = input('post.');
            $paginate = input('param.paginate')?input('param.paginate'):10; 
            $result = $this->TemplateService->getTemplateListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }

 
    public function updateTemplateApi(){
         try{
             $data = input('post.');
            $bankcard_id = input('param.bankcard_id');
             $data['member_id'] = $this->memberInfo['id'];
             $data['member'] = $this->memberInfo['member'];
            $result = $this->TemplateService->updateTemplate($data,['id'=>$bankcard_id]);
             return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    public function createTemplateApi(){
        try{
            $data = input('post.');
            $result = $this->TemplateService->createTemplate($data);
            return json($result);   
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function getTemplatePlatformListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->TemplatePlatform->where($map)->page($page)->select();  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getTemplatePlatformListByPageApi(){
         try{
            $map = input('post.');
            $paginate = input('param.paginate')?input('param.paginate'):10; 
            $result = $this->TemplatePlatform->where($map)->paginate($paginate);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }

 
    public function updateTemplatePlatformApi(){
         try{
             $data = input('post.');
            $bankcard_id = input('param.bankcard_id');
             $data['member_id'] = $this->memberInfo['id'];
             $data['member'] = $this->memberInfo['member'];
            $result = $this->TemplatePlatform->save($data,['id'=>$bankcard_id]);
             return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }
 
    public function createTemplatePlatformApi(){
        try{
            $data = input('post.');
            $result = $this->TemplatePlatform->save($data);
            return json($result);   
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}