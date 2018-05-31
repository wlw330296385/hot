<?php
// 联赛组织-会员关系
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchOrgMember extends Model
{
    // 时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    public function getTypeAttr($value) {
        $type = [
            10 => '负责人',
            9 => '管理员',
            8 => '记分员',
            7 => '裁判员'
        ];
        return $type[$value];
    }
}