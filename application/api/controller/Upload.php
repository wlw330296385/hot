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
    // 截取图片 保存到指定目录
    public function imgcropupload() {
        $data = input('post.');
        $res = $this->base64_image_content($data['dataurl'], $data['path']);
        if ($res) {
            $return = ['error' => 0, 'success' => 1, 'status' => 1, 'path' => $res];
        } else {
            $return = ['error' => 1, 'success' => 0, 'status' => 0, 'msg' => '上传图片失败'];
        }
        return json($return);
    }

    /**
     * [将Base64图片转换为本地图片并保存]
     * @param  [Base64] $base64_image_content [要保存的Base64]
     * @param  [目录] $path [要保存的路径]
     * @return bool|string
     */
    function base64_image_content($base64_image_content,$path){
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            //$new_file = $path."/".date('Ymd',time())."/";
            $new_file =  "uploads" . DS . "images". DS . $path . DS . date('Y') . DS . date('m') . DS;
            if(!file_exists($new_file)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            // 保存的图片文件名
            $new_file = $new_file.sha1(time()).".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                return '/'.$new_file;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}