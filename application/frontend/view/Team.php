<?php
// 球队模块
namespace app\frontend\controller;


class Team extends Base {
    // 球队列表(平台展示)
    public function teamlist() {
        return view('Team/teamList');
    }

    // 创建球队
    public function createteam() {
        return view('Team/createTeam');
    }

    // 球队管理
    public function teammanage() {
        return view('Team/teamManage');
    }

    // 编辑球队
    public function teamedit() {
        return view('Team/teamEdit');
    }

    // 球队首页
    public function teaminfo() {
        return view('Team/teamInfo');
    }

    // 我的球队列表（会员加入/所在球队列表）
    public function myteam() {
        return view('Team/myteam');
    }

    // 队员列表
    public function teammember() {
        return view('Team/teamMember');
    }

    // 队员档案
    public function teammemberinfo() {
        return view('Team/teamMemberInfo');
    }

    // 粉丝列表
    public function fans() {
        return view('Team/fans');
    }

    // 消息列表
    public function messagelist() {
        return view('Team/messagelist');
    }

    // 消息详情
    public function messageinfo() {
        return view('Team/messageInfo');
    }

    // 发布球队消息（公告）
    public function createmessage() {
        return view('Team/createMessage');
    }

    // 相册列表
    public function album() {
        return view('Team/album');
    }

    // 比赛列表（球队参与的）
    public function competition() {
        return view('Team/competition');
    }

    // 活动列表
    public function eventlist() {
        return view('Team/eventList');
    }

    // 活动详情
    public function eventInfo() {
        return view('Team/eventInfo');
    }

    // 活动报名

    // 活动报名人员名单

    // 创建活动

    // 编辑活动

    // 活动录入


}