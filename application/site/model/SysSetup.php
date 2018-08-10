<?php
namespace app\site\model;
use think\Model;

class SysSetup extends Model{

    /**
     * 查询所有的系统设置名称
     * @param where
     */
    public function getAllSetupName($where="")
    {
        return $this->where($where)->order('sort asc')->select();
    }
}
