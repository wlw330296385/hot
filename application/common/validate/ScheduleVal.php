<?php 
namespace app\common\validate;
use think\Validate;
class ScheduleVal extends Validate{


	protected $rule = [
        'camp_id'           =>'require',
        //'camp'              =>'require|max:60',
        // 'lesson'	        =>'require',
        // 'lesson_id'         =>'require',
        'grade'             =>'require',
        'grade_id'          =>'require',
        'coach'             =>'after:'.date('Y-m-d',time()),
        'coach_id'          =>'require',
        'teacher_plan'      =>'require',
        'teacher_plan_id'   =>'require',
        'lesson_date'       =>'require',
        'lesson_time'       =>'require',
    ];
    
    protected $message = [
        'camp_id'           =>'require',
        'camp'              =>'require|max:60',
        // 'lesson'            =>'require',
        // 'lesson_id'         =>'require',
        'grade'             =>'require',
        'grade_id'          =>'require',
        'coach'             =>'after:'.date('Y-m-d',time()),
        'coach_id'          =>'require',
        'teacher_plan'      =>'require',
        'teacher_plan_id'   =>'require',
        'lesson_date'       =>'require',
        'lesson_time'       =>'require',
    ];
    
    protected $scene = [
        'add'   =>  ['camp_id','grade','grade_id','coach_id','teacher_plan','teacher_plan_id','lesson_date'],
        'edit'  =>  [],
    ];    

}