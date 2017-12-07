<?php 
namespace app\common\validate;
use think\Validate;
class LessonMemberVal extends Validate{


	protected $rule = [
        'lesson'        =>  'require|max:60|token',
        'lesson_id'     =>'require',
        'camp_id'       =>'require',
        'member_id'     =>'require',
        'student_id'    =>'require',
        'type'          =>'require',
    ];
    
    protected $message = [
        'lesson.token'   =>'请不要重复提交',
        'lesson_id.require'        =>  '缺少课程信息',
    ];
    
    protected $scene = [
        'add'   =>  ['lesson_id','lesson','camp_id','member_id','student_id','type'],
        'edit'  =>  [],
    ];    

}