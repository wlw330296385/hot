<?php 
namespace app\mall\controller;
use app\mall\controller\Base;
class Goods extends Base
{
    
    public function _initialize(){
        parent::_initialize();
    }

    public function index(){

        echo "商城首页";
    }


    


    //商品详情
    public function goodsInfo(){
    	echo "商品详情";
    }



    //购物车列表
    public function cartlist(){
    	echo "购物车列表";
    }


    
}