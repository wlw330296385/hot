<?php 
namespace app\common\validate;
use think\Validate;
class CampVal extends Validate{


	protected $rule = [
        'camp'  =>  'require|max:60|unique:camp,camp',
        'member_id'	=> 'require',
        'realname' =>  'require',
        'province' => 'require',
        'city' => 'require',
        'area' => 'require',
    ];
    
    protected $message = [
        'camp.require'  =>  '请输入训练营名称',
        'camp.unique'   =>'训练营名称被占用',
        'member_id.require'	=> '请先注册会员',
        'realname.require' =>  '请输入创建者真实姓名',
        'province.require' => '请选择所属地区',
        'city.require' => '请选择所属地区',
        'area.require' => '请选择所属地区',
    ];
    
    protected $scene = [
        'add'   =>  ['realname','member_id','camp','province','city','area'],
        'edit' => ['id']
    ];    

}