<?php 
namespace app\service;
use app\model\Referee;
use app\common\validate\RefereeVal;
use app\model\Grade;
use think\Db;
class RefereeService{
	private $RefereeModel;
	public function __construct(){
		$this->RefereeModel = new Referee();
	}

	/**
	 * 查询裁判信息&&关联member表
	 */
	public function getRefereeInfo($map){
        $res = Referee::with('member')->where($map)->find();
        if($res){
            $getData = $res->getData();
            $result = $res->toArray();
            $result['level_text'] = $res->level_text;
            $result['status_num'] = $getData['status'];
            return $result;
        }else{
            return $res;
        }
	}

	/**
	 * 申请成为裁判
	 */
	public function createReferee($data){
	    // 验证数据
        $validate = validate('RefereeVal');
        if (!$validate->scene('add')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }

        // 插入数据
        $data['status'] = isset($data['status']) ? $data['status'] : 0;
        $res = $this->RefereeModel->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $this->RefereeModel->id];
        } else {
            trace('error:' . $this->RefereeModel->getError() . ', \n sql:' . $this->RefereeModel->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }


	/**
	 * 裁判更改资料
	 */
	public function updateReferee($data)
    {
        // 验证数据
        $validate = validate('RefereeVal');
        if (!$validate->scene('edit')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }

        // 修改数据
        $res = $this->RefereeModel->allowField(true)->isUpdate(true)->save($data);
        if ($res || ($res===0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $this->RefereeModel->getError() . ', \n sql:' . $this->RefereeModel->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }


    public function SoftDeleteCamp($id) {
        $result = Referee::destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }


    // 裁判列表 分页
    public function getRefereeListByPage( $map=[],$order='id desc',$paginate = 10) {
        $res = $this->RefereeModel->with('member')
            ->where($map)
            ->order($order)
            ->paginate($paginate);

        return $res;
    }

    // 裁判列表 分页
    public function getRefereeList($map=[], $page=1, $order='id desc', $paginate = 10 ) {
        $result = $this->RefereeModel->where($map)->order($order)->page($page,$paginate)->select();

        return $result;

    }





    // 创建裁判评论
    public function createRefereeComment($data){
        $RefereeComemnt = new \app\model\RefereeComment;
        $result = $RefereeComemnt->save($data);
        if($result){
            return ['code' => 200, 'msg' => '评论成功'];
        }else{
            return ['code' => 100, 'msg' => $RefereeComemnt->getError()];
        }
    }
}