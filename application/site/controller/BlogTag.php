<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;
use think\Request;

class BlogTag extends Base
{

    /**
     * Index constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

	public function index(){
        $tags = $this->ArticleTags->getAllTagsByWhere();
        foreach ($tags as $key => $value) {
            $value['count'] = $this->Article->getAticleCountsByTagId($value['id']);
        }
        $this->assign('tags',$tags);
	    return $this->fetch();
	}

    public function create(Request $request,$id=''){
        if($request->isAjax()){
            $tags = object_to_array(json_decode(input('post.tags/a')[0]));
            $tag = [];
            foreach ($tags as $key=>$value) {
                if(array_key_exists('id',$value)){
                $tag[$key]['id'] = $value['id'];    
                }
                $tag[$key]['value'] = $value['value'];
                $tag[$key]['intro'] = $value['intro'];
            }
            $re = $this->ArticleTags->allowField(true)->saveAll($tag);
            if($re){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            } 
        }
        if(!empty($id)){
            $obj = $this->ArticleTags;
            $content = $obj::get($id);
            if(empty($content)){
                $this->redirect('/error');
            }
            $this->assign('content',$content);
            return $this->fetch('edit');
        }
        return $this->fetch();
    }
}