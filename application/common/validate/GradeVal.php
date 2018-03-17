<?php 
namespace app\common\validate;
use think\Validate;
class GradeVal extends Validate{
	protected $rule = [
        'grade'  =>  'require|max:60|token',
        'member_id'	=> 'require',
        'lesson_id' => 'require',
//        'students' => 'require',
        'gradecate_id' => 'require',
        'week' => 'require',
        'lesson_time' => 'require',
        'area' => 'require',
        'court' => 'require',
        // 'coach_id' => 'require',
        // 'coach_salary' => 'require|number',
        'coach_salary' => 'number',
        'assistant_salary' => 'number',
        'salary_base' => 'number'
    ];
    
    protected $message = [
        'grade.token'   =>'请不要重复提交',
        'grade.require'  =>  '请填写班级名称',
        'member_id.require'	=> '会员信息过期,请重新登录平台',
        'lesson_id.require' => '请选择所属课程',
//        'students.require' => '请选择学员',
        'gradecate_id.require' => '请选择班级类型',
        'week.require' => '请选择训练周期',
        'lesson_time.require' => '请选择训练时间',
        'area.require' => '请选择所属地区',
        'court.require' => '请选择训练地点',
        // 'coach_id.require' => '请选择主教练',
        // 'coach_salary.require' => '请填写主教底薪',
        // 'coach_salary.number' => '请在主教底薪填写数字',
        'assistant_salary.number' => '请在助教底薪填写数字',
        'salary_base.number' => '请在提成基数填写数字'
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','grade','lesson_id','gradecate_id','week','lesson_time','court','area'],
        'edit'  =>  ['member_id','lesson_id','gradecate_id','week','lesson_time','court','area'],
    ];

}