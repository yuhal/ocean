<?php
namespace app\site\model;
use think\Model;

class Picture extends Model{

    /**
     * 查询所有的图片
     * @param where
     */
    public function getAllPicturesByWhere($where="")
    {
        return $this->where($where)->order("id desc")->select();

    }

    /**
     * 查询该分组下所有的图片数量
     * @param where
     */
    public function getPictureCountsByGroupId($group_id)
    {
    	return $this->where("group_id",$group_id)->count();
    }
}
