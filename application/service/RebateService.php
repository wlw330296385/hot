<?php
namespace app\service;
use app\model\Rebate;
use app\common\validate\RebateVal;
use app\model\SystemAward;
// use think\Db;
class RebateService {

    private $Rebate;
    public function __construct($memberId)
    {
        $this->Rebate = new Rebate;
    }

    public function getRebate($map){
        $result = $this->Rebate->with('lesson')->where($map)->find();

        return $result;
    }


    // 获取提现记录列表
    public function getRebateList($map,$p = 1,$paginate = 10,$order = 'id DESC'){
        $res = $this->Rebate->where($map)->order('id DESC')->page($p,$paginate)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }

    
    // 提交提现申请
    public function saveRebate($data){
        $data['paytime'] = '';
        $data['is_pay'] = 0;
        $data['status'] = 0;
        $result = $this->Rebate->save($data);
        if($result){
            return ['code'=>200,'msg'=>'申请成功','data'=>$data];
        }else{
            return ['code'=>100,'msg'=>'申请失败','data'=>$data];
        }
    }
}