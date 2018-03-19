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
        'camp_id'           =>'没有指定训练营编号',
        //'camp'              =>'require|max:60',
        'lesson'            =>'没有指定课程',
        'lesson_id'         =>'没有指定课程编号',
        'grade'             =>'没有指定班级',
        'grade_id'          =>'没有指定班级编号',
        'coach'             =>'主教练必选',
        'coach_id'          =>'没有相应主教练编号',
        // 'plan'              =>'plan.require',
        // 'plan_id'           =>'plan_id.require',
//        'lesson_date'       =>'lesson_date.require',
        'lesson_time'       =>'课时时间必填',
    ];
    
    protected $scene = [
        'add'   =>  ['camp_id','grade','coach','grade_id','coach_id',
//            'teacher_plan','teacher_plan_id','lesson_date'
        ],
        'edit'  =>  [],
    ];    

}