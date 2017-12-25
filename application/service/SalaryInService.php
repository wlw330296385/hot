<?php
namespace app\service;
use app\model\SalaryIn;
use app\model\Rebate;
use app\common\validate\SalaryInVal;
use app\model\SystemAward;
// use think\Db;
class SalaryInService {

    private $SalaryIn;
    private $setting;
    private $memberInfo;
    private $Rebate;
    private $SystemAward;
    public function __construct($memberId)
    {
        $this->SalaryIn = new SalaryIn;
        $this->Rebate = new Rebate;
        $this->SystemAward = new SystemAward;
        $this->setting = db('setting')->find(1);
        $this->memberInfo = db('member')->find($memberId);
    }

    public function getSalaryIn($map){
        $result = $this->SalaryIn->with('lesson')->where($map)->find();
        return $result;
    }


    // 获取工资列表
    public function getSalaryInList($map = [],$order = 'id DESC'){
        $res = $this->SalaryIn->where($map)->order($order)->select();
        if($res){
            // 数据集转换为数组
            $result = $res->toArray();
            // 数据字段内容格式转换
            foreach ($result as $k => $val) {
                // 课时上课时间(schedule_time)格式化
                if ($val['schedule_time']) {
                    $result[$k]['schedule_time'] = date('Y-m-d H:i', $val['schedule_time']);
                }
            }
            return $result;
        }else{
            return $res;
        }
    }

