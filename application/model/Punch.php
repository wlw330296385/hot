<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Punch extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];





    public function pool() {
        return $this->hasOne('pool','id','pool_id',[],'LEFT');
    }

    // 多对多
    public function group() {
        return $this->belongsTo('member');
        // $data = $model->Classes()->wherePivot('school_id', '=', $school_id)->where(['classes' => 1, 'status' => 1])->select();wherePivot（设置中间表的查询条件） 使用这个，手册可能没写，在源码中找到的
    }
}