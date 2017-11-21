<?php
// 私密课程可购买会员关系表model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class LessonAssignMember extends Model {
    protected $table="lesson_assign_member";
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}