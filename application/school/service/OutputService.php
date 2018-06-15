<?php
// 证件 service
namespace app\service;

use app\model\Output;
use think\Db;
class OutputService {
    protected $Output;
    public function __construct(){
        $this->Output = new Output;
    }

    public function getOutputInfo($map) {
        $result = $this->Output->where($map)->find();
        return $result;
    }

    public function getOutputList($map,$page = 1,$p= 10){
    	$result = $this->Output->where($map)->page($page,$p)->select();
    	return $result;
    }


    public function getOutputListByPage($map,$paginate = 10){
        $result = $this->Output->where($map)->paginate($paginate);
        return $result;
    }

    
}