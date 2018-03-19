<?php
namespace app\api\controller;
use app\service\UploadService;
use think\Image;
use think\Request;

class Upload {
    public function videoUploadApi() {
        if (request()->isPost()) {
            $UploadS = new UploadService();
            $upload_res = $UploadS->uploadVideo();
            return json($upload_res);
        }
    }

    // webuploader 上传图片api
    public function imgwupload()
    {
        $return = ['error' => 0, 'success' => 1, 'status' => 1];
        $file = request()->file('file');
        if ($file) {
            // 上传目录：uploads/images/图片用途/年/月（相对项目路径，用于保存数据）
            $usage = input('usage') ? input('usage') : 'other';
            $dirName =  "uploads" . DS . "images". DS . $usage . DS . date('Y') . DS . date('m');
            // 上传目录（绝对路径，用于保存文件）
            $saveDir = ROOT_PATH  . "public" . DS. $dirName;
            // 上传文件
            $info = $file->rule('uniqid')->move($saveDir);
            if ($info) {
                // 获取上传后图片信息
                $image = Image::open($info->getRealPath());
                $imageWidth = $image->width();
                $imageHeight = $image->height();
                // 压缩文件绝对路径+文件名
                $saveThumb = "thumb_" . $info->getFileName();
                // 压缩图片
                $image->thumb($imageWidth/2, $imageHeight/2, Image::THUMB_CENTER)->save($saveDir . DS .$saveThumb);
                $return['path'] = '/'. $dirName . DS . $saveThumb;
                $return['url'] = '/'. $dirName . DS . $saveThumb;
            } else {
                $return['error'] = 1;
                $return['success'] = 0;
                $return['status'] = 0;
                $return['msg'] = '上传出错:' . $file->getError();
            }
        }
        return json($return);
    }
    
}