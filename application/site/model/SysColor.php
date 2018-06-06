<?php
namespace app\site\model;
use think\Model;

class SysColor extends Model{

    /**
     * 查询所有的颜色
     * @param where
     */
    public function getAllColorsByWhere($where="")
    {
        return $this->where($where)->select();
    }
}
