<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;

class BlogCategory extends Base
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 分类&标签列表
     */
	public function index()
    {
        $categories = $this->ArticleType->getAllArticleTypeByWhere();
        foreach ($categories as $key => $value) {
            $value['tags'] = $this->ArticleTags->getAllTagsByWhere(['type_id'=>$value['id']]);
            $value['tagcount'] = count($value['tags']);
        }
        $categories = arraySort($categories,'tagcount','desc');
        $this->assign('categories',$categories);
	    return $this->fetch();
	}

    /**
     * 创建文章分类
     * @param id
     */
    public function article_type($id='')
    {
        $colors = $this->SysColor::select();
        $this->assign('colors',$colors);
        $this->assign('length',$this->length);
        if(request()->isAjax())
        {
            $categories = json_decode(input('post.categories/a')[0],true);
            $informations = [];
            foreach ($categories as $key=>$value) {
                if(array_key_exists('id',$value)){
                $category[$key]['id'] = $value['id'];    
                }
                $category[$key]['value'] = $value['value'];
                $category[$key]['color'] = $value['color'];
                $category[$key]['intro'] = $value['intro'];
            }
            $re = $this->ArticleType->allowField(true)->saveAll($category);
            if($re)
            {
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }       
        }
        if(!empty($id))
        {
            $obj = $this->ArticleType;
            $content = $obj::get($id);
            if(empty($content))
            {
                $this->redirect('/error');
            }
            $this->assign('content',$content);
            return $this->fetch('edit_article_type');
        }
        return $this->fetch();
    }

    /**
     * 获取单个文章分类信息
     * @param id
     */
    public function get_article_type($id){
        if(request()->isAjax())
        {
            $re = $this->ArticleType::get($id);
            if($re)
            {
                $this->success('查询成功','',$re);
            }else{
                $this->error('查询失败');
            }     
        }
    }

    /**
     * 获取单个文章分类下的标签
     * @param id
     */
    public function getAllTagsByType($id){
        if(request()->isAjax())
        {
            $re_tags = $this->ArticleTags->getAllTagsByWhere(['type_id'=>$id]);
            $tags_count = count($re_tags);
            $re = [];
            if(is_mobile_request()){
                $this->pageSize = 2;
            }else{
                $this->pageSize = 12;
            }
            $maxCount = ceil($tags_count/$this->pageSize);
            for ($i=0; $i <= $this->pageSize ; $i++) { 
                $start = $i*$maxCount;
                $re[$i] = array_slice($re_tags,$start,$maxCount);
            }
            if($re)
            {
                $this->success('查询成功','',$re);
            }else{
                $this->error('查询失败');
            }     
        }
    }

    /**
     * 创建文章标签
     * @param id
     */
    public function article_tag($id='')
    {
        if(request()->isAjax())
        {
            $tags = json_decode(input('post.tags/a')[0],true);
            $tag = [];
            foreach ($tags as $key=>$value) {
                if(array_key_exists('id',$value)){
                $tag[$key]['id'] = $value['id'];    
                }
                $tag[$key]['value'] = $value['value'];
                $tag[$key]['intro'] = $value['intro'];
                $tag[$key]['type_id'] = $value['type_id'];
            }
            $re = $this->ArticleTags->allowField(true)->saveAll($tag);
            if($re)
            {
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            } 
        }
        $articleType = $this->ArticleType->getAllArticleTypeByWhere();
        $this->assign('articleType',$articleType);
        if(!empty($id))
        {
            $obj = $this->ArticleTags;
            $content = $obj::get($id);
            if(empty($content))
            {
                $this->redirect('/error');
            }
            $this->assign('content',$content);
            return $this->fetch('edit_article_tag');
        }
        return $this->fetch();
    }
}