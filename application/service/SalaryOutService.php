<?php
namespace app\service;
use app\model\SalaryOut;
use app\model\Rebate;
use app\common\validate\SalaryOutVal;
use app\model\SystemAward;
// use think\Db;
class SalaryOutService {

    private $SalaryOut;
    public function __construct()
    {
        $this->SalaryOut = new SalaryOut;
    }

    public function getSalaryOut($map){
        $result = $this->SalaryOut
                // ->with('lesson')
                ->where($map)
                ->find();
        return $result;
    }


    // 获取提现记录列表
    public function getSalaryOutList($map,$p = 1,$order = 'id DESC'){
        $result = $this->SalaryOut->where($map)->order('id DESC')->page($p,10)->select();
        return $result;
    }

    
    // 提交提现申请
    public function saveSalaryOut($data){
        $data['paytime'] = '';
        $data['is_pay'] = 0;
        $data['status'] = 0;
        $validate = validate('SalaryOutVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->SalaryOut->save($data);
        if($result){
            db('member')->where(['id'=>$data['member_id']])->setDec('balance',$data['salary']);
            $memberInfo = db('member')->where(['id'=>$data['member_id']])->find();
            session('memberInfo',$memberInfo,'think');
            return ['code'=>200,'msg'=>'申请成功','data'=>$data];
        }else{
            return ['code'=>100,'msg'=>'申请失败','data'=>$data];
        }
    }
}   