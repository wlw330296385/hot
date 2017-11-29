<?php
// 财务
namespace app\api\controller;
use app\service\CampService;
use think\Db;
use think\Exception;
use think\helper\Time;

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
            // 要查询的时间段（年、月），默认当前年月；
            if (input('?year') || input('?month')) {
                // 判断年、月参数是否为数字格式
                $year = input('year', date('Y'));
                $month = input('month', date('m'));
                if (!is_numeric($year) || !is_numeric($month) ) {
                    return json(['code' => 100, 'msg' => '时间格式错误']);
                }
                // 根据传入年、月 获取月份第一天开始时间和最后一天结束时间
                $when = getStartAndEndUnixTimestamp($year,$month);
                $start = $when['start'];
                $end = $when['end'];
            } else {
                list($start, $end) = Time::month();
            }
            // 组合时间查询条件
            $map['create_time'] = ['between', [$start, $end]];
            // 查询时间范围内 分日期 查询人数和金额
            //select FROM_UNIXTIME(`create_time`,'%Y%m%d') as days,count(*) as count,sum(balance_pay) as total from `bill` where `camp_id`=".$camp['id']." and `is_pay`=1 group by days;
            $model = new \app\model\Bill();
            $res = $model->field("FROM_UNIXTIME(`create_time`,'%Y-%m-%d') days,count(*) count,sum(balance_pay) total")->where($map)->group('days')->select()->toArray();
            if (!$res) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            } else {
                // 生成筛选时间段内日期每日递增的数组
                $listArr = [];
                for ($i=$start; $i<$end; $i+= 86400) {
                    $date = date('Y-m-d', $i);
                    $listArr[$date] = ['days' => $date, 'count' => 0, 'total' => 0];
                }
                // 遍历查询结果 将相应日期的数据覆盖进数组对应键值
                foreach ($res as $val) {
                    if ( array_key_exists($val['days'], $listArr) ) {
                        $listArr[$val['days']] = $val;
                    }
                }
                // 数组索引重新从0开始递增排序
                $listArr = array_values($listArr);
                $sum = $model->field("count(*) sum_people,sum(balance_pay) sum_total")->where($map)->select()->toArray();
                // 返回结果数据
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $listArr, 'sum' => $sum[0]];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}