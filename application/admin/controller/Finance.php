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

class Finance extends Backend {
    // 支付订单列表
    public function billlist() {
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
        $camp = input('camp');
        if ($camp) {
            $map['camp'] = ['like', '%'. $camp .'%'];
        }
        $month = input('month');
        if ($month) {
            $date = explode('-', $month);
            $when = getStartAndEndUnixTimestamp($date[0], $date[1]);
            $start = $when['start'];
            $end = $when['end'];
        } else {
            $month = date('Y-m', time());
            list($start, $end) = Time::month();
        }
        $map['create_time'] = ['between', [$start, $end]];
        //$list = Bill::where($map)->field()->order('id desc')->paginate(15);
        $model = new \app\model\Bill();
        $datas = $model->field("FROM_UNIXTIME(`create_time`,'%Y-%m-%d') days,count(*) count,sum(balance_pay) total")->where($map)->group('days')->select()->toArray();
        $listArr = [];
        if ($datas) {
            // 生成筛选时间段内日期每日递增的数组
            for ($i=$start; $i<$end; $i+= 86400) {
                $date = date('Y-m-d', $i);
                $listArr[$date] = ['days' => $date, 'count' => 0, 'total' => 0, 'bank_charges' => 0, 'collection' => 0];
            }
            // 遍历查询结果 将相应日期的数据覆盖进数组对应键值
            foreach ($datas as $val) {
                if ( array_key_exists($val['days'], $listArr) ) {
                    $arrayKey = $val['days'];
                    $listArr[$arrayKey] = $val;
                    $bankCharges = $val['total']*0.06;
                    $listArr[$arrayKey]['bank_charges'] = $bankCharges;
                    $listArr[$arrayKey]['collection'] = $val['total']-$bankCharges;
                }
            }
            // 数组索引重新从0开始递增排序
            $listArr = array_values($listArr);
            //dump($listArr);
        }



        $breadcrumb = ['title' => '订单对账', 'ptitle' => '财务'];
        $this->assign('curmonth', $month);
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $listArr);
        return $this->fetch();
    }


    // 交费统计
    public function tuitionstatis() {
        return $this->fetch();
    }

    // 收益统计
    public function earings() {

    }
}