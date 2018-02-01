<?php
namespace app\service;
use app\model\Rebate;
use think\Db;
 
class RebateService {

    private $Rebate;
    public function __construct()
    {
        $this->Rebate = new Rebate;
    }

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
        }
    }
}