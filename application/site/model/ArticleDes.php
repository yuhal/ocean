<?php
namespace app\site\model;
use think\Model;

class ArticleDes extends Model{

	/**
     * 查询该详情所属的文章id
     * @param $pid
     */
    public function getIdBypid($pid){
    	return $this->where('pid',$pid)->column('id');
    }

}
