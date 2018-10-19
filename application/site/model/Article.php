<?php
namespace app\site\model;
use think\Model;
use traits\model\SoftDelete;

class Article extends Model{

    /**
     * 使用软删除
     */
    use SoftDelete;

    /**
     * 开启自动写入字段
     */
    protected static $deleteTime = 'delete_time';

    /**
     * 关联查询某个文章的详情
     * @return \think\model\relation\HasMany
     */
    public function getDes()
    {
        return $this->hasMany('ArticleDes', 'article_id');
    }

    /**
     * 根据搜索条件获取所有的文章的数量
     * @param where
     */
    public function getAllArticleCountByWhere($where)
    {
        return $this::withTrashed()->where($where)->count();
    }

    /**
     * 查询所有的文章
     * @param p
     * @param where
     * @param pageSize
     */
    public function getAllArticleByWhere($p,$where)
    {
        $start = ($p-1)*$pageSize;
        $data = $this::withTrashed()->alias('a')
        ->join('article_type b','b.id=a.type_id')
        ->field('a.article_id,a.tag_ids,a.article_title,a.create_time,a.delete_time,a.note,b.value,b.color')
        ->where($where)
        ->order('a.create_time desc')
        ->limit($start,$pageSize)
        ->select();
        return $data;
    }

    /**
     * 查询某个文章的详情
     * @param where 
     */
    public function getArticleByWhere($where)
    {
        return $this->alias('a')
        ->join('article_type b','b.id=a.type_id')
        ->field('a.article_title,a.create_time,a.note,b.color,a.type_id,b.value,a.article_id,a.tag_ids')
        ->where($where)
        ->find();
    }

    /**
     * 查询某个分类下未删除的文章id
     * @param where 
     */
    public function getArticleIdsByWhere($where="")
    {
        return $this->where($where)->column('article_id');
    }

    /**
     * 查询某个分类下全部的文章id
     * @param $this 
     */
    public function getSortDelArticleIdsByWhere($where="")
    {
        return $this::withTrashed()->where($where)->column('article_id');
    }

    /**
     * 查询单个标签下的文章总数
     * @param id
     */
    public function getAticleCountsByTagId($id)
    {
        $where[]=['exp',"FIND_IN_SET($id,tag_ids)"];
        return $this->where($where)->count();
    }

    /**
     * 查询单个分类下的文章总数
     * @param id
     */
    public function getAticleCountsByTypeId($id)
    {
        return $this->where('type_id',$id)->count();
    }

    /**
     * 查询某个文章的uniqid
     * @param where 
     */
    public function getUniqidIdByWhere($where="")
    {
        return $this->where($where)->column('article_id');
    }
}
