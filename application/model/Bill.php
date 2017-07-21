<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Bill extends{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $type = [
        'status'    =>  'integer',
        'fee'     =>  'float',
        'salary'  =>  'float',
        'callback_str'      =>  'json',
    ];


    protected $readonly = ['create_time'];
}

