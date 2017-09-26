<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class CourtCamp extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'status',
                            ];


    public function getStatusAttr($value){
        $status = [0=>'待审核',1=>'正常'];
        return $status[$value];
    }


    public function court(){
        return $this->hasOne('court','court_id','id');
    }
}