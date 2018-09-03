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
	public function index()
    {
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
    public function create($id='')
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
        $articleType = $this->ArticleType->getAllArticleType();
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
            return $this->fetch('edit');
        }
        return $this->fetch();
    }
}