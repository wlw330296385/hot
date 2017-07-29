<?php
namespace app\api\controller;
use app\api\controller\Base;
use think\Request;
use app\service\MemberService;
class Member extends Base{

    public $memberService;

    public function _initialize() {   
        parent::_initialize();  
        $this->memberService = new MemberService;
    }


    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        dump(input());
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
        dump($request);die;
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        
        $start = strpos($id,'&');

        if($start!== false){
            $map = substr($id,$start+1);
            $ids = substr($id,0,$start);
            $result = $this->memberService->getMemberInfo(json_decode($map));
            
        }else{
            $result = $this->memberService->getMemberInfo(['id'=>$id]);
        }       
        unset($result['password']);
        return json(['data' => $result, 'code' => 200, 'message' => '读取成功']);

    }

    /**
     * 显示编辑资源表单页
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
    public function update(Request $request, $id)
    {
        $data = Request::instance()->param();
        $result = $this->memberService->updateMemberInfo($data,$id);
        return json($result);
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
