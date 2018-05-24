<?php
namespace app\admin\controller;
use app\admin\service\TemplateService;
use app\admin\controller\base\Backend;
use app\admin\model\TemplatePlatform as TemplatePlatformModel;
class Template extends Backend {
    private $TemplateService;
	public function _initialize(){
		parent::_initialize();
        $this->TemplateService = new TemplateService;
        $this->TemplatePlatform = new TemplatePlatformModel;
	}
    public function templateList() {
        $field = '请选择搜索关键词';
        $map = [];

        $field = input('param.field');
        $keyword = input('param.keyword');
        if($keyword==''){
            $map = [];
            $field = '请选择搜索关键词';
        }else{
            if($field){
                $map = [$field=>['like',"%$keyword%"]];
            }else{
                $field = '请选择搜索关键词';
                $map = function($query) use ($keyword){
                    $query->where(['template'=>['like',"%$keyword%"]]);
                };
            }
        }
        
        $templateList = $this->TemplateService->getTemplateListByPage($map);
        $this->assign('field',$field);
        $this->assign('templateList',$templateList);    
        return view('Template/templateList');
    	
    }

    public function templateInfo(){
        $template_id = input('param.template_id');
        $map['id'] = $araticle_id;
        $templateInfo = $this->TemplateService->getTemplateInfo($map);

        $this->assign('templateInfo',$templateInfo);
        return  view('template/templateInfo');
    }

    public function createTemplate(){
        if(request()->isPost()){
            $data = input('post.');
            $data['member_id']=$this->admin['id'];
            $data['member'] = $this->admin['username'];
            $result = $this->TemplateService->createTemplate($data);
            if($result['code'] == 200){
                $this->success($result['msg'],'/admin/Template/templateList');
            }else{
                $this->error($result['msg']);
            }
        }

        return view('Template/createTemplate');
    }


    public function updateTemplate(){
        $template_id = input('param.template_id');
        $map['id'] = $template_id;
        $templateInfo = $this->TemplateService->getTemplateInfo($map);


        if(request()->isPost()){
            $data = input('post.');
            $id = $data['id'];

            $result = $this->TemplateService->updateTemplate($data,['id'=>$id]);
            if($result['code'] == 200){
                $this->success($result['msg'],url('admin/Template/templatePlatformList',['template_id'=>$template_id]));
            }else{
                $this->error($result['msg']);
            }
        }


        $this->assign('templateInfo',$templateInfo);

        return view('Template/updateTemplate');
    }


    public function templatePlatformList(){

        $template_id = input('param.template_id');
        $map['id'] = $template_id;
        $templateInfo = $this->TemplateService->getTemplateInfo($map);

        $platformList = db('platform')
        ->field('platform.*,template_platform.t_id,template_platform.template,template_platform.template_id,template_platform.remarks as tp_remarks,template_platform.id as tp_id')
        ->join('template_platform','platform.id = template_platform.platform_id','left')
        ->order('template_platform.id desc')
        ->select();


        $this->assign('templateInfo',$templateInfo);
        $this->assign('platformList',$platformList);
        return view('Template/templatePlatformList');
    }


















    // 接口类
    public function getTemplateListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->TemplateService->getTemplateList($map);
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

    //修改关联
    public function updateTemplatePlatformApi(){
         try{
            $data = input('post.');
            $template_plat_id = input('param.template_plat_id');
            $result = $this->TemplatePlatform->save($data,['id'=>$template_plat_id]);
            if($result){
                return json(['code'=>200,'msg'=>'修改成功']);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            }
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }
 
    // 新关联
    public function createTemplatePlatformApi(){
        try{
            $data = input('post.');
           
            $res = $this->TemplatePlatform->where(['platform_id'=>$data['platform_id'],'template_id'=>$data['template_id']])->find();
            if($res){
                return json(['code'=>100,'msg'=>'重复关联']);
            }
            $result = $this->TemplatePlatform->save($data);
            if($result){
                return json(['code'=>200,'msg'=>'关联成功','data'=>$this->TemplatePlatform->id]);
            }else{
                return json(['code'=>100,'msg'=>'关联失败']);
            }
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}
