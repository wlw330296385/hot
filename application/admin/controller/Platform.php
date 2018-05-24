<?php
namespace app\admin\controller;
use app\admin\service\PlatformService;
use app\admin\controller\base\Backend;
class Platform extends Backend {
    private $PlatformService;
	public function _initialize(){
		parent::_initialize();
        $this->PlatformService = new PlatformService;
	}
    public function platformList() {
        $field = '请选择搜索关键词';
        $map = [];

        $field = input('param.field');
        $keyword = input('param.keyword');
        if($keyword==''){
            $map = [];
            $field = '请选择搜索关键词';
        }else{
            if($field){
                $map = [$field=>['like',"%$keyword%"]];
            }else{
                $field = '请选择搜索关键词';
                $map = function($query) use ($keyword){
                    $query->where(['platform'=>['like',"%$keyword%"]]);
                };
            }
        }
        
        $platformList = $this->PlatformService->getPlatformListByPage($map);
        $this->assign('field',$field);
        $this->assign('platformList',$platformList);    
        return view('Platform/platformList');
    	
    }

    public function platformInfo(){
        $platform_id = input('param.platform_id');
        $map['id'] = $araticle_id;
        $platformInfo = $this->PlatformService->getPlatformInfo($map);

        $this->assign('platformInfo',$platformInfo);
        return  view('platform/platformInfo');
    }

    public function createPlatform(){
        if(request()->isPost()){
            $data = input('post.');
            $data['member_id']=$this->admin['id'];
            $data['member'] = $this->admin['username'];
            $result = $this->PlatformService->createPlatform($data);
            if($result['code'] == 200){
                $this->success($result['msg'],'/admin/Platform/platformList');
            }else{
                $this->error($result['msg']);
            }
        }

        return view('Platform/createPlatform');
    }


    public function updatePlatform(){
        $platform_id = input('param.platform_id');
        $map['id'] = $platform_id;
        $platformInfo = $this->PlatformService->getPlatformInfo($map);


        if(request()->isPost()){
            $data = input('post.');
            $id = $data['id'];

            $result = $this->PlatformService->updatePlatform($data,['id'=>$id]);
            if($result['code'] == 200){
                $this->success($result['msg'],url('admin/Platform/platformPlatformList',['platform_id'=>$platform_id]));
            }else{
                $this->error($result['msg']);
            }
        }


        $this->assign('platformInfo',$platformInfo);

        return view('Platform/updatePlatform');
    }


    public function platformPlatformList(){

        $platform_id = input('param.platform_id');
        $map['id'] = $platform_id;
        $platformInfo = $this->PlatformService->getPlatformInfo($map);

        $platformList = db('platform')
        ->field('platform.*,platform_platform.t_id,platform_platform.platform,platform_platform.platform_id,platform_platform.remarks as tp_remarks,platform_platform.id as tp_id')
        ->join('platform_platform','platform.id = platform_platform.platform_id','left')
        ->order('platform_platform.id desc')
        ->select();


        $this->assign('platformInfo',$platformInfo);
        $this->assign('platformList',$platformList);
        return view('Platform/platformPlatformList');
    }


















    // 接口类
    public function getPlatformListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->PlatformService->getPlatformList($map);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getPlatformListByPageApi(){
         try{
            $map = input('post.');
            $paginate = input('param.paginate')?input('param.paginate'):10; 
            $result = $this->PlatformService->getPlatformListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }

 
    public function updatePlatformApi(){
         try{
            $data = input('post.');
            $bankcard_id = input('param.bankcard_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->PlatformService->updatePlatform($data,['id'=>$bankcard_id]);
            return json($result);
         }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    public function createPlatformApi(){
        try{
            $data = input('post.');
            $result = $this->PlatformService->createPlatform($data);
            return json($result);   
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function getPlatformPlatformListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->PlatformPlatform->where($map)->page($page)->select();  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function getPlatformPlatformListByPageApi(){
         try{
            $map = input('post.');
            $paginate = input('param.paginate')?input('param.paginate'):10; 
            $result = $this->PlatformPlatform->where($map)->paginate($paginate);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }

    //修改关联
    public function updatePlatformPlatformApi(){
         try{
            $data = input('post.');
            $platform_plat_id = input('param.platform_plat_id');
            $result = $this->PlatformPlatform->save($data,['id'=>$platform_plat_id]);
            if($result){
                return json(['code'=>200,'msg'=>'修改成功']);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            }
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }
 
    // 新关联
    public function createPlatformPlatformApi(){
        try{
            $data = input('post.');
            $res = $this->PlatformPlatform->where(['platform_id'=>$data['platform_id'],'platform_id'=>$platform_id])->find();
            if($res){
                return json(['code'=>100,'msg'=>'重复关联']);
            }
            $result = $this->PlatformPlatform->save($data);
            if($result){
                return json(['code'=>200,'msg'=>'关联成功','data'=>$this->PlatformPlatform->id]);
            }else{
                return json(['code'=>100,'msg'=>'关联失败']);
            }
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}