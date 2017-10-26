<?php 
namespace app\common\validate;
use think\Validate;
class EventVal extends Validate{


	protected $rule = [
        'event'        =>  'require|max:60',
        'event_type'	=> 'require',
        'price'         => 'require',
        'end'           =>'require',
        'start'           =>'require',
        'province'              =>'require',
        'city'                  =>'require',
        'area'                  =>'require',
        'location'                 =>'require',
    ];
    
    protected $message = [
        'event.require'        =>  '活动名必须',
        'event_type.require'	=> '活动类型必须',
        'price.require'      =>'费用必须',
        'start'           =>'活动时间必须大于当前时间',
        'end'   =>'活动时间必须大于当前时间',
        'province'              =>'省份必填',
        'city'                  =>'城市必填',
        'area'                  =>'区县必填',
        'location'                 =>'活动地点必填',
    ];
    
    protected $scene = [
        'add'   =>  ['event','event_type','price','province','city','area','location'],
        'edit'  =>  ['event_time'],
    ];    

}