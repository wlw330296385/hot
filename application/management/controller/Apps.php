<?php
namespace app\management\controller;

use app\management\controller\Backend;
use app\model\AppsApply;
class Apps extends Backend {
    private $AppsApply; 
	public function _initialize(){
		parent::_initialize();
        $this->AppsApply = new AppsApply;
	}
    public function appsApplyList() {
        $field = '请选择搜索关键词';

        $type = input('param.type',2);
        $f_id = input('param.f_id');
        $map = ['type'=>$type,'f_id'=>$f_id];
        $field = input('param.field');
        $keyword = input('param.keyword');
        if($keyword==''){
            $field = '请选择搜索关键词';
        }else{
            if($field){
                $map = [$field=>['like',"%$keyword%"]];
            }else{
                $field = '请选择搜索关键词';
                $map = function($query) use ($keyword){
                    $query->where(['realname|member|telephone'=>['like',"%$keyword%"]]);
                };
            }
        }
// dump($type);die;
        if($type == 2){
            $info = db('event')->where(['id'=>$f_id])->find();
            if($info['dom']){
                $info['doms'] = json_decode($info['dom'],true);
            }else{
                $info['doms'] = [];
            }
            
        }elseif($type == 1){

        }   
        
        $appsApplyList = $this->AppsApply->where($map)->select();
        $this->assign('field',$field);
        $this->assign('info',$info);
        $this->assign('appsApplyList',$appsApplyList);    
        return view('Apps/appsApplyList');
    	
    }



    
}
