<?php 
namespace app\common\validate;
use think\Validate;
class LessonVal extends Validate{


	protected $rule = [
        'Lesson'        =>  'require|max:60',
        'lessoncate'	=> 'require',
        'total'         => 'require',
        'coach'         =>'require',
        'week'           =>'require',
        'lesson_time'           =>'after:'.date('Y-m-d',time()),
        'province'              =>'require',
        'city'                  =>'require',
        'area'                  =>'require',
        'court'                 =>'require',
    ];
    
    protected $message = [
        'Lesson.require'        =>  '课程名必须',
        'lessoncate.require'	=> '课程类型必须',
        'realname.require'      =>  '创建者必须实名认证',
        'camp'                  =>'所属训练营必须',
        'total'                 =>'字段必须',
        'coach'                 =>'字段必须',
        'week'                  =>'字段必须',
        'lesson_time'           =>'发布时间大于当前时间',
        'province'              =>'字段必须',
        'city'                  =>'字段必须',
        'area'                  =>'字段必须',
        'court'                 =>'字段必须',
    ];
    
    protected $scene = [
        'add'   =>  ['lessoncate','lesson','camp','total','coach','week','lesson_time','province','city','area','court'],
        'edit'  =>  ['lessoncate','lesson','camp','total','coach','week','lesson_time','province','city','area','court'],
    ];    

}