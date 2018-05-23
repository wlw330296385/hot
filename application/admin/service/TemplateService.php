<?php

namespace app\admin\service;

use app\admin\model\Template;
use think\Db;
class TemplateService {
    private $TemplateModel;
    public function __construct(){
        $this->TemplateModel = new Template;
    }


    // 获取所有模板
    public function getTemplateList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = $this->TemplateModel->where($map)->order($order)->page($page,$paginate)->select();

        return $result;
    }

    // 分页获取模板
    public function getTemplateListByPage($map=[], $order='',$paginate=10){

        $result = $this->TemplateModel->where($map)->order($order)->paginate($paginate);
        return $result;
    }

    // 软删除
    public function SoftDeleteTemplate($id) {
        $result = $this->TemplateModel->destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个模板
    public function getTemplateInfo($map) {
        $result = $this->TemplateModel->where($map)->find();
        return $result;
    }




    // 编辑模板
    public function updateTemplate($data,$map){
        
        
        $result = $this->TemplateModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $map];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 新增模板
    public function createTemplate($data){
        $result = $this->TemplateModel->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->TemplateModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }
   
}

