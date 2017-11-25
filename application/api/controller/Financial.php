<?php
// 财务
namespace app\api\controller;
use app\service\CampService;
use think\Db;
use think\Exception;

class Financial extends Base {
    // 学费月表
    public function monthbill() {
        try {
            // 接受参数 camp_id year month
            $camp_id = input('camp_id');
            if (!$camp_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').',需要训练营信息']);
            }
            // 查询训练营信息，无训练营抛出提示
            $campS = new CampService();
            $camp = $campS->getCampInfo($camp_id);
            if (!$camp) {
                return json(['code' => 100, 'msg' => '训练营'.__lang('MSG_404')]);
            }
            // 有无权限查看数据
            $campPower = getCampPower($camp['id'], $this->memberInfo['id']);
            if (!$campPower || $campPower < 3) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').',你无权查看此训练营相关信息']);
            }
            $map['camp_id'] = $camp['id'];
            $map['is_pay'] = 1;
            // 查询时间范围内 分日期 查询人数和金额
            //select FROM_UNIXTIME(`create_time`,'%Y%m%d') as days,count(*) as count,sum(balance_pay) as total from `bill` where `camp_id`=".$camp['id']." and `is_pay`=1 group by days;
            $model = new \app\model\Bill();
            $res = $model->field("FROM_UNIXTIME(`create_time`,'%Y%m%d') days,count(*) count,sum(balance_pay) total")->where($map)->group('days')->select();
            if (!$res) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res->toArray()];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}