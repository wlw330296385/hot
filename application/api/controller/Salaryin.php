<?php 
namespace app\api\controller;
use app\api\controller\Frontend;
use app\service\CampService;
use app\service\SalaryInService;
use think\Exception;
use think\helper\Time;
class Salaryin extends Base {
	private $SalaryInService;
	public function _initialize(){
		parent::_initialize();
		$this->SalaryInService = new SalaryInService($this->memberInfo['id']);
	}



    // 获取平均工资
    public function getAverageSalaryApi(){
        try{
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $startTime = time();
            $endTime = time();
            $result = $this->SalaryInService->getReabteByMonth($startTime,$endTime,$member_id);
            $avreageMonthSalary = $this->SalaryInService->getAverageSalaryByMonth($member_id,$camp_id);
            $averageYearSalary = $this->SalaryInService->getAverageSalaryByYear($member_id,$camp_id); 
            return json(['code'=>200,'msg'=>'ok','data'=>['avreageMonthSalary'=>$avreageMonthSalary,'averageYearSalary'=>$averageYearSalary]]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取列表带page
    public function getSalaryInListByPageApi(){
        try{
            $map = input('post.');
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $map['member_id'] = $member_id;
            $result = $this->SalaryInService->getSalaryInPagintor($map);
            
            return json(['code'=>200,'msg'=>'ok','data'=>$result]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取一个月的收入明细
    public function getSalaryInfoByMonthApi(){
        try{
            $start_end_str = input('start_end_str');
            if($start_end_str){
                $arr_start_end = explode(',', $start_end_str);
                $start = $arr_start_end[0];
                $end = $arr_start_end[1];
            }else{
                $start = input('start')?input('start'):date(strtotime('-1 month'));
                $end = input('end')?input('end'):date('Y-m-d',time());  
            }
            $startInt = strtotime($start);
            $endInt = strtotime($end);
            // dump($start);
            // dump($end);
            // dump($startInt);die;
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            // 组织分成分成:
            $rebateIn   = $this->SalaryInService->getReabteByMonth($startInt,$endInt,$member_id);
            $scheduleIn = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            // $sellsIn    = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            $sellsIn = 0;
            // $levelAward = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            // $rankAward  = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);  
            $levelAward = 0;
            $rankAward  = 0;  
            $totalSalary = $rebateIn+$scheduleIn+$sellsIn+$levelAward+$rankAward;
            return json(['code'=>200,'msg'=>'ok','data'=>['rebateIn'=>$rebateIn,'scheduleIn'=>$scheduleIn,'sellsIn'=>$sellsIn,'levelAward'=>$levelAward,'rankAward'=>$rankAward,'totalSalary'=>$totalSalary]]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 训练营工资列表
    public function campsalarylist(){
        try{
            // 接收参数：camp_id、要查询的时间段（年、月）默认当前年月
            // 是否存在训练营数据
            $camp_id = input('camp_id');
            if (!$camp_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'需要训练营信息']);
            }
            $campS = new CampService();
            $camp = $campS->getCampInfo($camp_id);
            if (!$camp) {
                return json(['code' => 100, 'msg' => '训练营'.__lang('MSG_404')]);
            }
            // 组合查询条件
            $map = [];
            // 判断当前会员在训练营是营主或教务获取营下所有教练工资/是教练只看自己的工资
            $campPower = getCampPower($camp_id, $this->memberInfo['id']);
            if (!$campPower) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').',你无权查看此训练营相关信息']);
            }
            if ($campPower > 2) {
                $memberIds = [];
                $coachs = $campS->getCoachList($camp_id);
                foreach ($coachs as $k => $coach) {
                    $memberIds[$k] = $coach['member_id'];
                }
                $map['member_id'] = ['in', $memberIds];
            } else {
                $map['member_id'] = $this->memberInfo['id'];
            }
            // 要查询的时间段（年、月），默认当前年月
            if (input('?param.year') || input('?param.month')) {
                // 判断年、月参数是否为数字格式
                $year = input('year', date('Y'));
                $month = input('month', date('m'));
                if (!is_numeric($year) || !is_numeric($month) ) {
                    return json(['code' => 100, 'msg' => '时间格式错误']);
                }
                // 根据传入年、月 获取月份第一天和最后一天，拼接时间查询条件
                //$when = $year.'-'.$month;
                //$start = date('Y-m-01', strtotime($when));
                //$end = date('Y-m-d', strtotime("$start +1 month -1 day"));
                //$map['schedule_time'] = ['between time', [$start, $end]];
                $when = getStartAndEndUnixTimestamp($year, $month);
                $map['create_time'] = ['between', [$when['start'], $when['end']]];
            } else {
                list($start, $end) = Time::month();
                $map['create_time'] = ['between', [$start, $end]];
            }
            $map['camp_id'] = $camp_id;
            $map['member_type'] = ['lt', 5];
            $map['type'] = 1;

            // 获取工资数据
            //$salaryList = $this->SalaryInService->getCampSalaryInList($map);
            $salaryinM = new \app\model\SalaryIn();
            $salaryList = $salaryinM->where($map)->field(['member','sum(salary+push_salary)' => 'month_salary', 'member_id'])->group('member_id')->select();
            //dump($salaryList);
            $salarySum = $this->SalaryInService->countSalaryin($map);
            if (!$salaryList) {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $salaryList->toArray(), 'sum' => $salarySum];
            }
            return json($response);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }        
    }

    // 教练工资列表明细
    public function coachSalaryinList() {
        try {
            // 传入参数
            $request = input('param.');
            // 组合查询条件
            $map = [];
            // 传入教练的会员id查询该教练会员工资 否则默认查询当前会员
            $map['member_id'] = isset($request['member_id']) ? $request['member_id'] : $this->memberInfo['id'];
            // 有参数camp_id 则查教练在该训练营的工资列表 否则查教练个人的工资列表
            if (isset($request['camp_id'])) {
                // 判断当前会员在训练营有无教练或以上身份，没有就抛出提示
                $campPower = getCampPower($request['camp_id'], $this->memberInfo['id']);
                if (!$campPower || $campPower < 2) {
                    return json(['code' => 100, 'msg' => __lang('MSG_403').',你无权查看此训练营相关信息']);
                }
                $map['camp_id'] = $request['camp_id'];
                // 如果训练营营主也是教练身份 也列出工资列表
                $coachIsCampPower4 = getCampPower($map['camp_id'], $map['member_id']);
                if ($coachIsCampPower4 && $coachIsCampPower4 != 4) {
                    $map['member_type'] = ['lt', 5];
                }
            }
            // 要查询的时间段（年、月），默认当前年月
            if (input('?param.year') || input('?param.month')) {
                // 判断年、月参数是否为数字格式
                $year = input('year', date('Y'));
                $month = input('month', date('m'));
                if (!is_numeric($year) || !is_numeric($month) ) {
                    return json(['code' => 100, 'msg' => '时间格式错误']);
                }
                // 根据传入年、月 获取月份第一天和最后一天，拼接时间查询条件
                //$when = $year.'-'.$month;
                //$start = date('Y-m-01', strtotime($when));
                //$end = date('Y-m-d', strtotime("$start +1 month -1 day"));
                //$map['schedule_time'] = ['between time', [$start, $end]];
                $when = getStartAndEndUnixTimestamp($year, $month);
                $map['create_time'] = ['between', [$when['start'], $when['end']]];
            } else {
                list($start, $end) = Time::month();
                $map['create_time'] = ['between', [$start, $end]];
            }

            $map['type'] = 1;
//            dump($map);
            // 获取工资数据
            $salaryList = $this->SalaryInService->getSalaryInList($map, 'create_time desc');
            $salarySum = $this->SalaryInService->countSalaryin($map);
            //dump($salaryList);
            if (!$salaryList) {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $salaryList, 'sum' => $salarySum];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 教练工资列表page
    public function coachSalaryinListPage() {
        try {
            // 传入参数
            $request = input('param.');
            // 组合查询条件
            $map = [];
            // 传入教练的会员id查询该教练会员工资 否则默认查询当前会员
            $map['member_id'] = isset($request['member_id']) ? $request['member_id'] : $this->memberInfo['id'];
            // 有参数camp_id 则查教练在该训练营的工资列表 否则查教练个人的工资列表
            if (isset($request['camp_id'])) {
                // 判断当前会员在训练营有无教练或以上身份，没有就抛出提示
                $campPower = getCampPower($request['camp_id'], $this->memberInfo['id']);
                if (!$campPower || $campPower < 2) {
                    return json(['code' => 100, 'msg' => __lang('MSG_403').',你无权查看此训练营相关信息']);
                }
                $map['camp_id'] = $request['camp_id'];
                // 如果训练营营主也是教练身份 也列出工资列表
                $coachIsCampPower4 = getCampPower($map['camp_id'], $map['member_id']);
                if ($coachIsCampPower4 && $coachIsCampPower4 != 4) {
                    $map['member_type'] = ['lt', 5];
                }
            }
            // 要查询的时间段（年、月），默认当前年月
            if (input('?param.y') || input('?param.m')) {
                // 判断年、月参数是否为数字格式
                $year = input('y');
                $month = input('m');
                if (!is_numeric($year) || !is_numeric($month) ) {
                    return json(['code' => 100, 'msg' => '时间格式错误']);
                }
                // 根据传入年、月 获取月份第一天和最后一天，拼接时间查询条件
                //$when = $year.'-'.$month;
                //$start = date('Y-m-01', strtotime($when));
                //$end = date('Y-m-d', strtotime("$start +1 month -1 day"));
                //$map['schedule_time'] = ['between time', [$start, $end]];
                $when = getStartAndEndUnixTimestamp($year, $month);
                $map['schedule_time'] = ['between', [ $when['start'], $when['end'] ]];
            } else {
                list($start, $end) = Time::month();
                $map['schedule_time'] = ['between', [$start, $end]];
            }

            $map['type'] = 1;
//            dump($map);
            // 获取工资数据
            $salaryList = $this->SalaryInService->getSalaryInPagintor($map, 'schedule_time desc');
            $salarySum = $this->SalaryInService->countSalaryin($map);
            //dump($salaryList);
            if (!$salaryList) {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $salaryList, 'sum' => $salarySum];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}