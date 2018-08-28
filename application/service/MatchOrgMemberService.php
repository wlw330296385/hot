<?php

namespace app\service;
use app\model\MatchOrgMember;
use think\Db;

class MatchOrgMemberService {
	
    public function getMatchOrgMember($map)
    {
        $model = new MatchOrgMember();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        $result['type_num'] = $res->getData('type');
        return $result;
    }

}