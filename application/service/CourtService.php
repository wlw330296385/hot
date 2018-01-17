<?php
namespace app\service;
use app\model\Court;
use app\model\CourtCamp;
use app\common\validate\CourtVal;
use think\Db;
class CourtService {
    private $CourtModel;
    public function __construct(){
        $this->CourtModel = new Court;
        $this->CourtCampModel = new CourtCamp;
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


    // 获取训练营下的场地列表 (带分页参数)
    public function getCourtListOfCamp($map = [], $page=1, $limit=10){
        if (array_key_exists('status', $map)) {
            $map['courtisopen'] = $map['status'];
            unset($map['status']);
        }
        $map['court_camp.delete_time'] = ['EXP', 'IS NULL'];

        $list = Db::view('court_camp',['id', 'camp_id', 'camp', 'court_id', 'court'])
            ->view('court', ['cover', 'status'=>'courtisopen', 'location', 'area'], 'court.id=court_camp.court_id')
            ->where($map)
            ->limit($limit)->page($page)->select();
            // echo db('court')->getlastsql();
            // die;
        foreach ($list as $key => $value) {
            if ($value['cover']) {
                $list[$key]['covers'] = unserialize($value['cover']);
            }
        }
        return $list;
    }

    // 编辑场地
    public function updateCourt($data,$id){
        $courtInfo = $this->CourtModel->where(['id'=>$id,'status'=>1])->find();
       /* if($courtInfo){
            return ['msg' => '已公开的场地不允许编辑', 'code' => 100];
        }*/
        $validate = validate('CourtVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        if($data['covers']){
            $data['cover'] = serialize($data['covers']);
        }else{
             $data['cover'] = serialize(['/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg']);
        }
        $result = $this->CourtModel->allowField(true)->save($data,['id'=>$id]);
        if($result){
            return ['code'=>200,'data'=>$result,'msg'=>__lang('MSG_200')];
        }else{
            return ['code'=>100,'msg'=>$this->CourtModel->getError()];
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
        $model = new Court();
        $result = $model->allowField(true)->save($data);
        if($result){
            $dataCourtCamp = [
                'court_id' => $model->id,
                'court' => $data['court'],
                'camp_id' => $data['camp_id'],
                'camp' => $data['camp'],
                'status' => -1
            ];
            $addCourtCamp = CourtCamp::create($dataCourtCamp);
            if (!$addCourtCamp) {
                return ['code' => 100, 'msg' => '添加训练营场地关联'.__lang('MSG_400')];
            }
            db('camp')->where(['id'=>$data['camp_id']])->setInc('camp_base',1);
            return ['code'=>200,'data'=>$result,'msg'=>__lang('MSG_200')];
        }else{
            return ['code'=>100,'msg'=>$this->CourtModel->getError()];
        }
    }


    // 把场地添加到自己的库
    public function ownCourt($court_id,$camp_id){
        $is_own = $this->CourtCampModel->where(['court_id'=>$court_id,'camp_id'=>$camp_id])->find();
        if($is_own){
            return ['code'=>100,'msg'=>"重复添加"];
        }
        $courtInfoOBJ = $this->CourtModel->where(['id'=>$court_id,'status'=>1])->find();
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        if(!$courtInfoOBJ || !$campInfo){
            return ['code'=>100,'msg'=>"查询不到该场地或者训练营"];
        }else{
            $courtInfo = $courtInfoOBJ->toArray();
            $data = ['camp_id'=>$camp_id,'court_id'=>$court_id,'court'=>$courtInfo['court'],'camp'=>$campInfo['camp'],'status'=>1];
            $res = $this->CourtCampModel->save($data);
            if($res){
                db('camp')->where(['id'=>$camp_id])->setInc('camp_base',1);
                return ['code'=>200,'msg'=>__lang('MSG_200')];
            }else{
                return ['code'=>100,'msg'=>__lang('MSG_400')];
            }
        }
    }

    // 删除court_camp 2017/09/28
    public function delCourtCamp($courtcampid) {
        $model = new CourtCamp();
        $find = $model->where('id', $courtcampid)->find();
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




    public function getCourtCampListByPage($map,$order = '',$paginate = 10){
        $result = $this->CourtCampModel->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }else{
            return $result;
        }
    }
}