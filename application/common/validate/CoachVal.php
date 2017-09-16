<?php 
namespace app\common\validate;
use think\Validate;
class CampVal extends Validate{


    protected $rule = [
        'camp'  =>  'require|max:60|unique:camp,camp',
        'member_id' => 'require',
        'realname' =>  'require',
    ];
    
    protected $message = [
        'camp.require'  =>  '请输入训练营名',
        'camp.unique'   =>'训练营名称被占用',
        'member_id.require' => '缺少创建人会员ID',
        'realname.require' =>  '请输入创建者真实姓名',
    ];
    
    protected $scene = [
        'add'   =>  ['realname','member_id','camp'],
    ];    

}