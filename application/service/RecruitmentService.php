<?php
namespace app\service;
use app\model\Recruitment;
use think\Db;
use app\common\RecruitmentVal;
use app\model\RecruitmentMember;
class RecruitmentService{

    private $RecruitmentModel;

    public function __construct(){
        $this->RecruitmentModel = new Recruitment;

    }


    // 招募列表
    public function getRecruitmentList($map=[],$page = 1, $order='',$p=10) {
        $res = Recruitment::where($map)->order($order)->page($page,$p)->select();
        // echo Recruitment::getlastsql();
        if($res){   
            $result = $res->toArray();
        }
        return $res;
    }

    // 招募分页
    public function getRecruitmentListByPage($map , $order='', $paginate=10) {
        $result =  $this->RecruitmentModel
                // ->with('gradeMember')
                ->where($map)
                ->order($order)
                ->paginate($paginate);
                // echo $this->RecruitmentModel->getlastsql();die;

        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
        
    }

    // 一个招募
    public function getRecruitmentInfo($map=[]) {
        $res = $this->RecruitmentModel->where($map)->find();
        if($res){           
            $result = $res->toArray();
            $result['deadlines'] = date('Y-m-d',$result['deadline']);
            return $result;
        }
        return $res;
    }

    // 获取招募分类 $tree传1 返回树状列表，不传就返回查询结果集数组
    public function getRecruitmentCategory($tree=0) {
        $res = Db::name('grade_category')->field(['id', 'name', 'pid'])->select();
        if($res){
            $result = channelLevel($res,0,'id','pid');
            return $result;
        }else{
            return $res;
        }
    }


    // 返回招募数量统计
    public function countRecruitments($map){
        $result = $this->RecruitmentModel->where($map)->count();
        return $result?$result:0;
    }

    // 新增招募
    public function createRecruitment($data){
        $validate = validate('RecruitmentVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->RecruitmentModel->allowField(true)->save($data);
         if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        }else{
            return [ 'msg' => __lang('MSG_200'), 'code' => 200, 'data' => $this->RecruitmentModel->id];
        }
    }

    // 编辑招募
    public function updateRecruitment($data,$id){
        $validate = validate('RecruitmentVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->RecruitmentModel->save($data,['id'=>$id]);
         if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' =>100 ];
        }else{
             return [ 'msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }
   


     // 获取参与者列表
     public function getRecruitmentMemberListNoPage($map){
        $result = RecruitmentMember::where($map)
                // ->page($page,$paginate)
                ->select();
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 获取参与者列表
     public function getRecruitmentMemberListByPage($map,$order = '',$paginate = 10){
        $result = RecruitmentMember::where($map)
                ->order($order)
                ->paginate($paginate);
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 招募权限
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where([
                        'camp_id'   =>$camp_id,
                        'status'    =>1,
                        'member_id'  =>$member_id,
                        ])
                    ->value('type');

        return $is_power?$is_power:0;
    
    }


    // 参加招募
    public function joinRecruitment($recruitment_id,$data,$total = 1){
        $recruitmentInfo = $this->getRecruitmentInfo(['id'=>$recruitment_id]);
        if($recruitmentInfo['status']!= '上架'){
            return ['msg'=>"该招募已{$recruitmentInfo['status']},不可再参与", 'code' => 100];
        }
        // 检测是否已满人
        if($recruitmentInfo['is_max'] == -1){
             return ['msg'=>"该招募已满人,不可再参与", 'code' => 100];   
        }

        // 检测是否已结束
        if(time() > $recruitmentInfo['deadline'] && $recruitmentInfo['deadline']>1){
             return ['msg'=>"该招募已结束,不可再参与", 'code' => 100];   
        }


        //插入数据
        $RecruitmentMember = new RecruitmentMember;
        $result = $RecruitmentMember->save($data);
               
        if($result){
            if(!isset($data['id'])){
                $res = $this->RecruitmentModel->where(['id'=>$recruitment_id])->setInc('participator',$total);
            
                // 发送模板消息
                $MessageService = new \app\service\MessageService;                
                $MessageCampData = [
                    "touser" => '',
                    "template_id" => config('wxTemplateID.successJoin'),
                    "url" => url('frontend/recruitment/recruitmentInfoOfCamp',['recruitment_id'=>$recruitmentInfo['id']],'',true),
                    "topcolor"=>"#FF0000",
                    "data" => [
                        'first' => ['value' => "{$data['member']}申请[{$recruitmentInfo['recruitment']}]招募"],
                        'keyword1' => ['value' => $data['member']],
                        'keyword2' => ['value' => date('Y-m-d H:i',time())],
                        'remark' => ['value' => '大热篮球']
                    ]
                ];
                $MessageCampSaveData = [
                            'title'=>"招募申请",
                            'content'=>"{$data['member']}申请[{$recruitmentInfo['recruitment']}]招募",
                            'url'=>url('frontend/recruitment/recruitmentInfoOfCamp',['recruitment_id'=>$recruitmentInfo['id']],'',true),
                        ];
                $MessageService->sendCampMessage($recruitmentInfo['organization_id'],$MessageCampData,$MessageCampSaveData);  //发给训练营管理员 
                // 更改状态
                // if($recruitmentInfo['max'] <= ($recruitmentInfo['participator']+$total)){
                //     $this->RecruitmentModel->save(['is_max'=>-1],['id'=>$recruitment_id]); 
                // }
            }
            return ['msg'=>"报名成功", 'code' => 200];
        }else{
            return ['msg'=>"报名失败", 'code' => 100];
        }
        
    }

}