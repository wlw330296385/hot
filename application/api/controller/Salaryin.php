<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\SalaryInService;
class Salaryin extends Base{
	private $SalaryInService;
	public function __construct(){
		parent::__construct();
		$this->SalaryInService = new SalaryInService($this->memberInfo['id']);
	}



    public function getAverageSalaryApi(){
        try{
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $result = $this->SalaryInService->getReabteByMonth('8',2);
            $avreageMonthSalary = $this->SalaryInService->getAverageSalaryByMonth(2);
            $averageYearSalary = $this->SalaryInService->getAverageSalaryByYear(2); 
            return json(['code'=>100,'msg'=>'ok','data'=>['avreageMonthSalary'=>$avreageMonthSalary,'averageYearSalary'=>$averageYearSalary]]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
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
            return json(['code'=>100,'msg'=>'ok','data'=>['rebateIn'=>$rebateIn,'scheduleIn'=>$scheduleIn,'sellsIn'=>$sellsIn,'levelAward'=>$levelAward,'rankAward'=>$rankAward,'totalSalary'=>$totalSalary]]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }



    public function salaryListApi(){
        try{

            $start = input('start')?input('start'):date(strtotime('-1 month'));
            $end = intpu('end')?input('end'):date('Y-m-d',time());
            $page = input('param.page')?input('param.page'):1;
            $startInt = strtotime($start);
            $endInt = strtotime($end);
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $salaryList = $this->Salaryin->getSalaryList($startInt,$endInt,['member_id'=>$member_id],$page);
            return json(['code'=>100,'msg'=>'ok','data'=>$salaryList]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }        
    }

    
}