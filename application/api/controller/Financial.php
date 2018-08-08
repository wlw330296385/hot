<?php
// 财务
namespace app\api\controller;
use app\service\CampService;
use app\service\SalaryInService;
use app\service\ScheduleService;
use app\service\SystemService;
use think\Db;
use think\Exception;
use think\helper\Time;

class Financial extends Base {
    // 学费月表api
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
            $map['goods_type'] = 1;
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

    // 学费统计
    public function statistics() {
        try {
            // 接受参数 camp_id start开始日期 end结束日期
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
            // 查询数据条件组合
            $map['camp_id'] = $camp['id'];
            $map['is_pay'] = 1;
            // 如果传入start和end参数则查询数据时间范围/否则查询本月时间
            $start = input('param.start');
            $end = input('param.end');
            if (!$start || !$end) {
               
                if ( !checkDatetimeIsValid($start) || !checkDatetimeIsValid($end) ) {
                    return json(['code' => 100, 'msg' => '日期格式不合法']);
                }
                $start = strtotime($start);
                $end = strtotime($end)+24*3600-1;
            } else {
                list($start, $end) = Time::month();
            }
            $map['create_time'] = ['between', [$start, $end]];
            // 初始化输出结果数组：新报交费人数、金额，续报交费人数、金额，交费合计人数、金额，退费人数、金额
            $resultArr = [
                'first' => ['count' => 0, 'total' => 0],
                'renew' => ['count' => 0, 'total' => 0],
                'sum' => ['count' => 0, 'total' => 0],
                'refund' => ['count' => 0, 'total' =>0 ]
            ];
            $model = new \app\model\Bill();
            // 按会员分组查询所有交费订单记录
            $map['goods_type'] = 1;
            $bills = $model->where($map)
                ->field('count(*) count,sum(balance_pay) total, member_id')
                ->group('member_id')
                ->order('member_id')
                ->select()->toArray();
            // 遍历查询结果 扣减第一条订单金额和记录数-1，第一条定单金额为新报交费金额，其他记录金额为续报交费金额
            if ($bills) {
                foreach ($bills as $k => $bill) {
                    $memberAllBills = $model->where($map)->where(['member_id' => $bill['member_id']])->order('id asc')->select()->toArray();
                    if ($memberAllBills) {
                        $bills[$k]['count'] -= 1;
                        $bills[$k]['total'] -= $memberAllBills[0]['balance_pay'];
                        // 新报交费人数、金额
                        $resultArr['first']['count'] += 1;
                        $resultArr['first']['total'] += $memberAllBills[0]['balance_pay'];
                        // 续报交费人数、金额
                        $resultArr['renew']['count'] += $bills[$k]['count'];
                        $resultArr['renew']['total'] += $bills[$k]['total'];
                    }
                }
            }
            $resultArr['sum']['count'] = $resultArr['first']['count']+$resultArr['renew']['count'];
            $resultArr['sum']['total'] = $resultArr['first']['total']+$resultArr['renew']['total'];
            // 查询退费订单记录
            $refundBills= $model->where($map)->where(['status' => -2, 'refundamount' => ['>', 0]])
                ->field('count(*) count,sum(balance_pay) total')
                ->select()->toArray();
            if ($refundBills) {
                 // 退费人数、金额
                $resultArr['refund']['count'] = $refundBills[0]['count'];
                $resultArr['refund']['total'] = (!empty($refundBills[0]['total'])) ? $refundBills[0]['total'] : 0;
            }
            //dump($resultArr);
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $resultArr]);
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 收益统计
    public function earnings() {
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
            // 要查询的时间段（年、月），默认上个年月；
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
                list($start, $end) = Time::lastMonth();
            }
            // 组合时间查询条件
            $map['create_time'] = ['between', [$start, $end]];
           // 初始化统计输出结果
            $resultArr = ['schedule_salaryin' => 0, 'system_extract' => 0, 'coach_salary' => 0, 'camp_income' => 0];
            // 获取平台服务抽取比例
            $setting = SystemService::getSite();
            $sysrebate = $setting['sysrebate'];
            // 获取数据
            // 获取课时结算总收入、平台服务支出输出结果
            $scheduleS = new ScheduleService();
            $scheduleSalaryin = $scheduleS->scheduleIncome($map);
            if ($scheduleSalaryin) {
                $resultArr['schedule_salaryin'] = $scheduleSalaryin;
                $resultArr['system_extract'] = $scheduleSalaryin*$sysrebate;
            }
            // 获取教练工资支出
            $salaryInS = new SalaryInService($this->memberInfo['id']);
            $coachMap = $map;
            $coachMap['member_type'] = ['lt', 5];
            $coachMap['type'] = 1;
            $coachSalaryIn = $salaryInS->countSalaryin($coachMap);
            if ($coachSalaryIn) {
                $resultArr['coach_salary'] = $coachSalaryIn;
            }
            // 训练营直接收入
            $campMap = $map;
            $campMap['type'] =1;
            $campMap['member_type'] = 5;
            $campSalaryin = $salaryInS->countSalaryin($campMap);
            if ($campSalaryin) {
                $resultArr['camp_income'] = $campSalaryin;
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $resultArr]);
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}