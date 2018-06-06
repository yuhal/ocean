<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;

class BlogTag extends Base
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 文章标签列表
     */
	public function index(){
        $tags = $this->ArticleTags->getAllTagsByWhere();
        foreach ($tags as $key => $value) {
            $value['count'] = $this->Article->getAticleCountsByTagId($value['id']);
        }
        $this->assign('tags',$tags);
	    return $this->fetch();
	}

    /**
     * 创建文章标签
     * @param id
     */
    public function create($id=''){
        if(request()->isAjax()){
            $tags = object_to_array(json_decode(input('post.tags/a')[0]));
            $tag = [];
            foreach ($tags as $key=>$value) {
                if(array_key_exists('id',$value)){
                $tag[$key]['id'] = $value['id'];    
                }
                $tag[$key]['value'] = $value['value'];
                $tag[$key]['intro'] = $value['intro'];
            }
            $re = $this->ArticleTags->allowField(true)->saveAll($tag);
            if($re){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            } 
        }
        if(!empty($id)){
            $obj = $this->ArticleTags;
            $content = $obj::get($id);
            if(empty($content)){
                $this->redirect('/error');
            }
            $this->assign('content',$content);
            return $this->fetch('edit');
        }
        return $this->fetch();
    }
}