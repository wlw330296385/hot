<?php 
namespace app\mall\controller;
use app\mall\controller\Base;
class Index extends Base
{
    
    public function _initialize(){
        parent::_initialize();
    }

    public function index(){

        echo "商城首页";
    }


    
}