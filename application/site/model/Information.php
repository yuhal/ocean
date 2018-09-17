<?php
namespace app\site\model;
use think\Model;

class Information extends Model{
    /**
     * 查询所有的资讯
     * @param p
     * @param where
     */
    public function getAllInformationByWhere($where=null)
    {
        $data = $this->where($where)
        ->order('create_time desc')
        ->select();
        return $data;
    }

    /**
     * 查询某个资讯的的详情
     * @param where 
     */
    public function getInformationyWhere($where)
    {
        return $this->where($where)->find();
    }
}
