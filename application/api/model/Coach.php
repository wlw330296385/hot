<?php
namespace app\api\model;
use think\Model;

class Coach extends Model {

	protected $autoWriteTimestamp = true;
	//自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }


    public function getStatusAttr($value){
    	$status = [-1=>'禁用',0=>'待审核',1=>'正常',2=>'不通过'];
    	return $status[$value];
    }


    public function profile(){
    	// return $this->hasOne('member','member_id','id','memberinfo')->field('member,nickname,avatar,telephone,email');
    	return $this->hasOne('member','member_id','id','memberinfo');
    }
}