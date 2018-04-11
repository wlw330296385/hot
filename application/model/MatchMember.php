<?php
// 联赛-工作人员(会员)关系
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchMember extends Model
{
    // 时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}