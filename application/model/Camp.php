<?php 
namespace app\model;
use think\Model;
use app\validate\CampVal;
use traits\model\SoftDelete;
class Camp extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    protected $readonly = [
							//"id",
						    "max_member",
						    "total_coach",
						    "act_coach",
						    "total_member",
						    "act_member",
						    "total_lessons",
						    "finished_lessons",
						    "star",
						    "total_grade",
						    "act_grade",
						    "camp_base",
						    "type",
						    "status",
						    //"create_time",
							];

    public function getStatusAttr($value)
    {
        $status = [0=>'待审核',1=>'已审核',2=>'关闭',3=>'未通过'];
        return $status[$value];
    }
}