<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Schedule extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $type = [
        'status'    =>  'integer',
    ];


    protected $readonly = ['create_time'];
}
