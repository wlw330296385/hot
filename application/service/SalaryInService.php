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


    // 获取订单列表
    public function getSalaryInList($map,$p = 10,$order = 'id DESC'){
        $result = $this->SalaryIn->where($map)->order('id DESC')->paginate($p);
        return $result;
    }

    /**
     * 参数:  
     * 递归分销
     */
    public function memberSalaryRebate($pid,$salary,$salary_id,$times = 1){
        
        if($times>3){
            return true;
        }
        
        $member = db('member')->find($pid);
        if($member){
            $times++;
            $pidSalary  = $salary*$this->setting['rebate'];
            $data = ['salary'=>$pidSalary,'pid'=>$member['pid'],'member_id'=>$member['id'],'member'=>$member['member'],'salary_id'=>$salary_id,'tier'=>$times,'create_time'=>time()];
            $result = db('rebate')->insert($data);
            if($result){
                db('member')->where(['id'=>$pid])->setInc('balance',$pidSalary);
                file_put_contents(ROOT_PATH.'/data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                if($member['pid']>1){ 
                    $res = $this->memberRebate($member['pid'],$pidSalary,$salary_id,$times);
                    
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
        $data['member_id']  = $this->memberInfo['id'];
        $data['pid']        = $this->memberInfo['pid'];
        $data['level']      = $this->memberInfo['level'];
        $data['member_type']= 1;
        $res = $this->SalaryIn->data($data)->save();
            if($res){
                $result = $this->memberSalaryRebate($this->memberInfo['pid'],$totalSalary,$res);
                file_put_contents(ROOT_PATH.'/data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                return true;
            }else{
                file_put_contents(ROOT_PATH.'/data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
                return false;
            }
        
    }

    /**
     * 
     */
    public function getSalaryByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == 0){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endtTime){
            $endtTime = time();
        }
        $scheduleIn = $this->SalaryIn
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endtTime]]])
                    ->sum('salary');
        echo $this->SalaryIn->getlastsql();
        return $scheduleIn?$scheduleIn:0;
    }

    // 按月获取系统奖励总额
    public function getSystemawardByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == ''){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endtTime){
            $endtTime = time();
        }
        $rebateIn = $this->SystemAward
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endtTime]]])
                    ->sum('salary');
        return $rebateIn?$rebateIn:0;
    }

    // 获取分成奖励
    public function getReabteByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == 0){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endtTime){
            $endtTime = time();
        }
        $rebateIn = $this->Rebate
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endtTime]]])
                    ->sum('salary');
        return $rebateIn?$rebateIn:0;
    }

    // 获取销售提成
    public function getSellslByMonth($startTime,$endTime,$member_id = 0){
        if($member_id == 0){
            $member_id = $this->memberInfo['id'];
        }
        if(!$endtTime){
            $endtTime = time();
        }
    }


    // 获取平均月收入
    public function getAverageSalaryByMonth($member_id){
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

    //获取平均年薪
    public function  getAverageSalaryByYear($member_id){
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

    //获取教学分成列表
    public function getSalaryList($startTime,$endTime,$member_id = 0){
        $salaryList = $this->salaryin
                    ->where(['member_id'=>$member_id])
                    ->where(['create_time'=>['between',[$startTime,$endTime]]])
                    ->paginate(10)
                    ->toArray();
        return $salaryList;
    }
}