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
     public function getRecruitmentMemberListNoPage($map,$page = 1,$paginate = 10){
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
        if(time() > $recruitmentInfo['deadline']){
             return ['msg'=>"该招募已结束,不可再参与", 'code' => 100];   
        }


        //插入数据
        $RecruitmentMember = new RecruitmentMember;
        $result = $RecruitmentMember->save($data);

        // // 发送个人模板消息
        // $MessageService = new \app\service\MessageService;
        
        //     $MessageData = [
        //         "touser" => session('memberInfo.openid'),
        //         "template_id" => config('wxTemplateID.recruitmentJoin'),
        //         "url" => url('frontend/recruitment/recruitmentInfo',['recruitment_id'=>$recruitment_id],'',true),
        //         "topcolor"=>"#FF0000",
        //         "data" => [
        //             'first' => ['value' => "尊敬的{$member}，您已成功报名{$recruitmentInfo['recruitment']}。"],
        //             'keyword1' => ['value' => $member],
        //             'keyword2' => ['value' => $recruitmentInfo['recruitment']],
        //             'keyword3' => ['value' => $recruitmentInfo['starts'].'至'.$recruitmentInfo['ends']],
        //             'keyword4' => ['value' => $total],
        //             'keyword5' => ['value' =>$total*$recruitmentInfo['price']],
        //             'remark' => ['value' => '点击此消息查看[招募详情],具体订单信息请查看[我的订单]']
        //         ]
        //     ];
        // $saveData1 = [
        //                 'title'=>"[{$recruitmentInfo['recruitment']}]报名成功",
        //                 'content'=>$member."报名招募成功",
        //                 'url'=>url('frontend/recruitment/recruitmentInfo',['recruitment_id'=>$recruitment_id],'',true),
        //                 'member_id'=>$member_id
        //             ];
        // $saveData2 = [
        //                 'title'=>"[{$recruitmentInfo['recruitment']}]报名成功",
        //                 'content'=>$member."报名招募成功",
        //                 'url'=>url('frontend/recruitment/recruitmentInfo',['recruitment_id'=>$recruitment_id],'',true),
        //                 'member_id'=>$recruitmentInfo['member_id']
        //             ];
        // // 发布者的member
        // $memberInfo = db('member')->where(['id'=>$recruitmentInfo['member_id']])->find();
        // $MessageData2 = [
        //         "touser" => $memberInfo['openid'],
        //         "template_id" => config('wxTemplateID.recruitmentBook'),
        //         "url" => url('frontend/recruitment/recruitmentInfo',['recruitment_id'=>$recruitment_id],'',true),
        //         "topcolor"=>"#FF0000",
        //         "data" => [
        //             'first' => ['value' => "{$member}已成功报名{$recruitmentInfo['recruitment']}。"],
        //             'keyword1' => ['value' => $recruitmentInfo['recruitment']],
        //             'keyword2' => ['value' => $recruitmentInfo['starts'].'至'.$recruitmentInfo['ends']],
        //             'keyword3' => ['value' => $recruitmentInfo['location']],
        //             'keyword4' => ['value' => "点击此消息查看"],
        //             'remark' => ['value' => '大热篮球']
        //         ]
        //     ];
        // $MessageService->sendMessageMember($member_id,$MessageData,$saveData1);   //发给报名的人
        // $MessageService->sendMessageMember($recruitmentInfo['member_id'],$MessageData2,$saveData2);  //发给发布者        
        if($result){
            $res = $this->RecruitmentModel->where(['id'=>$recruitment_id])->setInc('participator',$total);
            // 更改状态
            // if($recruitmentInfo['max'] <= ($recruitmentInfo['participator']+$total)){
            //     $this->RecruitmentModel->save(['is_max'=>-1],['id'=>$recruitment_id]); 
            // }
            return ['msg'=>"报名成功", 'code' => 200];
        }else{
            return ['msg'=>"报名失败", 'code' => 100];
        }
        
    }

}