<?php
namespace app\admin\controller;
use app\admin\service\TemplateService;
use app\admin\controller\base\Backend;
class Template extends Backend {
	public function _initialize(){
		parent::_initialize();
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
        return view('template/templateList');
    	
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

        return view('template/createTemplate');
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

        return view('template/updateTemplate');
    }

}
