<?php
namespace app\site\model;
use think\Model;

class PictureGroup extends Model{

    /**
     * 查询所有的分组
     * @param $where
     */
    public function getAllGroupsByWhere($where=""){
        return $this->where($where)->select();
    }
}