    /**
     * 参数:  
     * 递归分销
     */
    public function memberSalaryRebate($pid,$salary,$salary_id,$sid,$s_member,$times = 1){
        
        if($times>2){
            return true;
        }
        
        $member = db('member')->find($pid);
        if($member){
            $times++;
            if($times == 1){
                $rebate = $this->setting['rebate'];
            }else{
                $rebate = $this->setting['rebate2'];
            }
            $pidSalary  = $salary*$rebate;
            $data = ['salary'=>$pidSalary,'sid'=>$sid,'s_member'=>$s_member,'member_id'=>$member['id'],'member'=>$member['member'],'salary_id'=>$salary_id,'tier'=>$times,'create_time'=>time()];
            $result = db('rebate')->insert($data);
            if($result){
                db('member')->where(['id'=>$pid])->setInc('balance',$pidSalary);
                file_put_contents(ROOT_PATH.'/data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                // file_put_contents(ROOT_PATH.'data\rebate\2017-08-15.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                if($member['pid']>1){ 
                    $res = $this->memberSalaryRebate($member['pid'],$salary,$salary_id,$member['id'],$member['realname'],$times);
                    
                }else{
                    return true;
                }
            }else{
                file_put_contents(ROOT_PATH.'/data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                return false;
            }
        }else{
            return false;
        }
    }



    /**
     * 课时结算佣金
     * 参数:  $data = ['salary','camp_id','camp','star','lesson_id','lesson']
     */
    public function scheduleRebate($data){
        $sysrebate = $this->setting['sysrebate'];
        $starrebate = $this->setting['starrebate'];
        $salary = $data['salary'];
        $star = $data['star'];
        $totalSalary = $data['salary']*(1-$sysrebate-$starrebate*(1-$star/100));
        $data['realname']   = $this->memberInfo['realname'];
        $data['member']     = $this->memberInfo['member'];
        $data['member_id']  = $this->memberInfo['id'];
        $data['pid']        = $this->memberInfo['pid'];
        $data['level']      = $this->memberInfo['level'];
        $data['member_type']= 1;
        $res = $this->SalaryIn->data($data)->save();
            if($res){
                $result = $this->memberSalaryRebate($this->memberInfo['pid'],$totalSalary,$res,$this->memberInfo['id'],$this->memberInfo['realname']);
                file_put_contents(ROOT_PATH.'/data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                return true;
            }else{
                file_put_contents(ROOT_PATH.'/data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                return false;
            }
        
    }

    /**
     * 统计一个月的工资
     */
    public function getSalaryByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == 0){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endTime){
            $endTime = time();
        }
        $scheduleIn = $this->SalaryIn
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endTime]]])
                    ->sum('salary');
        $push_salary = $this->SalaryIn
        ->where(['member_id'=>$member_id])
        ->where(['create_time'=>['between',[$startTime,$endTime]]])
        ->sum('push_salary');
        $total = $scheduleIn+$push_salary;
        return $total?$total:0;
    }

    // 按月获取系统奖励总额
    public function getSystemawardByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == ''){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endTime){
            $endTime = time();
        }
        $rebateIn = $this->SystemAward
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endTime]]])
                    ->sum('salary');
        return $rebateIn?$rebateIn:0;
    }

    // 获取分成奖励
    public function getReabteByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == 0){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endTime){
            $endTime = time();
        }
        $rebateIn = $this->Rebate
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endTime]]])
                    ->sum('salary');
        return $rebateIn?$rebateIn:0;
    }

    // 获取销售提成
    public function getSellslByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == 0){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endTime){
            $endTime = time();
        }
    }

    // 获取平均工资月收入
    public function getAverageSalaryByMonth($member_id,$camp_id){
        $maxTime = time();
        $minTime = $this->memberInfo['create_time'];
        $months = getMonthInterval($minTime,$maxTime);
        $totalSalary = $this->SalaryIn->where(['status'=>1,'member_id'=>$member_id,'camp_id'=>$camp_id])->sum('salary');
        $averageSalary = floatval(($totalSalary)/$months);
        return $averageSalary?$averageSalary:0;
    }

    // 获取平均所有月收入
    public function getAverageIncomeByMonth($member_id){
        $maxTime = time();
        $minTime = $this->memberInfo['create_time'];
        $months = getMonthInterval($minTime,$maxTime);
        $totalSalary = $this->SalaryIn->where(['status'=>1,'member_id'=>$member_id])->sum('salary');
        $totalRebate = $this->Rebate->where(['member_id'=>$member_id])->sum('salary');
        $totalSells = db('sells')->where(['member_id'=>$member_id])->sum('salary');
        $totalSystemAward = $this->SystemAward->where(['member_id'=>$member_id])->sum('salary');
        $averageSalary = floatval(($totalSalary+$totalRebate+$totalSells+$totalSystemAward)/$months);
        return $averageSalary?$averageSalary:0;
    }

    //获取平均所有年薪
    public function  getAverageIncomeByYear($member_id){
        $maxTime = time();
        $minTime = $this->memberInfo['create_time'];
        $years = getYearInterval($minTime,$maxTime);
        $totalSalary = $this->SalaryIn->where(['status'=>1,'member_id'=>$member_id])->sum('salary');
        $totalRebate = $this->Rebate->where(['member_id'=>$member_id])->sum('salary');
        $totalSells = db('sells')->where(['member_id'=>$member_id])->sum('salary');
        $totalSystemAward = $this->SystemAward->where(['member_id'=>$member_id])->sum('salary');
        $averageSalary = floatval(($totalSalary+$totalRebate+$totalSells+$totalSystemAward)/$years);
        return $averageSalary?$averageSalary:0;
    }

    //获取平均工资年薪
    public function  getAverageSalaryByYear($member_id,$camp_id){
        $maxTime = time();
        $minTime = $this->memberInfo['create_time'];
        $years = getYearInterval($minTime,$maxTime);
        $totalSalary = $this->SalaryIn->where(['status'=>1,'member_id'=>$member_id,'camp_id'=>$camp_id])->sum('salary');
        $averageSalary = floatval(($totalSalary)/$years);
        return $averageSalary?$averageSalary:0;
    }

    //获取教学分成列表
    /*public function getSalaryList($startTime,$endTime,$map,$page = 1,$paginate = 10){
        $res = $this->SalaryIn
                    ->where($map)
                    ->where(['create_time'=>['between',[$startTime,$endTime]]])
                    ->page($page,$paginate)
                    ->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }*/

    // 获取销售提成列表
    public function getGoodsSellList($startTime,$endTime,$member_id = 0,$page = 1,$paginate = 10){
        $res = $this->SalaryIn
                    ->where(['member_id'=>$member_id,'type'=>2])
                    ->where(['create_time'=>['between',[$startTime,$endTime]]])
                    ->page($page,$paginate)
                    ->select();
         if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }

    // 获取组织收入列表
    public function getRebateList($startTime,$endTime,$member_id = 0,$page = 1,$paginate = 10){
        $res = $this->Rebate
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endTime]]])
                    -page($page,$paginate)
                    ->select();
         if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }


    // 统计工资总额
    public function countSalaryin($map){
        $result = $this->SalaryIn->where($map)->sum('salary+push_salary');
        return $result?$result:0;
    }

}