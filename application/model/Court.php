<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Court extends Model {

	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
	public function getOutdoorsAttr($value){
		$outdoor = [0=>'室内',1=>'室外',2=>'室内|室外'];
		return $outdoor[$value];
	}
    public function getStatusAttr($value){
		$status = [-1=>'私有',0=>'待审核',1=>'系统公开'];
		return $status[$value];
    }

    public function court_camp(){
        return $this->hasOne('court_camp','id','camp_id');
    }
}