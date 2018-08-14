<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\TeamService;
class Team extends Backend {
    private $TeamListService; 
    public function _initialize(){
        parent::_initialize();
        $this->TeamService = new TeamService();
    }
    public function index() {

        $teamList = $this->TeamService->getTeamListByPage();
        $type = [
            1 => '训练营',
            2 => '企事业单位',
            3 => '业余组织',
            4 => '大学生',
            5 => '高中生',
            6 => '初中生',
            7 => '小学生',
        ];
        $this->assign('teamList',$teamList);
        $this->assign('type',$type);
        return view('Team/index');
        // dump($teamList);
        
    }

    public function teamInfo(){
        $team_id = input('param.team_id');
        $map['id'] = $team_id;
        $teamInfo = $this->TeamService->getTeam($map);

        $this->assign('teamInfo',$teamInfo);
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
