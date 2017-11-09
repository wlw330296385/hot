<?php 
namespace app\common\validate;
use think\Validate;
class LessonVal extends Validate{


	protected $rule = [
        'lesson'        =>  'require|max:60|token',
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
        'lesson.token'   =>'请不要重复提交',
        'lesson.require'        =>  '请输入课程名称',
        'gradecate.require'	=> '请选择课程类型',
        'cost.require'      =>'请输入课程单价',
        'dom'                 =>'缺少必填项目',
        'coach'                 =>'请选择主教练',
        'week'                  =>'请选择周期（星期几）',
        'lesson_time'           =>'发布时间需要大于当前时间',
        'province'              =>'请选择地区',
        'city'                  =>'请选择地区',
        'area'                  =>'请选择地区',
        'court'                 =>'请选择训练场地',
    ];
    
    protected $scene = [
        'add'   =>  ['gradecate','lesson','dom','cost','coach','week','lesson_time','province','city','area','court'],
        'edit'  =>  [],
    ];    

}