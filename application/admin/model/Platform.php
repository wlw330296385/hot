<?php 
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Platform extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];


}