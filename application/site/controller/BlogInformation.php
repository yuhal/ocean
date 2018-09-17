<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;

class BlogInformation extends Base
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 最新资讯列表
     * @param p
     * @param title
     */
	public function index()
    {
        $informations = $this->Information->getAllInformationByWhere();
        $this->assign('informations',$informations);
	    return $this->fetch();
	}

    /**
     * 创建/修改最新资讯
     * @param id
     */
    public function create($id='')
    {
        if(request()->isAjax())
        {
            $title = input('post.title');
            $re = $this->Information->where('id',$id)->update(['title'=>$title]);
            if($re || ($re===0))
            {
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            } 
        }
        return $this->fetch();
    }
}