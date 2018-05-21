<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

// 会员相关点赞评论
class MemberComment extends Model
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}