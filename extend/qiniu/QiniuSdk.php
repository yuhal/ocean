<?php
namespace qiniu;

require 'php-sdk/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class QiniuSdk{

	public $sdk_info;

	function __construct($info){
		$this->sdk_info = $info;
		$this->Auth = new Auth($this->sdk_info['accessKey'],$this->sdk_info['secretKey']);
		$this->uploadMgr = new UploadManager();
		$this->bucketMgr = new BucketManager($this->Auth);
	}

	public function upload($file,$filepath){
	  	// 生成上传Token
	  	$token = $this->Auth->uploadToken($this->sdk_info['bucket']);
	  	return $this->uploadMgr->putFile($token,$file,$filepath);
	}

	public function uptoken(){
	  	// 生成上传Token
	  	$token = $auth->uploadToken($this->sdk_info['bucket']);
	  	return $token;
	}

	public function listfile(){
		return $this->bucketMgr->listFiles($this->sdk_info['bucket']);
	}

	public function copy(){
		$a = current(current($this->bucketMgr->listFiles('yuhai')));
		foreach ($a as $key => $value) {
			var_dump('<pre>',$this->bucketMgr->copy('yuhai',$value['key'],'yuhal-image',$value['key'])).PHP_EOL;
		}
		exit;
	}
}