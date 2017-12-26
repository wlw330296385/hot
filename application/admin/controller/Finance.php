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
    public function _initialize(){
        parent::_initialize();
    }
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
        $list = Bill::where($map)->order('id desc')->paginate(15, false, ['query' => request()->param()]);
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
       /* $camp = input('camp');
        if ($camp) {
            $map['camp'] = ['like', '%'. $camp .'%'];
        }*/
        // 选择训练营
        $camp_id = input('camp_id');
        if ($camp_id) {
            $map['camp_id']=$camp_id;
        }
        /*$member = input('member');
        if ($member) {
            $map['member'] = ['like', '%'. $member .'%'];
        }*/
        // 工资结算月份
        $date = input('date');
        $curdate = date('Y-m');
        if ($date) {
            $dateArr = explode('-', $date);
            $when = getStartAndEndUnixTimestamp($dateArr[0], $dateArr[1]);
            $start = $when['start'];
            $end = $when['end'];
            $map['create_time'] = ['between', [$start, $end]];
            $curdate = $date;
        }
        $schedule_date = input('schedule_date');
        $curschedule_date = date('Y-m');
        if ($schedule_date) {
            $dateArr2 = explode('-', $schedule_date);
            $when2 = getStartAndEndUnixTimestamp($dateArr2[0], $dateArr2[1]);
            $start2 = $when2['start'];
            $end2 = $when2['end'];
            $map['schedule_time'] = ['between', [$start2, $end2]];
            $curschedule_date = $schedule_date;
        }

        $list = SalaryIn::with('schedule')->where($map)->order('id desc')->paginate(15, false, ['query' => request()->param()])->each(function($item, $key) {
            $item['lesson'] = db('lesson')->where(['id' => $item['lesson_id']])->find();
            return $item;
        });
