<?php
namespace app\service;
use app\model\Coach;
use app\common\validate\CoachVal;
use think\Db;
class CoachService {

    public $Coach;
    public function __construct()
    {
        $this->Coach = new Coach();
    }

    public function getCoachList($map=[],$page = 1,$paginate = 10,$order='') {
        $res = $this->Coach->where($map)->order($order)->page($page,$paginate)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }

    public function CoachListPage( $map=[],$page = 1,$paginate=10, $order=''){
        $res = $this->Coach->where($map)->order($order)->page($page,$paginate)->select();
        
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }

    /**
     * 读取资源
     */
    public function getCoachInfo($id) {
        $res = Coach::get($id);
        if (!$res) {
            return false;
        }
        return $res->toArray();
    }

    /**
     * 更新资源
     */
    public function UpdateCoach($data,$id) {
        $validate = validate('CoachVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $res = $this->Coach->update($data,$id);
        if($res === false){
            return ['msg'=>$this->Coach->getError(),'code'=>'200'];
        }else{
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }
    }

    public function SoftDeleteCoach($id) {
        $res = $this->Coach->destroy($id);
        return $res;
    }

    /**
     * 创建资源
     */
    public function createCoach($request){
        // 一个人只能创建一个训练营
       /* $is_create = $this->isCreateCoach($request['member_id']);
        if($is_create){
            return ['msg'=>'一个用户只能创建一个训练营','code'=>'200'];die;
        }
        $validate = validate('CoachVal');
        if(!$validate->check($request)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $res = $this->Coach->save($request);
        if($res === false){
            return ['msg'=>$this->Coach->getError(),'code'=>'200'];
        }else{
            $data = ['Coach' =>$request['Coach'],'Coach_id'=>$res,'type'=>3,'realname'=>$request['realname'],'member_id'=>$request['member_id']];
            $result = Db::name('Coach_member')->insert($data);
            if(!$result){
                Coach::destroy($res);
                return ['msg'=>Db::name('Coach_member')->getError(),'code'=>'200'];
            }
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }*/
        //dump($request);
        $hasCreateCoach = $this->hasCreateCoach($request['member_id']);
        if ($hasCreateCoach) {
            return ['code' => 200, 'msg' => '一个会员只能创建一个训练营'];
        }
        $model = new Coach();
        $result = $model->validate('CoachVal.add')->save($request);
        if (false === $result) {
            return ['code' => 200, 'msg' => $model->getError()];
        }
        $CoachId = $model->getLastInsID();
        $CoachMemberData = [
            'Coach_id' => $CoachId,
            'Coach' => $request['Coach'],
            'member_id' => $request['member_id'],
            'member' => $request['realname'],
            'type' => 4,
            'status' => 0,
            'create_time' => time(),
            'update_time' => time()
        ];
        $CoachmemberDb = Db::name('Coach_member');
        $CoachMemberAdd = $CoachmemberDb->insert($CoachMemberData);
        if (!$CoachMemberAdd) {
            Coach::destroy($CoachId);
            return ['code' => 200, 'msg' => $CoachmemberDb->getError()];
        }

        return ['code' => 100, 'msg' => __lang('MSG_200'), 'data' => $CoachId];
    }

    /**
     * 判断是否已拥有训练营
     */

    public function hasCreateCoach($memberid){
       if ( Coach::get(['member_id' => $memberid]) ) {
           return true;
       } else {
           return false;
       }
    }


    /**
     * 返回权限
     */
    public function isPower($Coach_id,$member_id){
        $is_power = db('Coach_member')
                    ->where(['member_id'=>$member_id,'Coach_id'=>$Coach_id])
                    // ->where(function ($query) {
                            // $query->where('type', 2)->whereor('type', 3)->whereor('type',4);})
                    ->value('type');
                    // echo db('Coach_member')->getlastsql();die;
        return $is_power?$is_power:0;
    }
}