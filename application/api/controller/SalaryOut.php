<?php 
namespace app\api\controller;
use app\api\controller\Frontend;
use app\service\SalaryOutService;
class SalaryOut extends Frontend{
	private $SalaryOutService;
	public function _initialize(){
		parent::_initialize();
		$this->SalaryOutService = new SalaryOutService($this->memberInfo['id']);
	}




    public function getSalaryoutListApi(){
        try{
            $start = input('start')?input('start'):date(strtotime('-1 month'));
            $end = intpu('end')?input('end'):date('Y-m-d',time());
            $startInt = strtotime($start);
            $endInt = strtotime($end);
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $salaryList = $this->SalaryOut->getSalaryList($startInt,$endInt,$member_id);
            return json(['code'=>200,'msg'=>'ok','data'=>$salaryList]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }        
    }

    //提现申请
    public function applySalaryOut(){
        try{
            $data = input('post.');
            if($this->memberInfo['balance']<$data['salary'] || $data['salary']<0){
                return json(['code'=>100,'msg'=>'余额不足']);die;
            }
            $data['member'] = $this->memberInfo['member'];
            $data['member_id'] = $this->memberInfo['id'];
            $data['telephone'] = $this->memberInfo['telephone'];
            $data['openid'] = $this->memberInfo['openid'];
            $result = $this->SalaryOutService->saveSalaryOut($data);
            return $result;
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   
    }
}