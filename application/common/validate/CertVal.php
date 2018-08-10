<?php 
namespace app\common\validate;
use think\Validate;
class CertVal extends Validate{


	protected $rule = [
        'member_id'        =>  'require|egt:1',
        'cert_no'	=> 'require|unique:cert,cert_no',
        'cert_type'         => 'require',
    ];
    
    protected $message = [
        'member_id.egt'    => '请先注册',
        'member_id.require'        =>  '没指定会员号',
        'cert_no.require'	=> '证件号码必须',
        'cert.unique'       =>'证件号码已被使用',
        'cert_type'      =>  '证件类型必须',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','cert_no','cert_type'],
        'edit'  =>  ['member_id','cert_no','cert_type']
    ];    

}