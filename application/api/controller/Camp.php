<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\service\CampService;
class camp extends Controller
{

    public $campService;

    public function _initialize() {     
        $this->campService = new CampService;
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $result = $this->campService->createCamp($request); 
        return json($result);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $result = $this->campService->CampOneById($id); 
        if($result){
            return json(['data' => $result,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>100]);
        }else{
            return json(['msg'=>__lang('MSG_200_ERROR'),'code'=>200]);
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request)
    {
        $resutl = $this->campService->UpdateCamp([$request]); 
        if($resutl){
            return json(['data'=>$result,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100']);
        }else{
            return json(['msg'=>__lang('MSG_200_ERROR'),'code'=>'200']);
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
