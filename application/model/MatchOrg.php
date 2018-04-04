<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class MatchOrg extends Model
{
    // 定义表名 模型名简写了
    protected $table = 'match_organization';
    // 时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

}