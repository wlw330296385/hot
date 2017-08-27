<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\SalaryOut;
class Member extends Base{
	private $SalaryOut;
	public function _initialize(){
		parent::_initialize();
		$this->SalaryOut = new SalaryOut;
	}

    public function index() {

      
    }


    // 提现申请
    public function withdrawApi(){
    	try{
    		$data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            // 余额
            if($memberInfo['balance']<$data['money']){
                return json(['code'=>200,'msg'=>'余额不足']);die;
            }
	    	$result = $this->SalaryOut->saveSalaryOut($data);
	    	return json($result);
    	}catch (Exception $e){
    		return json(['code'=>200,'msg'=>$e->getMessage()]);
    	}
    	
    }


    //添加银行卡
    public function createBankCardApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->SalaryOut->saveSalaryOut();
            return json($result);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }
}