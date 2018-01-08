<?php
namespace app\admin\controller;
use app\service\UploadService;
use think\Request;

class Upload {
    // 上传视频 七牛云
    public function video() {
        if (request()->isPost()) {
            $UploadS = new UploadService();
            $upload_res = $UploadS->uploadVideo();
            return json($upload_res);
        }
    }

    // 平台banner上传
    public function systemBanner() {
        if (request()->isPost()) {
            $file = request()->file('file');
            $savePath = ROOT_PATH . 'public'. DS . 'uploads'. DS.'images' . DS . 'banner';
            $info = $file->rule('uniqid')->move($savePath);
            //dump($info);
            if ($info) {
                $res = ['err' => 0, 'status' => 1, 'msg' => __lang('MSG_202'), 'data' => '/uploads/images/banner/'. $info->getFilename()];
            } else {
                $res = ['err' => 1, 'status' => 1, 'msg' => $file->getError()];
            }
            return json($res);
        }
    }

    // 平台班级|课程类型图片上传
    public function uploadImg() {
        $dir = input('param.dir','common');
        if (request()->isPost()) {
            $file = request()->file('file');
            $savePath = ROOT_PATH . 'public'. DS . 'uploads'. DS.'images' . DS . $dir;
            $info = $file->rule('uniqid')->move($savePath);
            //dump($info);
            if ($info) {
                $res = ['err' => 0, 'status' => 1, 'msg' => __lang('MSG_202'), 'data' => '/uploads/images/'.$dir.'/'. $info->getFilename()];
            } else {
                $res = ['err' => 1, 'status' => 1, 'msg' => $file->getError()];
            }
            return json($res);
        }
    }



    // 卡券图片上传

}