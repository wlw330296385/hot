<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\TeamService;
use app\service\TeamMemberService;

class Team extends Backend {
    private $TeamListService; 
    public function _initialize(){
        parent::_initialize();
        $this->TeamService = new TeamService();
        $type = [
            1 => '训练营',
            2 => '企事业单位',
            3 => '业余组织',
            4 => '大学生',
            5 => '高中生',
            6 => '初中生',
            7 => '小学生',
        ];
        $this->assign('type',$type);
    }
    public function index() {

        $teamList = $this->TeamService->getTeamListByPage();
        $this->assign('teamList',$teamList);
        return view('Team/index');
    }

    public function teamInfo(){
        $team_id = input('param.team_id');
        $map['id'] = $team_id;
        $teamInfo = $this->TeamService->getTeam($map);

        unset($map);
        $map = array(
            'team_id' => $team_id,
            'team_member' => 1,
            'team_event' => 1,
            'team_honor' => 1,
            'team_follow' => 1,
            'team_match' => 1,
        );
        $teamStats = $this->TeamService->getTeamStats($map);

        $teamMemberS = new TeamMemberService();
        unset($map);
        $map['team_id'] = $team_id;
        $teamMemberList = $teamMemberS->myTeamList($map); 
        $this->assign('teamInfo',$teamInfo);
        $this->assign('teamStats',$teamStats);
        $this->assign('teamMemberList',$teamMemberList);
        return  view('team/teamInfo');
    }

    public function createTeam(){
        if(request()->isPost()){
            $data = input('post.');
            $data['member_id']=$this->admin['id'];
            $data['member'] = $this->admin['username'];
            $result = $this->TeamService->createTeam($data);
            if($result['code'] == 200){
                $this->success($result['msg'],'/admin/Team/teamList');
            }else{
                $this->error($result['msg']);
            }
        }

        return view('team/createTeam');
    }


    public function updateTeam(){
        $team_id = input('param.team_id');
        $map['id'] = $team_id;
        $teamInfo = $this->TeamService->getTeamInfo($map);


        if(request()->isPost()){
            $data = input('post.');
            $id = $data['id'];

            $data['member_id']=$this->admin['id'];
            $data['member'] = $this->admin['username'];
            $result = $this->TeamService->updateTeam($data,['id'=>$id]);
            if($result['code'] == 200){
                $this->success($result['msg'],url('admin/Team/teamInfo',['team_id'=>$team_id]));
            }else{
                $this->error($result['msg']);
            }
        }


        $this->assign('teamInfo',$teamInfo);

        return view('team/updateTeam');
    }

}
