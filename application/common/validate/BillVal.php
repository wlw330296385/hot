<?php 
namespace app\common\validate;
use think\Validate;
class billVal extends Validate{


	protected $rule = [
        'bill_order'        =>  'require',
        'lesson_id'	=> 'require',
        'lesson'         => 'require',
        'total'         =>'require',
        'price'           =>'require',
        'camp_id'           =>'require',
        'camp'              =>'require',
        'student_id'                  =>'require',
        'student'                  =>'require',
        'member_id'                 =>'require',
        'score_pay'     =>'require'
    ];
    
    protected $message = [
        'bill_order'        =>  '订单必须',
        'lesson_id'	=> '课程必须',
        'lesson'      =>  '课程必须',
        'camp'                  =>'所属训练营必须',
        'total'                 =>'字段必须',
        'price'                 =>'字段必须',
        'camp_id'                  =>'字段必须',
        'camp'           =>'训练营',
        'student_id'              =>'student_id字段必须',
        'student'                  =>'student字段必须',
        'member_id'                  =>'member_id字段必须',
        'member'                 =>'member字段必须',
        'score_pay'     =>'score_pay.require'
    ];
    
    protected $scene = [
        'add'   =>  ['bill_order','lesson_id','lesson','camp','total','price','camp_id','camp','student_id','student','member_id','member','score_pay'],
        'edit'  =>  ['total'],
    ];    

}