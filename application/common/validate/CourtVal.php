<?php 
namespace app\common\validate;
use think\Validate;
class CourtVal extends Validate{


	protected $rule = [
        'court'  =>  'require|max:60',
        'member_id'	=> 'require',
        'province' =>  'require',
        'city' =>  'require',
        'area' =>  'require',
        'location' =>  'require',
        'open_time' =>  'require',
        'contract' =>  'require',
        'principal' =>  'require',
        'covers' =>  'require',
    ];
    
    protected $message = [
        'court.require'  =>  '请填写场地名称',
        'member_id.require'	=> '请登录平台',
        'province.require' =>  '请选择所属地区',
        'city.require' =>  '请选择所属地区',
        'area.require' =>  '请选择所属地区',
        'location.require' =>  '请填写具体地址',
        'open_time.require' =>  '请填写营业时间',
        'contract.require' =>  '请填写联系电话',
        'principal.require' =>  '请填写联系人',
        'covers.require' =>  '请上传场地图片',
    ];
    
    protected $scene = [
        'add'   =>  ['court','member_id','province','city','area','location','open_time','contract','principal','covers',],
        'edit'  =>  ['court','member_id','province','city','area','location','open_time','contract','principal','covers',],
    ];    

}