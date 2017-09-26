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
            $result = $result->toArray();
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
            }
            return $res;
        }else{
            return $result;
        }
        
    }


    // 获取训练营下的场地列表
    public function getCourtListOfCamp($map = []){
        $result = $this->CourtCamp->court()->where($map)->select();
        if($result){           
            $result = $result->toArray();
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
            $seri = explode(',', $data['covers']);
            $data['cover'] = serialize($seri);
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
            $seri = explode(',', $data['covers']);
            $data['cover'] = serialize($seri);
        }
        $result = $this->courtModel->save($data);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->courtModel->getError()];
        }
    }
}