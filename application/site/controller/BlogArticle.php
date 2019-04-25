<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;

class BlogArticle extends Base
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageSize = config('paginate.list_rows');
    }

    /**
     * 文章列表
     * @param p
     * @param title
     */
	public function index($p=1,$title='')
    {
        $title = str_content_replace($title);
        $where = isset($title) ? "article_id>0 and article_title like '%{$title}%'" : "";
        $count= $this->Article->getAllArticleCountByWhere($where);
        if((is_mobile_request()==true) && ($count>100)){
            $this->pageSize = ceil($count/9);
        }
        $allart = $this->Article->getAllArticleByWhere($p,$where,$this->pageSize);
        $page = ceil($count/$this->pageSize);
        $this->assign('allart',$allart);
        $this->assign('p',$p);
        $this->assign('page',$page);
        $this->assign('title',$title);
	    return $this->fetch();
	}

    /**
     * 创建文章
     * @param id
     */
    public function create($id='')
    {
        //判断是否是手机登录
        if(is_mobile_request())
        {
            $this->length = 6;
        }else{
            $this->length = 1;
        }
        $this->assign('length',$this->length); 
        if(request()->isAjax())
        {
            $article = input('post.article/a');
            $article['article_title'] = strtolower($article['article_title']);
            $article['user_id'] = $this->UserInfo['id'];
            $article['create_time'] = $article['create_time'].' '.date("H:i");
            if($article['article_id'])
            {
                $ids = $this->ArticleDes->getIdByArticleId($article['article_id']);
                if($ids){
                    $this->destorybyid('ArticleDes',$ids,2);    
                }
                $re = $this->Article->allowField(true)->save($article,['article_id'=>$article['article_id']]);   
                if($re || ($re===0))
                {
                    $insertId = $article['article_id'];    
                }else{
                    $insertId = '';    
                } 
            }else{
                $insertId = $this->Article->allowField(true)->insertGetId($article);
            }
            if($insertId)
            {
                $des = json_decode(input('post.des/a')[0],true);
                if(is_array($des)){
                    foreach ($des as $key=>$value) {
                        $article_des[$key]['article_id'] = $insertId;
                        $article_des[$key]['name'] = strtolower($value['name']);
                        $text = (new MaterialPicture)->uploadContentImg($value['text'],$insertId);
                        if($text){
                            $article_des[$key]['text'] = $text;
                        }else{
                            $article_des[$key]['text'] = $value['text'];
                        }
                    }  
                    if(isset($article_des)){
                        $re = $this->ArticleDes->allowField(true)->saveAll($article_des);    
                    }  
                }
                
                if($re || ($re===0))
                {   
                    $this->success('保存成功',"",['article_id'=>$insertId]);
                }    
            }else{
                $this->error('保存失败');
            }       
        }
        $articletype = $this->ArticleType->getAllArticleTypeByWhere();
        $this->assign('articletype',$articletype);
        if(!empty($id)){
            $cfilter['article_id'] = $id;
            $content = $this->Article->getArticleByWhere($cfilter);
            if(empty($content)){
                $this->redirect('/error');
            }
            $tfilter['type_id'] = $content['type_id'];
            $tag = $this->ArticleTags->getAllTagsByWhere($tfilter);
            $tag_count = count($tag);
            $tags = [];
            if(is_mobile_request()){
                $this->pageSize = 2;
            }else{
                $this->pageSize = 12;
            }
            $maxCount = ceil($tag_count/$this->pageSize);
            for ($i=0; $i <= $this->pageSize ; $i++) { 
                $start = $i*$maxCount;
                $tags[$i] = array_slice($tag,$start,$maxCount);
            }
            if(strstr($content['tag_ids'],','))
            {
                $arr = explode(',',$content['tag_ids']);
                $content['tag_ids']=$arr;
                foreach ($tags as $key => $value) {
                    foreach ($value as $k => $v) {
                        if(in_array($v['id'],$content['tag_ids'])){
                            $tags[$key][$k]['check']=1;
                        }else{
                            $tags[$key][$k]['check']=0;
                        }
                    }
                }
            }else{
                foreach ($tags as $key => $value) {
                    foreach ($value as $k => $v) {
                        if($content['tag_ids']==$v['id']){
                            $tags[$key][$k]['check']=1;
                        }else{
                            $tags[$key][$k]['check']=0;
                        }
                    }
                }
            }
            $content['tags'] = $tags;
            $content['des'] = $this->Article->getDes()->where("article_id",$id)->select();
            $this->assign('content',$content);
            return $this->fetch('edit');
        }
    	return $this->fetch();
    }
}