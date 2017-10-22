<?php 
namespace app\common\validate;
use think\Validate;
class LessonVal extends Validate{


	protected $rule = [
        'lesson'        =>  'require|max:60',
        'gradecate'	=> 'require',
        'cost'         => 'require',
        'dom'         => 'require',
        'coach'         =>'require',
        'week'           =>'require',
        'lesson_time'           =>'require',
        'province'              =>'require',
        'city'                  =>'require',
        'area'                  =>'require',
        'court'                 =>'require',
    ];
    
    protected $message = [
        'lesson.require'        =>  '课程名必须',
        'gradecate.require'	=> '课程类型必须',
        'cost.require'      =>'费用必须',
        'dom'                 =>'缺少必填项目',
        'coach'                 =>'主教练必填',
        'week'                  =>'周期（星期几）必填',
        'lesson_time'           =>'发布时间大于当前时间',
        'province'              =>'省份必填',
        'city'                  =>'城市必填',
        'area'                  =>'区县必填',
        'court'                 =>'训练点必填',
    ];
    
    protected $scene = [
        'add'   =>  ['gradecate','lesson','dom','cost','coach','week','lesson_time','province','city','area','court'],
        'edit'  =>  [],
    ];    

}