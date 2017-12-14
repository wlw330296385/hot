<?php
// 球队活动validate
namespace app\common\validate;
use think\Validate;

class TeamEventVal extends Validate {
    protected $rule = [
        'team_id' => 'require',
        'member_id' => 'require|gt:0',
        'cover' => 'require',
        'event' => 'require|token',
        'event_type' => 'require',
        'start_time' => 'require',
        'end_time' => 'require',
        'province' => 'require',
        'city' => 'require',
        'area' => 'require',
        'location' => 'require'
    ];

    protected $message = [
        'team_id.require' => '请选择球队',
        'member_id.require' => '请先注册会员或重新登录平台',
        'member_id.gt' => '请先注册会员或重新登录平台',
        'cover.require' => '请上传主题封面',
        'event.require' => '请填写活动主题',
        'event_type' => '请选择活动类型',
        'event.token' => '无需重复提交',
        'start_time.require' => '请选择活动开始时间',
        'end_time.require' => '请选择活动结束时间',
        'province.require' => '请选择所属地区',
        'city.require' => '请选择所属地区',
        'area.require' => '请选择所属地区',
        'location.require' => '请填写活动地点'
    ];

    protected $scene = [
        'add' => ['team_id', 'member_id', 'cover', 'event', 'event_type', 'start_time', 'end_time', 'province', 'city', 'area'],
        'edit' => ['member_id','event']
    ];
}