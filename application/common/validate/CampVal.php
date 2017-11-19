<?php 
namespace app\common\validate;
use think\Validate;
class CampVal extends Validate{


	protected $rule = [
	    'id' => 'require',
        'camp'  =>  'require|max:60|unique:camp,camp',
        'member_id'	=> 'require',
        'realname' =>  'require',
    ];
    
    protected $message = [
        'id.require' => '无此训练营记录',
        'camp.require'  =>  '请输入训练营名称',
        'camp.unique'   =>'训练营名称被占用',
        'member_id.require'	=> '请先注册会员',
        'realname.require' =>  '请输入创建者真实姓名',
    ];
    
    protected $scene = [
        'add'   =>  ['realname','member_id','camp'],
        'edit' => ['id']
    ];    

}