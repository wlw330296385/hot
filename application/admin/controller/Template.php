<?php
namespace app\admin\controller;
use app\admin\service\TemplateService;
use app\admin\controller\base\Backend;
class Template extends Backend {
    private $TemplateService;
	public function _initialize(){
		parent::_initialize();
        $this->TemplateService = new TemplateService;
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
                $this->success($result['msg'],url('admin/Template/templateInfo',['template_id'=>$template_id]));
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

        $platformList = db('platform')->join('template_platform','')->where(['template_id'=>$template_id])->select();




        $this->assign('templateInfo',$templateInfo);


        $this->assign('platformList',$platformList);
        return view('Template/templatePlatformList');
    }

}
