<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;
use think\Request;

class BlogArticle extends Base
{
    public $pageSize;

    /**
     * Index constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->pageSize = config('paginate.list_rows');
    }

	public function index($p=1,$title=''){
        $title = str_content_replace($title);
        $where = isset($title) ? "article_id>0 and article_title like '%{$title}%'" : "";
        $allart = $this->Article->getAllArticleByWhere($p,$where,$this->pageSize);
        $count= $this->Article->getAllArticleCountByWhere($where);
        $page = ceil($count/$this->pageSize);//总页数
        $this->assign('allart',$allart);
        $this->assign('p',$p);
        $this->assign('page',$page);
        $this->assign('title',$title);
	    return $this->fetch();
	}

    public function create($id=''){
        if(Request::instance()->isAjax()){
            $article = input('post.article/a');
            $article['user_id'] = $this->UserInfo['id'];
            $article['create_time'] = $article['create_time'].' '.date("H:i:s");
            if(array_key_exists('article_id',$article)){
                $re = $this->Article->allowField(true)->save($article,['article_id'=>$article['article_id']]);         
                $insertId = $re ? $article['article_id'] : '';
                $ids = $this->ArticleDes->getIdByArticleId($insertId);
                $this->destorybyid('ArticleDes',$ids,2);
            }else{
                $insertId = $this->Article->allowField(true)->insertGetId($article);
            }
            if($insertId){
                $des = json_decode(input('post.des/a')[0],true);
                foreach ($des as $key=>$value) {
                    $article_des[$key]['article_id'] = $insertId;
                    $article_des[$key]['name'] = $value['name'];
                    $article_des[$key]['text'] = $value['text'];
                }
                $re = $this->ArticleDes->allowField(true)->saveAll($article_des);
                if($re){
                    $this->success('保存成功');
                }    
            }else{
                $this->error('保存失败');
            }       
        }
        $tags = $this->ArticleTags->getAllTagsByWhere("delete_time is null");
        $articletype = $this->ArticleType->getAllArticleTypeByWhere();
        $this->assign('articletype',$articletype);
        $this->assign('tags',$tags);
        if(!empty($id)){
            $where = "article_id={$id}";
            $content = $this->Article->getArticleByWhere($where);
            if(empty($content)){
                $this->redirect('/error');
            }
            if(strstr($content['tag_ids'],',')){
                $arr = explode(',',$content['tag_ids']);
                $content['tag_ids']=$arr;
                foreach ($tags as $key => $value) {
                   if(in_array($value['id'],$content['tag_ids'])){
                        $value['check']=1;
                   }else{
                        $value['check']=0;
                   }
                }
            }else{
                foreach ($tags as $key => $value) {
                   if($content['tag_ids']==$value['id']){
                        $value['check']=1;
                   }else{
                        $value['check']=0;
                   }
                }
            }
            $content['tag_ids'] = $tags;
            $content['des'] = $this->Article->getDes()->where("article_id",$id)->select();
            $this->assign('content',$content);
            return $this->fetch('edit');
        }
    	return $this->fetch();
    }
}