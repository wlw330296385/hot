<?php 
namespace app\api\model;
use think\Model;

class Bill extends{

	protected $type = [
        'status'    =>  'integer',
        'fee'     =>  'float',
        'salary'  =>  'float',
        'callback_str'      =>  'json',
    ];


    protected $readonly = ['create_time'];
}

