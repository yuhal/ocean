<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;

class BlogAdvert extends Base
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 广告位设置
     * @param p
     * @param title
     */
	public function index()
    {
        $advert = json_decode($this->UserInfo['advert'],true);
        $userAdvert = $advert;
        if(isset($advert['imageurl']) && $advert['imageurl']){
           $advert['image'] = myGetImageSize($advert['imageurl']);
        }
        if(request()->isAjax())
        {
            $advert = input('post.');
            if(@$_FILES['file']['name']){
                $advert['imageurl'] = qiniu_upload($_FILES['file']);    
            }
            foreach ($userAdvert as $k => $v) {
                foreach ($advert as $key => $value) {
                    if($k!=$key){
                        $advert[$k] = $v;
                    }
                }
            }
            $updateData['advert'] = json_encode($advert);
            $re = $this->User->where('id',$this->UserInfo['id'])->update($updateData);
            if($re || ($re===0))
            {
                //更改session信息
                session('user_info_'.$this->UserInfo['id'].'.advert',json_encode($advert));
                $this->success('保存成功');    
            }else{
                $this->error('保存失败');
            }
        }
        $this->assign('advert',$advert); 
	    return $this->fetch();
	}
}