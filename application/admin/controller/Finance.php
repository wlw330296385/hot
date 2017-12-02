<?php
// 财务管理

namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\model\Bill;
use app\model\Member;
use app\model\Rebate;
use app\model\SalaryIn;
use think\Db;
use think\helper\Time;
use app\service\SalaryInService;
use app\service\ScheduleService;
use app\service\SystemService;

class Finance extends Backend {
    // 支付订单列表
    public function billlist() {
        // 搜索筛选
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }
        $camp_id = input('camp_id');
        if ($camp_id) {
            $map['camp_id']=$camp_id;
        }
        $member = input('member');
        if ($member) {
            $map['member'] = ['like', '%'. $member .'%'];
        }
        $goods = input('goods');
        if ($goods) {
            $map['goods'] = ['like', '%'. $goods .'%'];
        }
        $billorder = input('bill_order');
        if ($billorder) {
            $map['bill_order'] = $billorder;
        }
        $days = input('days');
        if ($days) {
            if (!checkDatetimeIsValid($days)) {
                $this->error('查看日期格式不合法');
            }

            $day = explode("-", $days);
            $when = getStartAndEndUnixTimestamp($day[0], $day[1], $day[2]);
            $start = $when['start'];
            $end = $when['end'];
            $map['create_time'] = ['between', [$start, $end]];
        }
        //$map['is_pay'] = 1;
        //$map['status'] = 1;
        $list = Bill::where($map)->order('id desc')->paginate(15);
        //dump($list);
        $breadcrumb = ['title' => '支付订单', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $list);
        $this->assign('camp_id', $camp_id);
        return $this->fetch();
    }

    // 支付订单详情
    public function bill() {
        $id = input('id', 0);
        $billObj = Bill::get($id);
        $bill = $billObj->toArray();
        $bill['goods_type_num'] = $billObj->getData('goods_type');
        
        $breadcrumb = ['title' => '支付订单', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('bill', $bill);
        return view();
    }

    // 收入记录列表
    public function salaryinlist() {
        // 搜索筛选
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }
        $camp = input('camp');
        if ($camp) {
            $map['camp'] = ['like', '%'. $camp .'%'];
        }
        $member = input('member');
        if ($member) {
            $map['member'] = ['like', '%'. $member .'%'];
        }
        $list = SalaryIn::with('schedule')->where($map)->order('id desc')->paginate(15)->each(function($item, $key) {
            $item['lesson'] = db('lesson')->where(['id' => $item['lesson_id']])->find();
            $item['schedule']['num_student'] = count( unserialize( $item['schedule']['student_str'] ) ) ;
            return $item;
        });
//        dump($list->toArray());

        $breadcrumb = ['title' => '收入记录', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 收入记录详情
    public function salaryin() {
        $id = input('id', 0);
        $salaryin = SalaryIn::where('id', $id)->find()->toArray();
        $pid = $salaryin['pid'];
        //if ($pid) {
            //$salaryin['parent'] = MemberModel::where(['id' => $pid])->field(['id','member','realname'])->find()->toArray();
            //$salaryin['rebate'] = RebateModel::where(['salary_id' => $salaryin['id'], 'tier' => ['elt', 4]])->select()->toArray();
            $salaryin['rebate'] = [];
        //}
        //dump($salaryin);

        $breadcrumb = ['title' => '收入详情', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('salaryin', $salaryin);
        return view();
    }

    // 收入提现记录列表
    public function salaryoutlist() {
        $map=[];
        $member = input('member');
        if ($member) {
            $map['member'] = ['like', '%'. $member .'%'];
        }
        $list = Db::name('salary_out')->where($map)->paginate(15);

        $breadcrumb = ['title' => '提现记录', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $list);
        return view();
    }

    public function salaryout() {
        $id = input('id', 0);
        $salaryout = Db::name('salary_out')->where('id', $id)->find();
        //dump($salaryout);

        $breadcrumb = ['title' => '提现详情', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('salaryout', $salaryout);
        return view();
    }

    // 订单对账
    public function reconciliation() {
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }
        $camp_id = input('camp_id', 0);
        if ($camp_id) {
            $map['camp_id'] = $camp_id;
        }
        $date = input('date');
        if ($date) {
            $dateArr = explode('-', $date);
            $when = getStartAndEndUnixTimestamp($dateArr[0], $dateArr[1]);
            $start = $when['start'];
            $end = $when['end'];
        } else {
            list($start, $end) = Time::month();
        }
        $map['create_time'] = ['between', [$start, $end]];
        //$list = Bill::where($map)->field()->order('id desc')->paginate(15);
        $model = new \app\model\Bill();
        $datas = $model->field("FROM_UNIXTIME(`create_time`,'%Y-%m-%d') days,count(*) count,sum(balance_pay) total")->where($map)->group('days')->select()->toArray();
        // 初始化输出结果数组：列表、合计
        $listArr = [];
        $sum = ['total' => 0, 'bank_charges' => 0, 'collection' => 0, 'people_count' => 0];
        if ($datas) {
            // 生成筛选时间段内日期每日递增的数组
            for ($i=$start; $i<$end; $i+= 86400) {
                $day = date('Y-m-d', $i);
                $listArr[$day] = ['days' => $day, 'count' => 0, 'total' => 0, 'bank_charges' => 0, 'collection' => 0];
            }
            // 遍历查询结果 将相应日期的数据覆盖进数组对应键值
            foreach ($datas as $val) {
                if ( array_key_exists($val['days'], $listArr) ) {
                    $arrayKey = $val['days'];
                    $listArr[$arrayKey] = $val;
                    $bankCharges = $val['total']*0.06;
                    $listArr[$arrayKey]['bank_charges'] = $bankCharges;
                    $collection = $val['total']-$bankCharges;
                    $listArr[$arrayKey]['collection'] = $collection;
                    $sum['total'] += $val['total'];
                    $sum['bank_charges'] += $bankCharges;
                    $sum['collection'] += $collection;
                    $sum['people_count'] += $val['count'];
                }
            }
            // 数组索引重新从0开始递增排序
            $listArr = array_values($listArr);
            //dump($listArr);
        }

        $breadcrumb = ['title' => '订单对账', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('curdate', $date);
        $this->assign('list', $listArr);
        $this->assign('sum', $sum);
        $this->assign('camp_id', $camp_id);
        return $this->fetch();
    }


    // 交费统计
    public function tuitionstatis() {
        // 初始化日期显示
        $datetime = initDateTime();
        // 查询筛选项接收
        $year = input('year');
        if ($year){
            //dump($year);
            $when = getStartAndEndUnixTimestamp($year);
            $startTime = $when['start'];
            $endTime = $when['end'];
        }
        $date = input('date');
        if ($date) {
            $dateArr = explode('-', $date);
            $when = getStartAndEndUnixTimestamp($dateArr[0], $dateArr[1]);
            $startTime = $when['start'];
            $endTime = $when['end'];
        }
        $start = input('start');
        $end = input('end');
        if ($start && $end) {
            $startDate = explode('-', $start);
            $endDate = explode('-', $end);
            $startWhen = getStartAndEndUnixTimestamp($startDate[0], $startDate[1]);
            $endWhen = getStartAndEndUnixTimestamp($endDate[0], $endDate[1]);
            $startTime = $startWhen['start'];
            $endTime = $endWhen['end'];
        }
        if ( !$year && !$date && !$start && !$end ){
            list($startTime, $endTime) = Time::month();
        }
        $map['create_time'] = ['between', [$startTime, $endTime]];
        //dump($map);
        $page =input('page',1);

        // 初始化输出结果数组：列表、合计
        //$listArr = [];
        $sum = [
            'first' => ['count' => 0, 'amount' => 0],
            'renew' => ['count' => 0, 'amount' => 0],
            'total' => ['count' => 0, 'amount' => 0],
            'refund' => ['count' => 0, 'amount' => 0]
        ];
        $model = new \app\model\Bill();
        $map['goods_type'] = 1;
        $map['is_pay'] = 1;

        $campM = new \app\model\Camp();
        $camps = $campM->where(['status' => ['>', 0]])->field(['id', 'camp'])->order('id desc')->select()->toArray();
        // 遍历所有训练营 查询会员在训练营的课程订单数据
        foreach ($camps as $k => $camp) {
            $camps[$k]['first']['count'] = 0;
            $camps[$k]['first']['amount'] = 0;
            $camps[$k]['renew']['count'] = 0;
            $camps[$k]['renew']['amount'] = 0;
            $camps[$k]['sum']['count'] = 0;
            $camps[$k]['sum']['amount'] = 0;
            $camps[$k]['refund']['count'] = 0;
            $camps[$k]['refund']['amount'] = 0;
            $campid = $camp['id'];
            $map['camp_id'] = $campid;
            $campbills = $model->where($map)
                //->where(['goods_type' => 1, 'is_pay' => 1])
                ->field('count(*) count,sum(balance_pay) total, member_id')
                ->group('member_id')
                ->order('member_id')
                ->select()->toArray();
            //dump($campbills);
            // 遍历查询结果 扣减第一条订单金额和记录数-1，第一条定单金额为新报交费金额，其他记录金额为续报交费金额
            foreach ($campbills as $k2 => $bill) {
                $memberAllBills = $model->where($map)->where(['member_id' => $bill['member_id']])->order('id asc')->select()->toArray();
                //dump($memberAllBills);
                if ($memberAllBills) {
                    $campbills[$k2]['count'] -=1;
                    $campbills[$k2]['total'] -= $memberAllBills[0]['balance_pay'];
                    // 新报交费人数、金额
                    $camps[$k]['first']['count'] += 1;
                    $camps[$k]['first']['amount'] += $memberAllBills[0]['balance_pay'];
                    // 续报交费人数、金额
                    $camps[$k]['renew']['count'] += $campbills[$k2]['count'];
                    $camps[$k]['renew']['amount'] += $campbills[$k2]['total'];
                }
            }
            $camps[$k]['sum']['count'] = $camps[$k]['first']['count']+$camps[$k]['renew']['count'];
            $camps[$k]['sum']['amount'] =$camps[$k]['first']['amount']+$camps[$k]['renew']['amount'];
            // 查询退费订单记录
            $refundBills= $model->where($map)->where(['status' => -2, 'refundamount' => ['>', 0]])
                ->field('count(*) count,sum(balance_pay) total')
                ->select()->toArray();
            if ($refundBills) {
                // 退费人数、金额
                $camps[$k]['refund']['count'] = $refundBills[0]['count'];
                $camps[$k]['refund']['amount'] = (!empty($refundBills[0]['total'])) ? $refundBills[0]['total'] : 0;
            }

            // 累加合计
            $sum['first']['count'] += $camps[$k]['first']['count'];
            $sum['first']['amount'] += $camps[$k]['first']['amount'];
            $sum['renew']['count'] += $camps[$k]['renew']['count'];
            $sum['renew']['amount'] += $camps[$k]['renew']['amount'];
            $sum['total']['count'] += $camps[$k]['sum']['count'];
            $sum['total']['amount'] += $camps[$k]['sum']['amount'];
            $sum['refund']['count'] += $camps[$k]['refund']['count'];
            $sum['refund']['amount'] += $camps[$k]['refund']['amount'];
        }
//        dump($camps);
//        dump($sum);
        $breadcrumb = ['title' => '学费统计', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('camps', $camps);
        $this->assign('sum', $sum);
        return $this->fetch();
    }

    // 收益统计
    public function earings() {
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }

        $date = input('date');
        if ($date) {
            $dateArr = explode('-', $date);
            $when = getStartAndEndUnixTimestamp($dateArr[0], $dateArr[1]);
            $start = $when['start'];
            $end = $when['end'];
        } else {
            list($start, $end) = Time::lastMonth();
        }
        $map['create_time'] = ['between', [$start, $end]];
        //dump($map);
        // 初始化输出结果数组：合计
        $sum = [

        ];
        // 遍历所有训练营
        $campM = new \app\model\Camp();
        $camps = $campM->where(['status' => ['>', 0]])->field(['id', 'camp'])->order('id desc')->select()->toArray();
        foreach ($camps as $k => $camp) {
            $map['camp_id'] = $camp['id'];
            $camps[$k]['schedule_salaryin'] = 0;
            $camps[$k]['system_extract'] = 0;
            $camps[$k]['coach_salary'] = 0;
            $camps[$k]['camp_income'] = 0;
            // 获取平台服务抽取比例
            $setting = SystemService::getSite();
            $sysrebate = $setting['sysrebate'];
            // 获取数据
            // 获取课时结算总收入、平台服务支出输出结果
            $scheduleS = new ScheduleService();
            $scheduleSalaryin = $scheduleS->scheduleIncome($map);
            if ($scheduleSalaryin) {
                $camps[$k]['schedule_salaryin'] = $scheduleSalaryin;
                $camps[$k]['system_extract'] = $scheduleSalaryin*$sysrebate;
            }
            // 获取教练工资支出
            $salaryInS = new SalaryInService(1);
            $coachMap = $map;
            $coachMap['member_type'] = ['lt', 5];
            $coachMap['type'] = 1;
            $coachSalaryIn = $salaryInS->countSalaryin($coachMap);
            if ($coachSalaryIn) {
                $camps[$k]['coach_salary'] = $coachSalaryIn;
            }
            // 训练营直接收入
            $campMap = $map;
            $campMap['type'] =1;
            $campMap['member_type'] = 5;
            $campSalaryin = $salaryInS->countSalaryin($campMap);
            if ($campSalaryin) {
                $camps[$k]['camp_income'] = $campSalaryin;
            }
        }
        //dump($camps);
        $breadcrumb = ['title' => '学费统计', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        return $this->fetch();
    }
}
