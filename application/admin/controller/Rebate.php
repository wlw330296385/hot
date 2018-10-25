<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;


use think\Db;

class Rebate extends Backend {
    public $setting;


    public function _initialize() {
        parent::_initialize();
        $this->setting = db('setting')->find();
    }
    // 推荐奖列表
    public function rebateList() {
        $map = [];
        $keyword = input('param.keyword');
        $Ym = input('param.Ym',date('Y-m',time()));

        $datemonth = date('Ym',strtotime($Ym));

        $map['datemonth'] = $datemonth;
        if ($keyword) {
            $map['s_member|memebr'] = ['like', '%'. $keyword .'%'];
        }
        $member_id = input('param.member_id');
        if($member_id){
            $map['s_member_id'] = $member_id;
        }
 
        $list = db('rebate')->where($map)->order('id desc')->select();
        $rebateList = [];
        $tier2List = [];
        $tier1List = [];
        //先拿到tier==1的tier
        foreach ($list as $key => $value) {
            if($value['tier']==1){
                $tier1List[] = $value;
            }
        }
        // 再拿到tier==2的tier
        foreach ($list as $key => $value) {
            if($value['tier']==2){
                $tier2List[] = $value;
            }
        }
        // 2<-1<-0,再把第2层的tier塞到第1层
        foreach ($tier1List as $key => $value) {
            foreach ($tier2List as $k => $val) {
                
                if($val['key_id']==$value['key_id']){
                    $tier1List[$key]['ss'] = $val;
                }
            }
        }

        // die();
        $this->assign('Ym',$Ym);
        $this->assign('rebateList', $tier1List);
        return view('Rebate/rebateList');
    }




    //校园课的推荐费列表
    public function campRebate(){
        $camp_id = input('param.camp_id',9);
        $Ym = input('param.Ym',date('Y-m',strtotime('last month')));

        $datemonth = date('Ym',strtotime($Ym));
        if($datemonth==date('Ym',time())){
            $this->error('本月账单未出帐,请于次月1号查询');
        }
        $map1['datemonth'] = $datemonth;
        $map1['camp_id'] = $camp_id;
        $list = db('rebate_camp')->where($map1)->order('id desc')->select();
        //没有数据则生成数据
        if(!$list){
            // $map['status'] = 1;
            // $map['has_rebate'] = 0;
            $map['salary|push_salary'] = ['>',0];
            $date_str = $datemonth."01";
            $map['camp_id'] = $camp_id;

            $b = new \DateTime($Ym);
            $s = $b->format('Y-m-01');
            $b->add(new \DateInterval('P1M'));
            $e = $b->format('Y-m-01');
            $salaryinList = DB::name('salary_in')
                        ->field(['member_id','id','member','sum(salary)+sum(push_salary)'=>'total_salary'])
                        ->where($map)
                        ->whereTime('create_time', 'between', [$s, $e])
                        ->group('member_id')
                        ->where('delete_time', null)
                        ->order('id desc')
                        ->select();       
            $s_ids = [];
            foreach ($salaryinList as$key=> $value) {

                if ($value['total_salary'] >0 ){
                    $res = $this->insertRebate($value['member_id'], $value['total_salary'], $datemonth,$date_str,$key,$camp_id);
                }
            }
            $list = db('rebate_camp')->where($map1)->order('id desc')->select();
        }
        $tier2List = [];
        $tier1List = [];
        //先拿到tier==1的tier
        foreach ($list as $key => $value) {
            if($value['tier']==1){
                $tier1List[] = $value;
            }
        }
        // 再拿到tier==2的tier
        foreach ($list as $key => $value) {
            if($value['tier']==2){
                $tier2List[] = $value;
            }
        }
        // 2<-1<-0,再把第2层的tier塞到第1层
        foreach ($tier1List as $key => $value) {
            foreach ($tier2List as $k => $val) {
                
                if($val['key_id']==$value['key_id']){
                    $tier1List[$key]['ss'] = $val;
                }
            }
        }

        // die();
        $this->assign('Ym',$Ym);
        $this->assign('rebateList', $tier1List);
        return view('Rebate/rebateList');
    }








     // 保存会员分成记录
    private function insertRebate($member_id, $total_salary, $datemonth,$date_str,$key_id,$camp_id) {
        $MemberService = new \app\service\MemberService();
        $RebateCamp = new \app\model\RebateCamp();
        $memberPiers = $MemberService->getMemberTier($member_id);
        if (!empty($memberPiers)) {
            foreach ($memberPiers as $k => $val) {
                if ($val['tier']==1) {
                    $memberPiers[$k]['salary'] = $total_salary*$this->setting['rebate'];
                } elseif ($val['tier']==2){
                    $memberPiers[$k]['salary'] = $total_salary*$this->setting['rebate2'];
                }
                $memberPiers[$k]['datemonth'] = $datemonth;
                $memberPiers[$k]['date_str'] = $date_str;
                $memberPiers[$k]['total_salary'] = $total_salary;
                $memberPiers[$k]['key_id'] = $key_id;
                $memberPiers[$k]['camp_id'] = $camp_id;
            }

            $execute = $RebateCamp->allowField(true)->saveAll($memberPiers);
        }
    }
}