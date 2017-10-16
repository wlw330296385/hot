<?php 
namespace app\common\validate;
use think\Validate;
class ScheduleVal extends Validate{


	protected $rule = [
        'camp_id'           =>'require',
        //'camp'              =>'require|max:60',
        'lesson'	        =>'require',
        'lesson_id'         =>'require',
        'grade'             =>'require',
        'grade_id'          =>'require',
        'coach'             =>'require',
        'coach_id'          =>'require',
        // 'plan'              =>'require',
        // 'plan_id'           =>'require',
//        'lesson_date'       =>'require',
        'lesson_time'       =>'require',
    ];
    
    protected $message = [
        'camp_id'           =>'camp_id.require',
        //'camp'              =>'require|max:60',
        'lesson'            =>'lesson.require',
        'lesson_id'         =>'lesson_id.require',
        'grade'             =>'grade.require',
        'grade_id'          =>'grade_id.require',
        'coach'             =>'coach.require',
        'coach_id'          =>'coach_id.require',
        // 'plan'              =>'plan.require',
        // 'plan_id'           =>'plan_id.require',
//        'lesson_date'       =>'lesson_date.require',
        'lesson_time'       =>'lesson_time.require',
    ];
    
    protected $scene = [
        'add'   =>  ['camp_id','grade','coach','grade_id','coach_id',
//            'teacher_plan','teacher_plan_id','lesson_date'
        ],
        'edit'  =>  [],
    ];    

}