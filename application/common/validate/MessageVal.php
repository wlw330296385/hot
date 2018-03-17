<?php 
namespace app\common\validate;
use think\Validate;
class MessageVal extends Validate{


	protected $rule = [
        'title'  =>  'require|max:240',
    ];
    
    protected $message = [
        'title.require'  =>  '标题必须',
        'title.max' =>'标题长度不正确',
    ];
    
    protected $scene = [
        'add'   =>  ['title'],
        'edit'  =>  ['title'],
    ];    

}