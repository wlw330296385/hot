<?php
namespace app\api\controller;
use app\service\UploadService;
use think\Request;

class Upload {
    public function videoUpload() {
        if (request()->isPost()) {
            $UploadS = new UploadService();
            $upload_res = $UploadS->uploadVideo();
            return json($upload_res);
        }
    }

    public function imgUpload(){
    	
    }
}