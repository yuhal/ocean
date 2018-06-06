<?php
namespace app\site\model;
use think\Model;

class ArticleDes extends Model{

	/**
     * 查询该详情所属的文章id
     * @param pid
     */
    public function getIdByArticleId($article_id)
    {
    	return $this->where('article_id',$article_id)->column('id');
    }

}
