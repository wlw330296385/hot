<?php
namespace app\service;
use app\model\SalaryOut;
use app\model\Rebate;
use app\common\validate\SalaryOutVal;
use app\model\SystemAward;
// use think\Db;
class SalaryOutService {

    private $SalaryOut;
    public function __construct($memberId)
    {
        $this->SalaryOut = new SalaryOut;
    }

    public function getSalaryOut($map){
        $result = $this->SalaryOut->with('lesson')->where($map)->find();
        return $result;
    }


    // 获取提现记录列表
    public function getSalaryOutList($map,$p = 10,$order = 'id DESC'){
        $result = $this->SalaryOut->where($map)->order('id DESC')->paginate($p);
        return $result;
    }

    
    // 提交提现申请
    public function saveSalaryOut($data){
        $data['paytime'] = '';
        $data['is_pay'] = 0;
        $data['status'] = 0;
        $result = $this->SalaryOut->save($data);
        if($result){
            return ['code'=>100,'msg'=>'申请成功','data'=>$data];
        }else{
            return ['code'=>200,'msg'=>'申请失败','data'=>$data];
        }
    }
}