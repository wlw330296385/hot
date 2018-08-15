<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;

use app\model\Rebate as RebateModel;
use think\Db;

class Rebate extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    // 推荐奖列表
    public function rebateList() {
        $map = [];
        $keyword = input('param.keyword');
        if ($keyword) {
            $map['member'] = ['like', '%'. $keyword .'%'];
        }
        $member_id = input('param.member_id');
        if($member_id){
            $map['member_id'] = $member_id;
        }
        $rebateList = RebateModel::where($map)->order('id desc')->paginate(30);

        $this->assign('rebateList', $rebateList);
        return view('Rebate/rebateList');
    }




    //校园课的推荐费列表
    public function school(){
        
    }

}