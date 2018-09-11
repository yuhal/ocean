<?php
namespace app\site\model;
use think\Model;
use traits\model\SoftDelete;

class ArticleType extends Model{

    /**
     * 使用软删除
     */
    use SoftDelete;

    /**
     * 开启自动写入字段
     */
    protected static $deleteTime = 'delete_time';

    /**
     * 创建时间开启状态
     */
    protected $ceateTime  = true;

    /**
     * 关联查询该分类下的文章
     * @return \think\model\relation\HasMany
     */
	public function getArticle()
    {
        return $this->hasMany('Article','type_id');
    }

    /**
     * 关联查询该分类下的文章
     * @return \think\model\relation\HasMany
     */
    public function getAllArticle()
    {
        return $this->belongsToMany('Article');
    }

    /**
     * 查询分类
     * @param where
     */
    public function getAllArticleTypeByWhere($where="")
    {
        return $this::withTrashed()->where($where)
        ->order('id desc')
        ->select();
    }


}
