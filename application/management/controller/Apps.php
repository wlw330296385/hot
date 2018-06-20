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
                    $query->where(['realname|member|telephone'=>['like',"%$keyword%"]]);
                };
            }
        }
        $appsApplyList = $this->AppsApply->paginate(10);
        $this->assign('field',$field);
        $this->assign('appsApplyList',$appsApplyList);    
        return view('Apps/appsApplyList');
    	
    }



    
}
