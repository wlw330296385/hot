<?php
// 证件 service
namespace app\service;

use app\model\Income;
use think\Db;
class IncomeService {
    protected $Income;
    public function __construct(){
        $this->Income = new Income;
    }

    public function getIncomeInfo($map) {
        $result = $this->Income->where($map)->find();
        return $result;
    }

    public function getIncomeList($map,$page = 1,$p= 10){
    	$result = $this->Income->where($map)->page($page,$p)->select();
    	return $result;
    }


    public function getIncomeListByPage($map,$paginate = 10){
        $result = $this->Income->where($map)->paginate($paginate);
        return $result;
    }

    
}