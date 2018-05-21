<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;
use think\Request;

class BlogCategory extends Base
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
        $categories = $this->ArticleType->getAllArticleTypeByWhere();
        foreach ($categories as $key => $value) {
            $value['count'] = $this->Article->getAticleCountsByTypeId($value['id']);
        }
        $this->assign('categories',$categories);
	    return $this->fetch();
	}

    public function create(Request $request,$id=''){
        $colors = $this->SysColor->getAllColorsByWhere();
        $this->assign('colors',$colors);
        $this->assign('length',$this->length);
        if($request->isAjax()){
            $categories = object_to_array(json_decode(input('post.categories/a')[0]));
            $category = [];
            foreach ($categories as $key=>$value) {
                if(array_key_exists('id',$value)){
                $category[$key]['id'] = $value['id'];    
                }
                $category[$key]['value'] = $value['value'];
                $category[$key]['color'] = $value['color'];
                $category[$key]['intro'] = $value['intro'];
            }
            $re = $this->ArticleType->allowField(true)->saveAll($category);
            if($re){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }       
        }
        if(!empty($id)){
            $obj = $this->ArticleType;
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