<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-19
 * Time: 11:35
 */

namespace app\site\controller;
use think\Request;
use think\Controller;
use think\Session;
use think\Db;
use traits\controller\Middle;

header('content-type:text/html; charset=utf-8');

class Base extends Controller
{
    /**
     * 使用中间件
     */
    use Middle;

    /**
     * 初始化操作
     */
    public function __construct()
    {   	
    	parent::__construct();

        //验证登录
        $user_id = session('user_id');
        $this->UserInfo = $this->isLogin($user_id);
    //var_dump('<pre>',$this->UserInfo);exit;
        if(!$this->UserInfo){
            $this->redirect(url('/login'));
        }
        $this->assign('user_info',$this->UserInfo); 

        //初始化model
        $this->User = model('site/User'); 
        $this->Article = model('site/Article');     
        $this->ArticleType = model('site/ArticleType'); 
        $this->ArticleDes = model('site/ArticleDes');     
        $this->ArticleTags = model('site/ArticleTags');    
        $this->SysColor = model('site/SysColor');     
        $this->Picture = model('site/Picture');    
        $this->PictureGroup = model('site/PictureGroup'); 
        $this->Sdk = model('site/Sdk');
        $this->SysSetup = model('site/SysSetup');
        $this->Information = model('site/Information');

        //判断是否是手机登录
        if(is_mobile_request())
        {
            $this->length = 12;
        }else{
            $this->length = 6;
        }
        $this->assign('length',$this->length); 

        //设置config
        $data = $this->Sdk->getSdkByWhere(array('sdk_name'=>'qiniu_sdk'));
        config('sdk.qiniu_sdk',$data['sdk_info']);

        //加载左边栏
        $left_side['sdk'] = $this->Sdk->getsdk();
        $left_side['setup'] = $this->SysSetup->getAllSetupRegion();
        $this->assign('left_side',$left_side); 
        $this->assign('uniqid',uniqid()); 
        $this->assign('action',Request::instance()->action());

    }

    /**
     * 全局删除
     * @param name
     * @param id
     * @param force
     */
    public function destorybyid($name,$id,$force=false)
    {
        if(strstr($name,'_')){
            $name = model_exchange($name);
        }
        $objName = ucfirst($name);
        $obj = $this->$objName;
        $re = $obj::destroy($id,$force);
        if($re){
            //软删除文章分类后，同时软删除该分类下的文章
            if($objName=='ArticleType')
            {
                $where = "type_id={$id}";
                $Article = $this->Article;
                $arr = $this->Article->getArticleIdsByWhere($where);
                foreach ($arr as $k=>$v) {
                    $Article::destroy($v,$force);
                }
            }
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    /**
     * 全局还原
     * @param name
     * @param id
     */
    public function restorebyid($name,$id)
    {
        $table = $name;
        if(strstr($name,'_'))
        {
            $name = model_exchange($name);
        }
        $objName = ucfirst($name);
        $pk = $this->$objName->getPk();
        $sql = "update yh_{$table} set delete_time = NULL where {$pk}={$id}";
        $re = Db::execute($sql);       
        if($re){
            //文章分类还原后，同时还原该分类下的文章
            if($objName=='ArticleType')
            {
                $where = "type_id={$id}";
                $Article = $this->Article;
                $arr = $this->Article->getSortDelArticleIdsByWhere($where);
                foreach ($arr as $k=>$v) {
                    $sql = "update yh_article set delete_time = NULL where article_id={$v}";
                    Db::execute($sql);
                }
            }   
            $this->success('还原成功');
        }else{
            $this->error('还原失败');
        }
    }

    /**
     * 富文本编辑器调用
     * @param i
     * @param data
     */
    public function editide($i="",$data="&nbsp;")
    {
        return view('page/editide',['i'=>$i,'data'=>$data]);
    }
}

