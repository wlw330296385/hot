<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class SalaryIn extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;

//    protected $readonly = ['create_time'];


    public function getMemberTypeAttr($value){
    	$arr = [4=>'教练',3=>'副教练',5=>'机构'];
    	return $arr[$value];
    }

}

