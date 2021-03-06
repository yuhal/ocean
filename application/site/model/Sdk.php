<?php
namespace app\site\model;
use think\Model;

class Sdk extends Model{

    //修改时间开启状态
    protected $updateTime  = false;

    /**
     * 开启自动写入创建时间
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 数据类型转换
     */
    protected $type = [
        'create_time'  =>  'datetime:Y/m/d H:i',
    ];

    /**
     * 查询所有sdk
     */
    public function getsdk()
    {
        return $this->where('sdk_status',1)->field('sdk_id,sdk_name')->select();   
    }

    /**
     * 查询单个sdk内容
     * @param where
     */
    public function getSdkByWhere($where)
    {
        $data = $this->where($where)->find();
        if($data) $data['sdk_info'] = json_decode($data['sdk_info'],true);
        return $data;
    }
}
