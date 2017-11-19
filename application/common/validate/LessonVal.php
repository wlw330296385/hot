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
        'dom'                 =>'dom字段必须',
        'coach'                 =>'coach字段必须',
        'week'                  =>'week字段必须',
        'lesson_time'           =>'发布时间大于当前时间',
        'province'              =>'province字段必须',
        'city'                  =>'city字段必须',
        'area'                  =>'area字段必须',
        'court'                 =>'court字段必须',
    ];
    
    protected $scene = [
        'add'   =>  ['gradecate','lesson','dom','cost','coach','week','lesson_time','province','city','area','court'],
        'edit'  =>  [],
    ];    

}