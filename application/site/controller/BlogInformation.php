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
        foreach ($informations as $key => $value) {
            $informations[$key]['intro'] = $value['title'];
            if(mb_strlen($value['title'],'utf-8')>=18 && is_mobile_request()){
                $informations[$key]['title'] = mb_substr($value['title'],0,18,'utf-8').'...';  
            }            
        }
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
            if($id){
                $title = input('post.title');
                $re = $this->Information->where('id',$id)->update(['title'=>$title]);    
            }else{
                $informations = json_decode(input('post.informations/a')[0],true);
                $information = [];
                foreach ($informations as $key=>$value) {
                    if(array_key_exists('id',$value)){
                    $information[$key]['id'] = $value['id'];    
                    }
                    $information[$key]['title'] = $value['title'];
                    $information[$key]['url'] = $value['url'];
                }
                $re = $this->Information->saveAll($information);
            }
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