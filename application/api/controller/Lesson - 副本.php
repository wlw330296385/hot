<?php
namespace app\api\controller;
use app\api\controller\Base;
use think\Request;
use app\service\LessonService;
class Member extends Base{

    protected $lessonService;

    public function _initialize() {   
        parent::_initialize();  
        $this->lessonService = new LessonService;
    }

    // 获取课程列表
    public function getLessionList(){
        $map = Request::instance()->param();
        $result = $this->lessonService->getLessonAll($map);

        return json($result);
    }
    
    // 发布课程
    public function pubLesson(){
        $data = Request::instance()->param();
        $data['member'] = $this->memberInfo['member'];
        $data['member_id'] = $this->memberInfo['id'];
        $result = $this->lessonService->pubLesson($data);
        return json($result);
    }

}
