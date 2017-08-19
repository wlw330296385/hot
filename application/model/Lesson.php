<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Lesson extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $readonly = [
							'create_time',
							];

    public function getStatusAttr($value){
        $status = [0=>'已结束',1=>'正常'];
        return $status[$value];
    }
	// 关联场地表
	public function court(){
		return $this->hasOne('court','court_id','id',[],'LEFT JOIN')->field('province,city,area,location,principal,contract,chip_rent,full_rent,half_rent');
	}
}