<?php 
namespace app\model;
use think\Model;
use app\validate\CampVal;
use traits\model\SoftDelete;
class Camp extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $readonly = [
							"id",
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
						    "create_time",
							];
}