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
        $data = $this->Sdk->getSdkByWhere(array('sdk_name'=>'qiniu_sdk'));
        config('sdk.qiniu_sdk',$data['sdk_info']);
        $this->qiniu_sdk = config('sdk.qiniu_sdk');
    }

    /**
     * 图片列表
     */
	public function index()
    {
        $groups = $this->PictureGroup->getAllGroupsByWhere();
        $pictures = $this->Picture->getAllPicturesByWhere();
        foreach ($groups as $key => $value) {
            $value['count'] = $this->Picture->getPictureCountsByGroupId($value['id']);
        }
        $this->assign('groups',$groups);
        $this->assign('pictures',$pictures);
	    return $this->fetch();
	}

    /**
     * 编辑图片
     */
    public function edit()
    {
        if(request()->isAjax())
        {
            $data = input('post.');
            $title = $data['title'];
            $group_id = $data['group_id'];
            $id = $data['id'];
            $edit = ['title'=>$title,'group_id'=>$group_id];
            $where = "title='{$title}' and group_id={$group_id}";
            $re = $this->Picture->save($edit,['id'=>$id]);
            if($re || ($re===0))
            {
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
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
            $name = array_keys($_FILES)[0];
            $file = play_file($_FILES['file'],$name);
            $ids = array();
            $count = 0;
            if(count($file[$name])>0 && checkuc($file[$name]))
            {
                foreach ($file[$name] as $k=>$v){
                   $ext = get_extension($v['name']);
                   $title = uniqid().'.'.strtolower($ext);
                   $savefile= '/var/www/ocean/runtime/temp/'.$title; 
                   move_uploaded_file($v['tmp_name'],$savefile);
                   try {
                    $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
                    $upload = $Qiniu->upload($title,$savefile);
                   }catch(\Exception $e){
                    $this->error($e->getMessage());
                   }
                   if($upload)
                   {
                       $data[$k]['title']=$title;
                       $data[$k]['group_id']=0;
                       $data[$k]['path']=$this->qiniu_sdk['url'].$title;
                       $data[$k]['create_time']=date('Y-m-d H:i');
                       $count ++;
                   }
                }
                $this->Picture->insertAll($data); 
            }
            if(count($file[$name])==$count)
            {
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
    function uploadContentImg($content){
        $ext = 'gif|jpg|jpeg|bmp|png';
        $preg = "/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i";
        preg_match_all($preg, $content, $match);
        $img = array();
        $count = 0;
        $upload_list = $match[3];
        foreach ($upload_list as $key => $value) {
            $img_data = @file_get_contents($value);
            $ext = get_extension($value);
            $title = uniqid().$key.'.'.strtolower($ext);
            $savefile= '/var/www/ocean/runtime/temp/'.$title; 
            file_put_contents($savefile,$img_data);
            try {
                $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
                $upload = $Qiniu->upload($title,$savefile);
            }catch(\Exception $e){
                $this->error($e->getMessage());
            }
            if($upload)
            {
               $data[$key]['title']=$title;
               $data[$key]['group_id']=0;
               $data[$key]['path']=$this->qiniu_sdk['url'].$title;
               $data[$key]['create_time']=date('Y-m-d H:i');
               $count ++;
            }
        }
        if(count($upload_list)==$count && $count>0)
        {
            $this->Picture->insertAll($data); 
            return $this->putContentImg($content,$data);
        }else{
            return '';
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
        $content = preg_replace($pregRule,'src="'.$suffix.'"',$content);
        return $content;
    }
      
}