<?php
namespace app\site\model;
use think\Model;


class Sdk extends Model{

    protected $updateTime  = false;

    protected $autoWriteTimestamp = 'datetime';

    protected $type = [
        'create_time'  =>  'datetime:Y/m/d H:i:s',
    ];

    /**
     * 查询所有sdk
     */
    public function getsdk(){
        return $this->where('sdk_status',1)->where('user_id',session('id'))->field('sdk_id,sdk_name')->select();   
    }

    /**
     * 查询单个sdk内容
     * @param $where
     */
    public function getSdkByWhere($where){
        $data = $this->where($where)->where('user_id',session('id'))->find();
        if($data) $data['sdk_info'] = json_decode($data['sdk_info'],true);
        return $data;
    }
}
