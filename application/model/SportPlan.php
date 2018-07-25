<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class SportPlan extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function getEndAttr($value){
		if($value>99999){
			return date('Y-m-d',time());
		}else{
			return '无期限';
		}
	}


	public function getStartAttr($value){
		if($value>99999){
			return date('Y-m-d',time());
		}else{
			return '无期限';
		}
	}
}