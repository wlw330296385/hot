<?php 
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class BonusMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function Bonus(){
		return $this->hasOne('bonus','id','bonus_id',[],'LEFT JOIN');
	}
}