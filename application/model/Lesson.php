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


	// 关联场地表
	public function court(){
		return $this->hasOne('court','court_id','id',[],'LEFT JOIN')->field('province,city,area,location,principal,contract,chip_rent,full_rent,half_rent');
	}
}