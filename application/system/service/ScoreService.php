<?php
namespace app\service;
use app\model\Score;
use app\common\validate\ScoreVal;
// use think\Db;
class ScoreService {

    private $Score;
    public function __construct()
    {
        $this->Score = new Score;
    }

    public function getScore($map){
        $result = $this->Score->with('lesson')->where($map)->find();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return false;
        }
    }


    // 获取积分记录列表
    public function getScoreList($map,$p = 1,$order = 'id DESC'){
        $res = $this->Score->where($map)->order('id DESC')->page($p,10)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return false;
        }
    }

    
    // 保存积分
    public function saveScore($data){
        $result = $this->Score->save($data);
        if($result ===false){
            file_put_contents(ROOT_PATH.'/data/score/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
        }else{
            file_put_contents(ROOT_PATH.'/data/score/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
        }
    }
}