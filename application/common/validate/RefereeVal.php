<?php 
namespace app\common\validate;
use think\Validate;
class RefereeVal extends Validate{


    protected $rule = [
        'referee'  =>  'require|max:60',
        'member_id'  =>  'require|gt:0',
        'appearance_fee' => 'number',
        'referee_year' => 'number',
        'level' => 'require',
        'province' => 'require',
    ];
    
    protected $message = [
        'referee.require'  =>  '请输入真实姓名',
        'member_id.require' => '请先登录或注册会员',
        'appearance_fee.number' => '执裁费用请输入数字',
        'referee_year.number' => '执裁经验请输入数字',
        'level.require' => '请选择裁判等级',
        'province.require' => '请选择接单地区范围'
    ];
    
    protected $scene = [
        'add'   =>  ['referee', 'member_id', 'appearance_fee', 'referee_year', 'level', 'province'],
        'edit'  =>  ['referee', 'member_id', 'appearance_fee', 'referee_year', 'level', 'province'],
    ];    

}