<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\SalaryOutService;
class SalaryOut extends Base{
	private $SalaryOutService;
	public function _initialize(){
		parent::_initialize();
		$this->SalaryOutService = new SalaryOutService($this->memberInfo['id']);
	}



    // 不分页获取记录
    public function getSalaryoutListApi(){
        try{
            $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
            $map = ['member_id'=>$member_id];
            // $start = input('start')?input('start'):date(strtotime('-1 month'));
            // $end = input('end')?input('end'):date('Y-m-d',time());
            $start = input('param.start');
            $end = input('param.end');
            if($start && $end){
                $startInt = strtotime($start);
                $endInt = strtotime($end);
                $map['create_time'] = ['BETWEEN',[$startInt,$endInt]]; 
            }
            $salaryList = $this->SalaryOutService->getSalaryOutList($map);
            if($salaryList){
                return json(['code'=>200,'msg'=>'ok','data'=>$salaryList]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }        
    }

    // 获取提现记录带分页page
    public function getSalaryoutListByPageApi(){
        try{
            $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
            $map = ['member_id'=>$member_id];
            // $start = input('start')?input('start'):date(strtotime('-1 month'));
            // $end = input('end')?input('end'):date('Y-m-d',time());
            $start = input('param.start');
            $end = input('param.end');
            if($start && $end){
                $startInt = strtotime($start);
                $endInt = strtotime($end);
                $map['create_time'] = ['BETWEEN',[$startInt,$endInt]]; 
            }
            $salaryList = $this->SalaryOutService->getSalaryOutListByPage($map);
            if($salaryList){
                return json(['code'=>200,'msg'=>'ok','data'=>$salaryList->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }        
    }

    //提现申请
    public function applySalaryOut(){
        try{
            $data = input('post.');
            $day = date('d',time());
            if($day>15 || $daya<5){
                return json(['code'=>100,'msg'=>'每月5号至15号可申请提现']);die;
            }
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