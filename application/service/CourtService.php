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
            return $res;
        }else{
            return $result;
        }
        
    }


    // 获取训练营下的场地列表
    public function getCourtListOfCamp($map = [],$paginate = 10){
        $result = $this->CourtCamp->court()->where($map)->paginate($paginate);
        if($result){           
            $res = $result->toArray();
            // dump($res);die;
                foreach ($res['data'] as $key => $value) {
                    if($value['cover']){
                        $res['data'][$key]['covers'] = unserialize($value['cover']);
                    }else{
                        $res['data'][$key]['covers'] = [];
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
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        if($data['covers']){
            $data['cover'] = serialize($data['covers']);
        }else{
             $data['cover'] = '';
        }
        $result = $this->courtModel->save($data,['id'=>$id]);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->courtModel->getError()];
        }
    }

    // 新增场地
    public function createCourt($data){
        $validate = validate('CourtVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        if($data['covers']){
            $data['cover'] = serialize($data['covers']);
        }else{
            $data['cover'] = '';
        }
        $result = $this->courtModel->save($data);
        if($result){
            return ['code'=>100,'data'=>$this->courtModel->id,'msg'=>"ok"];
        }else{
            return ['code'=>200,'msg'=>$this->courtModel->getError()];
        }
    }


    // 把场地添加到自己的库
    public function ownCourt($court_id,$camp_id){
        $is_own = $this->CourtCamp->where(['court_id'=>$court_id,'camp_id'=>$camp_id])->find();
        if($is_own){
            return ['code'=>200,'msg'=>"重复添加"];
        }
        $courtInfoOBJ = $this->courtModel->where(['id'=>$court_id,'camp_id'=>0,'status'=>1])->find();
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        if(!$courtInfoOBJ || !$campInfo){
            return ['code'=>200,'msg'=>"查询不到该场地或者训练营"];
        }else{
            $courtInfo = $courtInfoOBJ->toArray();
            $data = ['camp_id'=>$camp_id,'court_id'=>$court_id,'court'=>$courtInfo['court'],'camp'=>$campInfo['camp']];
            $res = $this->CourtCamp->save($data);
            if($res){
                return ['code'=>100,'msg'=>"添加成功"];
            }else{
                return ['code'=>200,'msg'=>"添加失败"];
            }
        }
    }

}