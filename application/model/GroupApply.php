<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class GroupApply extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;


    public function getStatusAttr($value){
        $list = [1=>'申请中',2=>'已同意',-1=>'已拒绝'];
        return $list[$value];
    }


    public function member() {
        return $this->hasOne('member');
    }
}