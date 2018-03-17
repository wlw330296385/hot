<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class SalaryIn extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $type = [
        
    ];
    protected $autoWriteTimestamp = true;

    protected $readonly = ['create_time'];


    public function getMemberTypeAttr($value){
    	$arr = [1=>'教练',2=>'班主任',3=>'领队',4=>'副教练',5=>'机构'];
    	return $arr[$value];
    }

}

