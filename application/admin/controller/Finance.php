<?php
// 财务管理

namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\model\Bill as BillModel;
use app\model\Member as MemberModel;
use app\model\Rebate as RebateModel;
use app\model\SalaryIn as SalaryInModel;
use think\Db;

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

        $list = BillModel::where($map)->order('id desc')->paginate(15);
        //dump($list);
        $breadcrumb = ['title' => '支付订单', 'ptitle' => '训练营'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 支付订单详情
    public function bill() {
        $id = input('id', 0);
        $billObj = BillModel::get($id);
        $bill = $billObj->toArray();
        $bill['goods_type_num'] = $billObj->getData('goods_type');
        
        $breadcrumb = ['title' => '支付订单', 'ptitle' => '训练营'];
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
        $list = SalaryInModel::with('schedule')->where($map)->order('id desc')->paginate(15)->each(function($item, $key) {
            $item['lesson'] = db('lesson')->where(['id' => $item['lesson_id']])->find();
            $item['schedule']['num_student'] = count( unserialize( $item['schedule']['student_str'] ) ) ;
            return $item;
        });
//        dump($list->toArray());

        $breadcrumb = ['title' => '收入记录', 'ptitle' => '训练营'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 收入记录详情
    public function salaryin() {
        $id = input('id', 0);
        $salaryin = SalaryInModel::where('id', $id)->find()->toArray();
        $pid = $salaryin['pid'];
        //if ($pid) {
            //$salaryin['parent'] = MemberModel::where(['id' => $pid])->field(['id','member','realname'])->find()->toArray();
            //$salaryin['rebate'] = RebateModel::where(['salary_id' => $salaryin['id'], 'tier' => ['elt', 4]])->select()->toArray();
            $salaryin['rebate'] = [];
        //}
        //dump($salaryin);

        $breadcrumb = ['title' => '收入详情', 'ptitle' => '训练营'];
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

        $breadcrumb = ['title' => '提现记录', 'ptitle' => '训练营'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $list);
        return view();
    }

    public function salaryout() {
        $id = input('id', 0);
        $salaryout = Db::name('salary_out')->where('id', $id)->find();
        //dump($salaryout);

        $breadcrumb = ['title' => '提现详情', 'ptitle' => '训练营'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('salaryout', $salaryout);
        return view();
    }

}