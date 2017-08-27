<?php
namespace app\admin\controller;
use app\service\UploadService;
use think\Request;

class Upload {
    public function video() {
        if (request()->isPost()) {
            $UploadS = new UploadService();
            $upload_res = $UploadS->uploadVideo();
            return json($upload_res);
        }
    }
}