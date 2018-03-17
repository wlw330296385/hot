<?php
namespace app\api\controller;
use app\service\UploadService;
use think\Request;

class Upload {
    public function videoUploadApi() {
        if (request()->isPost()) {
            $UploadS = new UploadService();
            $upload_res = $UploadS->uploadVideo();
            return json($upload_res);
        }
    }

    public function imgwupload() {
        $return = ['error' => 0, 'success' => 1, 'status' => 1];
        $file = request()->file('file');
        if ($file) {
            $usage = input('usage') ? input('usage') : 'other';
            $savePath = 'uploads'. DS . 'images' . DS . $usage . DS . date('Y') . DS . date('m');
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public'. DS .$savePath);
            if ($info) {
                $return['path'] = '/' . $savePath . '/' . $info->getFilename();
            } else {
                $return['error'] = 1;
                $return['success'] = 0;
                $return['status'] = 0;
                $return['message'] = '上传出错:'.$file->getError();
            }
        }
        return json($return);
    }
    
}