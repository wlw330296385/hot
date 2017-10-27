<?php 
namespace app\common\validate;
use think\Validate;
class EventVal extends Validate{


	protected $rule = [
        'event'        =>  'require|max:60',
        'event_type'	=> 'require',
        'end'           =>'require',
        'start'           =>'require',
        'province'              =>'require',
        'city'                  =>'require',
        'area'                  =>'require',
        'location'                 =>'require',
    ];
    
    protected $message = [
        'event.require'        =>  '请填写活动主题',
        'event_type.require'	=> '请填写活动类型',
        'start'           =>'活动时间必须大于当前时间',
        'end'   =>'活动时间必须大于当前时间',
        'province'              =>'请填写所属地区',
        'city'                  =>'请填写所属地区',
        'area'                  =>'请填写所属地区',
        'location'                 =>'请填写活动地点',
    ];
    
    protected $scene = [
        'add'   =>  ['event','event_type','start','end','province','city','area','location'],
        'edit'  =>  ['event_time'],
    ];    

}