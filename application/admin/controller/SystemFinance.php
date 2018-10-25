<?php
// 系统设置
namespace app\admin\controller;
use app\admin\controller\base\Backend;

class SystemFinance extends Backend {
    public function _initialize(){
        parent::_initialize();
    }



    // 平台收入
    public function incomeList(){
        $Ym = input('param.Ym',date('Y-m',time()));
        // dump($Ym);die;
        $b = new \DateTime($Ym);
        $s = $b->format('Y-m-01');
        $b->add(new \DateInterval('P1M'));
        $e = $b->format('Y-m-01');


        $SysIncome = new \app\model\SysIncome;
        $list = $SysIncome->whereTime('create_time','between',[$s, $e])->select();
        $total = $SysIncome->whereTime('create_time','between',[$s, $e])->sum('income');


        $this->assign('list',$list);
        $this->assign('Ym',$Ym);
        $this->assign('total',$total?$total:0);
        return view("SystemFinance/incomeList");

    }



    // 平台支出
    public function outputList(){
        $Ym = input('param.Ym',date('Y-m',time()));
        $b = new \DateTime($Ym);
        $s = $b->format('Y-m-01');
        $b->add(new \DateInterval('P1M'));
        $e = $b->format('Y-m-01');



        $SysOutput = new \app\model\SysOutput;
        $list = $SysOutput->whereTime('create_time','between',[$s, $e])->select();
        $total = $SysOutput->whereTime('create_time','between',[$s, $e])->sum('output');
        $this->assign('list',$list);
        $this->assign('Ym',$Ym);
        $this->assign('total',$total?$total:0);
        return view("SystemFinance/outputList");
    }
}