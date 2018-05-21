<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;
use think\Request;
use think\Image;

class MaterialPicture extends Base
{

    /**
     * Index constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $data = $this->Sdk->getSdkByWhere(array('sdk_name'=>'qiniu_sdk'));
        config('sdk.qiniu_sdk',$data['sdk_info']);
        $this->qiniu_sdk = config('sdk.qiniu_sdk');
    }

	public function index(){
        $groups = $this->PictureGroup->getAllGroupsByWhere();
        $pictures = $this->Picture->getAllPicturesByWhere();
        foreach ($groups as $key => $value) {
            $value['count'] = $this->Picture->getPictureCountsByGroupId($value['id']);
        }
        $this->assign('groups',$groups);
        $this->assign('pictures',$pictures);
	    return $this->fetch();
	}

    public function edit(Request $request){
        if($request->isAjax()){
            $data = input('post.');
            $title = $data['title'];
            $group_id = $data['group_id'];
            $id = $data['id'];
            $edit = ['title'=>$title,'group_id'=>$group_id];
            $where = "title='{$title}' and group_id={$group_id}";
            $re = $this->Picture->save($edit,['id'=>$id]);
            if($re || ($re===0)){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }       
        }
        $this->redirect('/error');
    }
    
    public function create(Request $request){
        if($request->isAjax()){
            $name = array_keys($_FILES)[0];
            $file = play_file($_FILES['file'],$name);
            $ids = array();
            $count = 0;
            if(count($file[$name])>0 && checkuc($file[$name])){
                foreach ($file[$name] as $k=>$v){
                   $ext = get_extension($v['name']);
                   $title = uniqid().'.'.strtolower($ext);
                   $savefile= '/var/www/sea/runtime/temp/'.$title; 
                   move_uploaded_file($v['tmp_name'],$savefile);
                   try {
                    $Qiniu = new \qiniu\QiniuSdk($this->qiniu_sdk);
                    $upload = $Qiniu->upload($title,$savefile);
                   }catch(\Exception $e){
                    $this->error($e->getMessage());
                   }
                   if($upload){
                       $data[$k]['title']=$title;
                       $data[$k]['group_id']=0;
                       $data[$k]['path']=$this->qiniu_sdk['url'].$title;
                       $data[$k]['create_time']=date('Y-m-d H:i:s');
                       $count ++;
                   }
                }
                $this->Picture->insertAll($data); 
            }
            if(count($file[$name])==$count){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            } 
                  
        }
        $this->redirect('/error');
    }
  
}