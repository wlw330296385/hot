<?php 
namespace app\common\validate;
use think\Validate;
class billVal extends Validate{


	protected $rule = [
        'bill_order'        =>  'require',
        'goods_id'	=> 'require',
        'goods'         => 'require',
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
        'bill_order'        =>  '缺少订单号',
        'goods_id'	=> '商品必须',
        'goods'      =>  '商品必须',
        'camp'                  =>'缺少训练营',
        'total'                 =>'缺少总价',
        'price'                 =>'缺少单价',
        'camp_id'                  =>'字段必须',
        'camp'           =>'训练营',
        'student_id'              =>'请先添加学生并且注意点[确认添加]按钮',
        'student'                  =>'请先添加学生姓名并且注意点[确认添加]按钮',
        'member_id'                  =>'member_id字段必须',
        'member'                 =>'member字段必须',
        'score_pay'     =>'score_pay.require'
    ];
    
    protected $scene = [
        'add'   =>  ['bill_order','goods_id','goods','camp','total','price','camp_id','camp','student_id','student','member_id','member','score_pay'],
        'edit'  =>  ['total'],
    ];    

}