<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\model\Family as FamilyModel;

class Family extends Base{
    protected $FamilyModel;
    public function _initialize(){
        parent::_initialize();
        $this->FamilyModel = new FamilyModel;
    }


    public function getFamilyListNoPageApi(){
        try {
            $map = input('post.');
            $result = $this->FamilyModel->where($map)->select();

            return json(['code'=>200,'msg'=>'查询成功','data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    //一页10条
    public function getFamilyListApi(){
        try {
            $map = input('post.');
            $page = input('param.page',1);
            $result = $this->FamilyModel->where($map)->page($page)->select();
            return json(['code'=>200,'msg'=>'查询成功','data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //新增一个邀请
    public function createFamilyApi(){
        try {
            $map = ['member_id'=>$this->memberInfo['id']];
            $data = input('post.');
            $telephone = input('param.telephone');
            if(!$telephone){
                return json(['code'=>100,'msg'=>'邀请人电话号码必须']);
            }
            $map['telephone'] = $telephone;
            $result = $this->FamilyModel->where($map)->find();
            if($result){
                if($result['status']<>-1){
                    $res = $this->FamilyModel->save(['status'=>-1],$map);
                    if($res){
                        return json(['code'=>200,'msg'=>'邀请成功','data'=>$result['id']]);
                    }else{
                        return json(['code'=>100,'msg'=>'邀请失败,请重试']);
                    }
                }else{
                    return json(['code'=>100,'msg'=>'重复邀请']); 
                }
            }
            $data['avatar'] = $this->memberInfo['avatar'];
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['status'] = -1;
            $res = $this->FamilyModel->save($data);
            if($res){
                return json(['code'=>200,'msg'=>'邀请成功','data'=>$this->FamilyModel->id]);
            }else{
                return json(['code'=>100,'msg'=>'邀请失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //接受或者拒绝一个邀请
    public function updateFamilyApi(){
        try {
            $f_id = input('param.f_id');
            if(!$f_id){
                return json(['code'=>100,'msg'=>'没有邀请信息']);
            }
            $map = ['id'=>$f_id];
            $result = $this->FamilyModel->where($map)->find();
            if($result){
                if($result['status']<>-1){
                    return json(['code'=>100,'msg'=>'邀请状态已改变']); 
                }

                if($result['telephone']<>$this->memberInfo['telephone']){                   
                    return json(['code'=>100,'msg'=>'您账号的电话号码不匹配']); 
                }
            }else{
                return json(['code'=>100,'msg'=>'并没有人邀请你成为家庭成员']); 
            }
            $status = input('param.status');
            if(!$status){
                return json(['code'=>100,'msg'=>'传参有误']); 
            }
            if ($status==1) {
                $data['to_member_avatar'] = $this->memberInfo['avatar'];
                $data['to_member_id'] = $this->memberInfo['id'];
                $data['to_member'] = $this->memberInfo['member'];
                $data['status'] = 1;
                $res = $this->FamilyModel->save($data,$map);
            }
            if ($status==-2) {
                $data['to_member_avatar'] = $this->memberInfo['avatar'];
                $data['to_member_id'] = $this->memberInfo['id'];
                $data['to_member'] = $this->memberInfo['member'];
                $data['status'] = -2;
                $res = $this->FamilyModel->save($data,$map);
            }
            if($res){
                return json(['code'=>200,'msg'=>'操作成功']);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    /**
     *  删掉一条绑定关系|记录
     * @param f_id  family表的id;
     */
    public function breakFamilyApi(){
        try {
            $f_id = input('param.f_id');
            if(!$f_id){
                return json(['code'=>100,'msg'=>'传参错误']);
            }
            $map = ['id'=>$f_id];
            $familyInfo = $this->FamilyModel->where($map)->find();
            if(!$familyInfo){
                return json(['code'=>100,'msg'=>'没有家庭信息']);
            }
            if($familyInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足']);
            }
            $result = $this->FamilyModel->where($map)->delete();
            if($result){
               if($familyInfo['status']==1){
                    // 发送模板消息
                    $to_memberInfo = db('member')->where(['id'=>$familyInfo['to_member_id']])->find();
                    if($to_memberInfo['openid']){
                        // 发送个人消息           
                        $MessageData = [
                            "touser" => $to_memberInfo['openid'],
                            "template_id" => "b_aj8CaXc3P4d03RpCtQbLCUBLeowrj-z1SVo2uXr5M",
                            "url" => url('frontend/camp/index','','',true),
                            "topcolor"=>"#FF0000",
                            "data" => [
                                'first' => ['value' => "{$familyInfo['member']}与您解除家庭成员关系"],
                                'keyword1' => ['value' => "解除家庭关系"],
                                'keyword2' => ['value' => "解除成功"],
                                'keyword3' => ['value' => date('Y-m-d H:i:s'.time())],
                                'remark' => ['value' => '篮球管家']                                 
                            ]
                        ];
                         $saveData = [
                            'title'=>"{$familyInfo['member']}与您解除家庭成员关系",
                            'content'=>"{$familyInfo['member']}与您解除家庭成员关系,解除成功",
                            'url'=>url('frontend/camp/index','','',true),
                            'member_id'=>$to_memberInfo['id']
                        ];
                        // 发送模板消息
                        $MessageService = new \app\service\MessageService;
                        $MessageService->sendMessageMember($to_memberInfo['id'],$MessageData,$saveData);
                    }
                } 
                return json(['code'=>200,'msg'=>"删除成功"]);
            }else{
                return json(['code'=>100,'msg'=>"删除失败"]);
            }
            
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}

