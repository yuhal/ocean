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
        return $this->where($where)->order('region,sort')->select();
    }

    /**
     * 查询所有的系统设置分组
     * @param where
     */
    public function getAllSetupRegion($where="")
    {
        $region = $this->where($where)->field('region')->group('region')->select();
        foreach ($region as $key => $value) {
        	switch ($value['region']) {
        		case 'in':
        			$region[$key]['comment'] = '后台系统设置';
        			break;
        		case 'out':
        			$region[$key]['comment'] = '前台系统设置';
        			break;
        	}
        }
        return $region;
    }

    
}
