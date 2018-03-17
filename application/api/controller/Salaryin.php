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



    public function getAverageSalaryApi(){
        try{
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $result = $this->SalaryInService->getReabteByMonth('8',2);
            $avreageMonthSalary = $this->SalaryInService->getAverageSalaryByMonth(2);
            $averageYearSalary = $this->SalaryInService->getAverageSalaryByYear(2); 
            return json(['code'=>200,'msg'=>'ok','data'=>['avreageMonthSalary'=>$avreageMonthSalary,'averageYearSalary'=>$averageYearSalary]]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function getSalaryInfoByMonthApi(){
        try{
            $start = input('start')?input('start'):date(strtotime('-1 month'));
            $end = intpu('end')?input('end'):date('Y-m-d',time());
            $startInt = strtotime($start);
            $endInt = strtotime($end);
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            // 组织分成分成:
            $rebateIn   = $this->SalaryInService->getReabteByMonth($startInt,$endInt,$member_id);
            $scheduleIn = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            $sellsIn    = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            $levelAward = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);
            $rankAward  = $this->SalaryInService->getSalaryByMonth($startInt,$endInt,$member_id);   
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
                $when = $year.'-'.$month;
                $start = date('Y-m-01', strtotime($when));
                $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
                $map['create_time'] = ['between time', [$start, $end]];
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
            // 组合查询条件
            $map = [];
            // 有参数camp_id 则查教练在该训练营的工资列表 否则查教练个人的工资列表
            if (input('?camp_id')) {
                $camp_id = input('camp_id');
                // 判断当前会员在训练营有无教练或以上身份，没有就抛出提示
                $campPower = getCampPower($camp_id, $this->memberInfo['id']);
                if (!$campPower || $campPower < 2) {
                    return json(['code' => 100, 'msg' => __lang('MSG_403').',你无权查看此训练营相关信息']);
                }
                $map['camp_id'] = $camp_id;
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
                $when = $year.'-'.$month;
                $start = date('Y-m-01', strtotime($when));
                $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
                $map['create_time'] = ['between time', [$start, $end]];
            } else {
                list($start, $end) = Time::month();
                $map['create_time'] = ['between', [$start, $end]];
            }
            $map['member_id'] = $this->memberInfo['id'];
            $map['member_type'] = ['lt', 5];
            $map['type'] = 1;
//            dump($map);
            // 获取工资数据
            $salaryList = $this->SalaryInService->getSalaryInList($map);
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