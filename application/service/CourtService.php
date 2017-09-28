<?php
namespace app\service;
use app\model\Court;
use app\model\CourtCamp;
use app\common\validate\CourtVal;
use think\Db;
class CourtService {
    private $courtModel;
    public function __construct(){
        $this->courtModel = new Court;
        $this->CourtCamp = new CourtCamp;
    }
    // 场地列表
    public function getCourtList($map=[],$page = 1,$paginate = 10, $order='', $field='*'){
        $result = Court::where($map)->field($field)->order($order)->page($page,$paginate)->select();
        if($result){           
            $res = $result->toArray();
            foreach ($res as $key => $value) {
                if($value['cover']){
                    $res[$key]['covers'] = unserialize($value['cover']);
                }else{
                    $res[$key]['covers'] = [];
                }
            }
            return $res;
        }
        return $result;
    }

    // 场地分页
    public function getCourtListbyPage($map=[], $order='', $field='*', $paginate=10){
        $result = Court::where($map)->field($field)->order($order)->paginate($paginate);
        if($result){           
            $result = $result->toArray();
        }
        return $result;
    }

    // 场地详情
    public function getCourtInfo($map=[]) {
        $result = Court::get($map);
        if($result){           
            $res = $result->toArray();
            if($res['cover']){
                $res['covers'] = unserialize($res['cover']);
            }else{
                $res['covers'] = [];
            }
            $res['status_num'] = $result->getData('status');
            return $res;
        }else{
            return $result;
        }
        
    }

    // 关联场地详情
    public function getCourtInfoWithCourtCamp($court_id,$camp_id) {
        $result = Db::view('court','*')
                ->view('court_camp',['camp_id'=>'campid','court_id'=>'courtid'],'court_camp.court_id = court.id and court_camp.camp_id='.$camp_id,'LEFT')
                ->where(['court.id'=>$court_id])
                ->find();

        if($result){           
            if($result['cover']){
                $result['covers'] = unserialize($result['cover']);
            }else{
                $result['covers'] = [];
            }
            
        }
        return $result;
    }


    // 获取训练营下的场地列表
    public function getCourtListOfCamp($map = [],$paginate = 10){
        $result = $this->CourtCamp->with('court')->where($map)->paginate($paginate);
        if($result){           
            $res = $result->toArray();
<<<<<<< HEAD
=======
//             dump($res);die;
>>>>>>> 55f41b4f338948b695f2dddbd02c6f5bf77798a9
                foreach ($res['data'] as $key => $value) {
                    if($value['court']['cover']){
                        $res['data'][$key]['court']['covers'] = unserialize($value['court']['cover']);
                    }else{
                        $res['data'][$key]['court']['covers'] = [];
                    }
                }
            
            return $res;
        }
        return $result;
    }

    // 编辑场地
    public function updateCourt($data,$id){
        $validate = validate('CourtVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        if($data['covers']){
            $data['cover'] = serialize($data['covers']);
        }else{
             $data['cover'] = serialize(['/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg']);
        }
        $result = $this->courtModel->save($data,['id'=>$id]);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_200')];
        }else{
            return ['code'=>100,'msg'=>$this->courtModel->getError()];
        }
    }

    // 新增场地
    public function createCourt($data){
        $validate = validate('CourtVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        if($data['covers']){
            $data['cover'] = serialize($data['covers']);
        }else{
            $data['cover'] = serialize(['/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg']);;
        }
        $result = $this->courtModel->save($data);
        if($result){
            return ['code'=>200,'data'=>$result,'msg'=>__lang('MSG_200')];
        }else{
            return ['code'=>100,'msg'=>$this->courtModel->getError()];
        }
    }


    // 把场地添加到自己的库
    public function ownCourt($court_id,$camp_id){
        $is_own = $this->CourtCamp->where(['court_id'=>$court_id,'camp_id'=>$camp_id])->find();
        if($is_own){
            return ['code'=>100,'msg'=>"重复添加"];
        }
        $courtInfoOBJ = $this->courtModel->where(['id'=>$court_id,'camp_id'=>0,'status'=>1])->find();
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        if(!$courtInfoOBJ || !$campInfo){
            return ['code'=>100,'msg'=>"查询不到该场地或者训练营"];
        }else{
            $courtInfo = $courtInfoOBJ->toArray();
            $data = ['camp_id'=>$camp_id,'court_id'=>$court_id,'court'=>$courtInfo['court'],'camp'=>$campInfo['camp']];
            $res = $this->CourtCamp->save($data);
            if($res){
                return ['code'=>200,'msg'=>__lang('MSG_200')];
            }else{
                return ['code'=>100,'msg'=>__lang('MSG_400')];
            }
        }
    }

    // 删除court_camp 2017/09/28
    public function delCourtCamp($court_id, $camp_id) {
        $model = new CourtCamp();
        $find = $model->where(['court_id' => $court_id, 'camp_id' => $camp_id])->find();
        if (!$find) {
            return ['code' => 100, 'msg' => '场地训练营关联'.__lang('MSG_401'), 'data' => $find];
        }
        
        $execute = $model::destroy($find['id']);
        if (!$execute) {
            return ['code' => 100, 'msg' => '删除训练营场地'.__lang('MSG_400'), 'data' => $execute];
        } else {
            return ['code' => 200, 'msg' => '删除训练营场地'.__lang('MSG_200'), 'data' => $execute];
        }
    }
}