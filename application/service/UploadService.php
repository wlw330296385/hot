<?php
namespace app\service;
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use think\File;

class UploadService {

    public function uploadVideo() {
        /*$file = $request->file('file');
        $savePath = ROOT_PATH .'public'. DS .'uploads';
        $info = $file->move($savePath);*/
        $file = request()->file('file');
        $filePath = $file->getRealPath();
        $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
        $key = date('Ymd').substr(md5($filePath), 0, 5).uniqid().'.'.$ext;

        require_once VENDOR_PATH.'qiniu/php-sdk/autoload.php';
        $accessKey = config('qn_accesskey');
        $secretKey = config('qn_secretkey');
        $auth = new Auth($accessKey, $secretKey);
        $bucket = config('qn_bucket');
        $domain = config('qn_domain');
        $token = $auth->uploadToken($bucket);
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return ['err' => 1, 'code' => 100, 'msg' => $err, 'data' => ''];
        } else {
            return ['err' => 0, 'code' => 200, 'msg' => __lang('MSG_200'), 'data' => $domain.$ret['key']];
        }
    }





        public function imgUpload(){
            $file = request()->file('img');
            $filePath = $file->getRealPath();   
            $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
            $key = date('Ymd').substr(md5($filePath), 0, 5).uniqid().'.'.$ext; 
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename(); 
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }


        public function imgUploadQiniu(){
            
        }

}