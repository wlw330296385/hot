<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Recruitment extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            ];


    public function getStatusAttr($value){
    	$status = [1=>'上架',2=>'下架'];
    	return $status[$value];
    }

}