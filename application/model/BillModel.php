<?php 
namespace app\model;
use think\Model;

class BillModel extends{

	protected $type = [
        'status'    =>  'integer',
        'fee'     =>  'float',
        'salary'  =>  'float',
        'callback_str'      =>  'json',
    ];


    protected $readonly = ['create_time'];
}

