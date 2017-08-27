<?php 
namespace app\system\controller;
use app\service\SystemService;
use app\model\Salaryin;

class Crontab{
	private $setting;
	private $schedule;
	private $modelSalary;
	public function _initialize() {
        $this->System = new SystemService();
        $this->setting = $this->System->getSite();
    }
	/**
	 * 自动结算课时薪资
	 */
	public function getSalary(){
		$n = 3;
		$t = time();
		$start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t))-(86400*$n);  //当天开始时间
		$end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t))-(86400*$n); //当天结束时间
		$scheduleList = db('schedule')->where(['status'=>1,'create_time'=>['BETWEEN',[$start_time,$end_time]]])->select();
		if($scheduleList){
			foreach ($scheduleList as $key => $value) {
				$coach_id = $value['coach_id'];
				$assistant_ids = $value['assistant_ids'];
				$coach_salary = $value['coach_salary'];
				$assistant_salary = $value['assistant_salary'];
				$salary_base = $value['salary_base'];
				$students = $value['students'];
				$star = $value['star'];
				//人头基数薪资
				$salaryOfBase = $salary_base*$students;
				// 教练薪资
				$coachSalary = ($salaryOfBase+$coach_salary)*(1-$this->setting['sysrebate'])+($salaryOfBase+$coach_salary)*$this->setting['starrebate']*$star/25;
				//助教薪资
				$assitantSalary = ($salaryOfBase+$assistant_salary)*(1-$this->setting['sysrebate'])+($salaryOfBase+$assistant_salary)*$this->setting['starrebate']*$star/25;
				// 分配教练练薪资
				$memberOfCoach = $this->getMemberByCoachId($coach_id);
				if($memberOfCoach){
					$data = array_merge($value,$memberOfCoach);
					unset($data['create_time']);
					unset($data['delete_time']);
					unset($data['status']);
					unset($data['update_time']);
					$data['type'] = 1;
					$data['member_type'] = 1;
					$this->allotSalary();
				}
				
				// 分配助教薪资
				$assistantIDS = $this->getAssitantList($assistant_ids);
				if($assistant_ids){
					foreach ($assistant_ids as $k => $val) {
						$memberIdOfAssitant = $this->getMemberByCoachId($val);
						if($memberAssitant){
							$this->allotSalary();
						}
					}
				}	
			}
		}
	}



	/**
	 * 获取助教列表
	 */
	private function getAssitantList($str){
		$assitantList = explode(',',$arr);
		return $assitantList?$assitantList:false;
	}

	private function getMemberByCoachId($coach_id){
		$member = db('coach')->where(['id'=>$coach_id])->find();
		return $member?$member:false;
	}

	/**
	 * 分配薪资记录数据
	 */
	private function allotSalary($data){
		$result = $this->modelSalary->allowField(true)->data($data)->save();
		if($result){
			// 给个人余额+钱
			$res = db('member')->where(['id'=>$data['member_id']])->setInc('balance',$data['salary']);
			file_put_contents(ROOT_PATH.'/data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['success'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
		}else{
			file_put_contents(ROOT_PATH.'/data/salaryin/'.date('Y-m-d',time()).'.txt',json_encode(['error'=>$data,'time'=>date('Y-m-d H:i:s',time())]));
		}		
	}


	/**
     * 参数:  
     * 递归分销人头返钱:用在教练获取薪资的时候,返回薪资
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
     * 业绩100%返回到2级人头
     */
    public function hpRebate(){
    	
    }
}