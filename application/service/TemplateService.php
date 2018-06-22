<?php
// 模板消息 service
namespace app\service;

use app\model\Punch;
use think\Db;
class PunchService {
    protected $Punch;
    public function __construct(){
        $this->Punch = new Punch;
    }

}