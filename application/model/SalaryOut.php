<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class SalaryOut extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $type = [
        
    ];
    protected $autoWriteTimestamp = true;

    protected $readonly = ['create_time'];

    public function getBankTypeAttr($value){
    	$BankType = ['1'=>'银行卡',2=>'支付宝'];
    	return $BankType[$value];
    }

    public function getStatusAttr($value){
    	$BankType = ['0'=>'申请中',1=>'已支付',2=>'被取消','-1'=>'对冲'];
    	return $BankType[$value];
    }

    public function getIsPayAttr($value){
        $BankType = ['0'=>'未支付',1=>'已支付'];
        return $BankType[$value];
    }

}

