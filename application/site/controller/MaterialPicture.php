<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;
use think\Image;

class MaterialPicture extends Base
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();
        $this->qiniu_sdk = config('sdk.qiniu_sdk');
        $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
        $buckets = current($Qiniu->buckets(['shared'=>$this->UserInfo['qiniu_account']]));
        if(empty($buckets)){
            $this->redirect('/page404');    
        }else{
            $this->buckets = $buckets;
        }
    }

    /**
     * 图片列表
     */
	public function index($action=null)
    { 
        $action = is_null($action) ? current($this->buckets) : $action; 
        $this->qiniu_sdk['bucket'] = $action;
        $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
        $domain = current(current($Qiniu->domains()));
        if(!$domain){
            $this->redirect('/page404');        
        }
        $this->qiniu_sdk['url'] = $domain;
        $re = $Qiniu->listFiles();
        if(!isset($re[0]['items'])){
            $this->redirect('/page404');
        }
        $bucketName = explode('-', $action);
        $bucketStyle = end($bucketName);//图片样式
        $list = array_slice(current(current($re)),0,30);
        foreach ($list as $key => $value) {
            $list[$key]['bucket'] = $action;
            $list[$key]['title'] = $value['key'];
            $list[$key]['path'] = 'http://'.$this->qiniu_sdk['url'].'/'.$value['key'].'-'.$bucketStyle;
            $list[$key]['create_time'] = date('Y-m-d H:i:s',substr($value['putTime'],0,-7));
        }    
        $this->assign('buckets',$this->buckets);
        $this->assign('action',$action);
        $this->assign('list',$list);
	    return $this->fetch();
	}

    /**
     * 编辑图片
     */
    public function edit()
    {
        if(request()->isAjax())
        {
            $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
            $data = input('post.');
            if($data['oldname']==$data['newname'] && $data['from_bucket']==$data['to_bucket']){
                $this->error('保存成功');       
            }elseif($data['oldname']!=$data['newname'] && $data['from_bucket']==$data['to_bucket']){
                $this->qiniu_sdk['bucket'] = $data['from_bucket'];
                $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
                $re = $Qiniu->rename($data);
            }else{
                $this->qiniu_sdk['bucket'] = $data['to_bucket'];
                $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
                $data['from_key'] = $data['oldname'];
                $data['to_key'] = $data['newname'];
                unset($data['oldname'],$data['newname']);
                $re = $Qiniu->move($data);
            }
            if($re){
                $this->error('保存失败');   
            }else{
                $this->error('保存成功');    
            }     
        }
        $this->redirect('/error');
    }

    /**
     * 删除图片
     */
    public function delete()
    {
        if(request()->isAjax())
        {
            $data = input('post.');
            $this->qiniu_sdk['bucket'] = $data['bucket'];
            $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
            $re = $Qiniu->delete($data);
            if($re){
                $this->error('删除失败');   
            }else{
                $this->error('删除成功');    
            }     
        }
        $this->redirect('/error');
    }
    
    /**
     * 创建图片
     */
    public function create()
    {
        if(request()->isAjax())
        {
            $this->qiniu_sdk['bucket'] = input('post.bucket');
            $name = array_keys($_FILES)[0];
            $file = play_file($_FILES['file'],$name);
            $ids = array();
            $count = 0;
            if(count($file[$name])>0 && checkuc($file[$name]))
            {
                foreach ($file[$name] as $k=>$v){
                   $ext = get_extension($v['name']);
                   $data['file'] = uniqid().'.'.strtolower($ext);
                   $data['filepath']= TEMP_PATH.$data['file']; 
                   move_uploaded_file($v['tmp_name'],$data['filepath']);
                   $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
                   $upload = $Qiniu->putFile($data);
                   if($upload){
                    $count++;
                   }
                }
            }
            if(count($file[$name])==$count)
            {
                deldir(TEMP_PATH);
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            } 
                  
        }
        $this->redirect('/error');
    }

    /**
     * 在富文本编辑器中 获得并上传图片 返回文本
     */
    function uploadContentImg($content,$article_id){
        $ext = 'gif|jpg|jpeg|bmp|png';
        $preg = "/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i";
        preg_match_all($preg, $content, $match);
        $img = array();
        $count = 0;
        $upload_list = $match[3];
        $article_info = $this->Article::get($article_id);
        foreach ($upload_list as $key => $value) {
            $img_data = @file_get_contents($value);
            $ext = get_extension($value);
            $title = $article_info['uniqid'].'-'.$key.'.'.strtolower($ext);
            $imagepath = 'public/acticle/image/'.$article_id.'/';
            $savepath = ROOT_PATH.$imagepath;
            if(!is_dir($savepath)){
                mkdir($savepath,0777);
            }
            $savefile = $savepath.$title; 
            $upload = file_put_contents($savefile,$img_data);
            if($upload)
            {
               $data[$key]['title'] = $title;
               $data[$key]['group_id'] = 0;
               $data[$key]['path'] = 'http://118.31.23.98/ocean/'.$imagepath.$title;
               $data[$key]['create_time'] = date('Y-m-d H:i');
               $count ++;
            }
        }
        if(count($upload_list)==$count && $count>0)
        {
            return $this->putContentImg($content,$data);
        }else{
            return '';
        }
    }

    /**
     * 上传图片
     */    
    function uploadImg($file){
       $ext = get_extension($file['name']);
       $data['file'] = uniqid().'.'.strtolower($ext);
       $data['filepath']= TEMP_PATH.$data['file']; 
       move_uploaded_file($v['tmp_name'],$data['filepath']);
       $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
       $upload = $Qiniu->putFile($data);
       if($upload){
        return $this->qiniu_sdk['url'].$title;
       }else{
        return false;
       }
    }

    /**
     * 替换文本中的图片路径
     */
    function putContentImg($content,$put_list){
        $ext = 'gif|jpg|jpeg|bmp|png';
        $preg = "/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i";
        preg_match_all($preg, $content, $match);
        $img = array();
        $count = 0;
        $put_list = array_column($put_list, 'path');
        $content = $this->get_img_thumb_url($content,'replace_src');
        $count = substr_count($content,'replace_src');
        $arr = explode('replace_src', $content);
        foreach ($arr as $key => $value) {
            foreach ($put_list as $k => $v) {
                if($key==$k){
                    $arr[$key] = $value.$v;
                }
            }
        }
        $text_content = implode($arr);
        return $text_content;
    }

    /**
    * 图片地址替换成压缩URL
    * @param string $content 内容
    * @param string $suffix 后缀
    */
    function get_img_thumb_url($content,$suffix)
    {
        $pregRule = '/src=".*?"/';
        $replace_content = preg_replace($pregRule,'src="'.$suffix.'"',$content);
        if($replace_content==$content){
            $pregRule = "/src='.*?'/";
            $replace_content = preg_replace($pregRule,'src="'.$suffix.'"',$content);
        }
        return $replace_content;
    }


      
}