//        dump($list->toArray());

        
        $this->assign('list', $list);
        $this->assign('camp_id', $camp_id);
        $this->assign('page', $list->render());
        $this->assign('curdate', $curdate);
        $this->assign('curschedule_date', $curschedule_date);
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

        $this->assign('salaryin', $salaryin);
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
        $curdate = date('Y-m');
        if ($date) {
            $dateArr = explode('-', $date);
            $when = getStartAndEndUnixTimestamp($dateArr[0], $dateArr[1]);
            $start = $when['start'];
            $end = $when['end'];
            $curdate = $date;
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
                    $bankCharges = $val['total']*0.006;
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
        $this->assign('curdate', $curdate);
        $this->assign('list', $listArr);
        $this->assign('sum', $sum);
        $this->assign('camp_id', $camp_id);
        return $this->fetch();
    }


    // 交费统计
    public function tuitionstatis() {
        // 查询筛选项接收
        $year = input('year');
        $curyear = date('Y');
        if ($year){
            //dump($year);
            $when = getStartAndEndUnixTimestamp($year);
            $startTime = $when['start'];
            $endTime = $when['end'];
            $curyear = $year;
        }
        $date = input('date');
        $curdate = date('Y-m');
        if ($date) {
            $dateArr = explode('-', $date);
            $when = getStartAndEndUnixTimestamp($dateArr[0], $dateArr[1]);
            $startTime = $when['start'];
            $endTime = $when['end'];
            $curdate = $date;
        }
        $start = input('start');
        $end = input('end');
        $cur_range = '';
        if ($start && $end) {
            $startDate = explode('-', $start);
            $endDate = explode('-', $end);
            $startWhen = getStartAndEndUnixTimestamp($startDate[0], $startDate[1]);
            $endWhen = getStartAndEndUnixTimestamp($endDate[0], $endDate[1]);
            $startTime = $startWhen['start'];
            $endTime = $endWhen['end'];
            $cur_range = $start.' - '.$end;
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
        //$map['balance_pay'] = ['>', 0];

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
        $this->assign('curdate', $curdate);
        $this->assign('curyear', $curyear);
        $this->assign('cur_range', $cur_range);
        return $this->fetch();
    }

    // 收益统计
    public function earings() {
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }

        $date = input('date');
        $curdate = date('Y-m');
        if ($date) {
            $dateArr = explode('-', $date);
            $when = getStartAndEndUnixTimestamp($dateArr[0], $dateArr[1]);
            $start = $when['start'];
            $end = $when['end'];
            $curdate = $date;
        } else {
            list($start, $end) = Time::Month();
        }
        $map['create_time'] = ['between', [$start, $end]];
        //dump($map);
        // 初始化输出结果数组：合计
        $sum = [
            'total_amount' => 0,
            'system_rebate' => 0,
            'camp_income' => 0,
            'schedule_salaryin' => 0,
            'schedule_salaryin_notsettle' => 0
        ];
        // 遍历所有训练营
        $campM = new \app\model\Camp();
        $camps = $campM->where(['status' => ['>', 0]])->field(['id', 'camp'])->order('id desc')->select()->toArray();
        $billModel = new \app\model\Bill();
        $scheduleModel = new \app\model\Schedule();
        foreach ($camps as $k => $camp) {
            $camps[$k]['total_amount'] = 0;
            $camps[$k]['system_rebate'] = 0;
            $camps[$k]['camp_income'] = 0;
            $camps[$k]['schedule_salaryin'] = 0;
            $camps[$k]['schedule_salaryin_notsettle']=0;
            $map['camp_id'] = $camp['id'];
            // 组合训练营相关订单查询条件
            $campbillMap=$map;
            $campbillMap['goods_type'] = 1;
            $campbillMap['balance_pay'] = ['>', 0];
            // 收费金额=课程交费总和-退费总和
            $campbillsum = $billModel->where($campbillMap)->sum('balance_pay');
            $refundBillsum= $billModel->where($campbillMap)->where(['status' => -2, 'refundamount' => ['>', 0]])->sum('balance_pay');
            if ($campbillsum) {
                if ($refundBillsum) {
                    $camps[$k]['total_amount'] = $campbillsum-$refundBillsum;
                } else {
                    $camps[$k]['total_amount'] = $campbillsum;
                }
                $sum['total_amount'] += $camps[$k]['total_amount'];
            }
            // 平台收费=收费金额*5%
            $camps[$k]['system_rebate'] = $camps[$k]['total_amount']*0.05;
            $sum['system_rebate'] += $camps[$k]['system_rebate'];
            // 训练营收入=收费金额-平台收费
            $camps[$k]['camp_income'] = $camps[$k]['total_amount']-$camps[$k]['system_rebate'];
            $sum['camp_income'] += $camps[$k]['camp_income'];
            // 已结算课时工资(上课应得课时费)
            $campScheduleSalayin = $scheduleModel->where($map)->where(['status' => 1,'is_settle' => 1])->sum('schedule_income');
            if ($campScheduleSalayin) {
                $camps[$k]['schedule_salaryin'] = $campScheduleSalayin;
                $sum['schedule_salaryin'] += $camps[$k]['schedule_salaryin'];
            }
            // 未结课时费=(上月未结金额+本月训练营收入-本月已结课时费)
            $nosettleSchedule = $scheduleModel->where($map)->where(['status' => 1,'is_settle' => 0])->group('camp_id')->select()->toArray();
            if ($nosettleSchedule) {
                foreach ($nosettleSchedule as $k2=> $schedule) {
//                    $notsettleSchedule[$k2]['schedule_income'] = 0;
                    // 课时正式学员人数
                    $numScheduleStudent = count(unserialize($schedule['student_str']));
                    $lesson = $lesson = Db::name('lesson')->where('id', $schedule['lesson_id'])->find();
                    // 课时收入
                    $incomeSchedule = $lesson['cost'] * $numScheduleStudent;
//                    $notsettleSchedule[$k2]['schedule_income']=$incomeSchedule;
                    $camps[$k]['schedule_salaryin_notsettle']+=$incomeSchedule;
                }
                $camps[$k]['schedule_salaryin_notsettle'] = $camps[$k]['schedule_salaryin_notsettle']+$camps[$k]['camp_income']-$camps[$k]['schedule_salaryin'];
                $sum['schedule_salaryin_notsettle'] += $camps[$k]['schedule_salaryin_notsettle'];
            }
        }

        $breadcrumb = ['title' => '收益统计', 'ptitle' => '财务'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('camps', $camps);
        $this->assign('sum', $sum);
        $this->assign('curdate', $curdate);
        return $this->fetch();
    }





    // 提现记录表
    public function salaryOutList(){
        $map=[];
        $member = input('member');
        if ($member) {
            $map['member'] = ['like', '%'. $member .'%'];
        }
        $SalaryOut = new \app\model\SalaryOut;
        $list = $SalaryOut->where($map)->paginate(15);
        $this->assign('list', $list);
        return view('finance/salaryOutList');
    }

    // 提现记录详情
    public function salaryOutInfo(){
        $salaryOut_id = input('salaryOut_id', 0);
        $SalaryOut = new \app\model\SalaryOut;
        $salaryOutInfo = $SalaryOut->where(['id'=>$salaryOut_id])->find();
        

        $this->assign('salaryOutInfo', $salaryOutInfo);
        return view('finance/salaryOutInfo');
    }


    // 手动添加提现记录
    public function createSalaryOut(){
        if(request()->isPost()){
            try{
                 $SalaryOutService = new \app\service\SalaryOutService;
                $data = input('post.');
                // 用户信息
                $memberInfo = db('member')->where(['id'=>$data['member_id']])->find();
                // 卡信息
                $bankcarInfo = db('bankcard')->where(['id'=>$data['bankcard_id']])->find();
                $data['tid'] = getTID($this->admin['id']);
                $data['member'] = $memberInfo['member'];
                $data['realname'] = $bankcarInfo['realname'];
                $data['telephone'] = $bankcarInfo['telephone'];
                $data['openid'] = $memberInfo['openid'];
                $data['bank_card'] = $bankcarInfo['bank_card'];
                $data['bank'] = $bankcarInfo['bank'];
                $data['bank_type'] = $bankcarInfo['bank_type'];
                $result = $SalaryOutService->saveSalaryOut($data);
                if($result['code'] == 200){
                    $this->success($result['msg']);
                }else{
                    $this->error($result['msg']);
                }
            }catch(Exception $e){
                $this->error($e->getMessage());
            }
           
        }else{
            // 选择收入对象
            $SalaryIn = new SalaryIn;
            $salaryInList = $SalaryIn->distinct('true')->field('member_id,member')->select();
            if($salaryInList){
                $salaryInList = $salaryInList->toArray();
            }else{
                $salaryInList = [];
            }
            $m = date('m',time());

            $mList = [];
            for ($i=$m; $i > 1; $i--) { 
                $mList[$i]['m'] = $i;
                $BeginDate= date('Y').'-'.$i.'-01';
                $mList[$i]['start'] = $BeginDate;
                $endDate = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
                $mList[$i]['end'] = $endDate;    
            }


            $this->assign('mList',$mList);

            $this->assign('salaryInList',$salaryInList);

            return view('finance/createSalaryOut');

        }
        
        
    }



    // 提现申请操作
    public function updateSalaryOut(){
        try{
            $salaryOut_id = input('param.salaryOut_id');
            $action = input('param.action');
            $SalaryOut = new \app\model\SalaryOut;
            switch ($action) {
                // 同意打款
                case '1':
                $data = [
                    'system_remarks'=>"[系统出账]id:{$this->admin['id']},admin:{$this->admin['username']};",
                    'pay_time'=>time(),
                    'is_pay'=>1,
                    'status'=>1
                    ];
                    $result = $SalaryOut->save($data,['id'=>$salaryOut_id]);
                    if($result){
                        $this->AuthService->record('提现申请出账');
                        $this->success('操作成功');
                    }else{
                        $this->error('操作失败');
                    }
                    
                    break;
                //拒绝打款
               case '2':
                    $data = [
                    'system_remarks'=>"[系统拒绝提现申请]id:{$this->admin['id']},admin:{$this->admin['username']};",
                    'is_pay'=>0,
                    'status'=>2,
                    ];
                    $result = $SalaryOut->save($data,['id'=>$salaryOut_id]);
                    if($result){
                        $this->AuthService->record('拒绝提现申请');
                        // 余额返回用户
                        $salaryOutInfo = $SalaryOut->where(['id'=>$salaryOut_id])->find();
                        db('member')->where(['id'=>$salaryOutInfo['member_id']])->setInc('balance',$salaryOutInfo['salary']);
                        $this->success('操作成功');
                    }else{
                        $this->error('操作失败');
                    }
                    
                    break;
                case 3:
                    $data = [
                    'system_remarks'=>"[系统对冲]id:{$this->admin['id']},admin:{$this->admin['username']};",
                    'is_pay'=>0,
                    'status'=>-1,
                    ];
                    $result = $SalaryOut->save($data,['id'=>$salary_id]);
                    $this->AuthService->record('提现对冲');
                    break;
            }


        }catch(Exception $e){
            $this->error($e->getMessage());
        }
    }

}
