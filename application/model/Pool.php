<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Pool extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //    


	public function getStartAttr($value){
		return date('Y-m-d',$value);
	}

	public function getEndAttr($value){
		return date('Y-m-d',$value);
	}
}