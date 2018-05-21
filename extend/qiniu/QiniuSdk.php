<?php
namespace qiniu;

require 'php-sdk/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class QiniuSdk{

 public $sdk_info;

 function __construct($info){
  $this->sdk_info = $info;
 }

 public function upload($file,$filepath){
  // 构建 UploadManager 对象
  
  $uploadMgr = new UploadManager();
  $auth = new Auth($this->sdk_info['accessKey'],$this->sdk_info['secretKey']);
  $bucket = $this->sdk_info['bucket'];
  // 生成上传Token
  $token = $auth->uploadToken($bucket);
  return $uploadMgr->putFile($token,$file,$filepath);
  //var_dump($uploadMgr->putFile($token,'test.png','/var/www/sea/extend/qiniu/test.png'));exit;
 }
}