<?php
namespace app\service;
use app\model\Rebate;
<<<<<<< HEAD
use app\common\validate\RebateVal;
use app\model\SystemAward;
// use think\Db;
class RebateService {

    private $Rebate;
    public function __construct($memberId)
=======
use think\Db;
 
class RebateService {

    private $Rebate;
    public function __construct()
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    {
        $this->Rebate = new Rebate;
    }

<<<<<<< HEAD
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
=======
    // 会员推荐分成列表
    public function getRebateList($map=[], $page=1, $order='datemonth desc', $limit=10) {
        $model = new Rebate();
        $query = $model->where($map)->group('sid,datemonth,tier')->field('*, sum(salary) salary')->order($order)->page($page)->limit($limit)->select();

        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 会员推荐分成层级收入统计
    public function sumRebateByTier($map, $tier) {
        $model = new Rebate();
        $query = $model->where($map)->where(['tier' => $tier])->sum('salary');
        if ($query) {
            // 保留两位小数
            $sum = sprintf("%.2f", $query);
            return $sum;
        } else {
            return 0;
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        }
    }
}