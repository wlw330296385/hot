<?php
// 比赛数据（球队、球员参加比赛所录入的技术数据统计）api
namespace app\api\controller;


use app\service\TeamService;

class Matchdata
{
    // 获取球员赛季数据
    public function playerseasondatastatis() {
        $data = input('param.');
        // 球员id必须传入
        if ( !array_key_exists('tm_id', $data) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402').'请选择球员']);
        }
        $teamS = new TeamService();
        // 获取球队成员数据
        $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $data['tm_id']]);
        if (!$teamMemberInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404').'无此球员信息']);
        }
        // 赛季时间(年)
        if (input('?param.year')) {
            $year = input('year');
            // 比赛时间在赛季年
            $when = getStartAndEndUnixTimestamp($year);
            $data['match_time'] = ['between',
                [ $when['start'], $when['end'] ]
            ];
            unset($data['year']);
        }
        // 获取数据统计
    }
}