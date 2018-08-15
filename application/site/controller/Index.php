<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;


class Index extends Base
{
    public function index()
    {
    	return $this->fetch();
    }

    public function userdata()
    {
    	return $this->fetch();
    }

    public function setup()
    {
        $user_setup = json_decode($this->UserInfo['setup'],true);
        if(request()->isAjax() && $this->UserInfo['id'])
        {
            $setup = input('post.');
            $files = array_keys($_FILES);
            if($files){
                foreach ($files as $key => $value) {
                    if($_FILES[$value]['name']){
                        $title = qiniu_upload($_FILES[$value]);
                        if($title){
                            $setup[$value] = $title;    
                        }
                    }
                }    
            }
            if(empty($setup)){
                $setup = $this->UserInfo['setup'];    
            }else{
                $setup = json_encode($setup);
            }
            $re = $this->User->where('id',$this->UserInfo['id'])->update(array('setup'=>$setup));
            if($re || ($re===0))
            {
                //更改session信息
                $session_data['setup'] = $setup;
                session('user_info_'.$this->UserInfo['id'].'.setup',$session_data['setup']);
                $this->success('保存成功');    
            }else{
                $this->error('保存失败');
            }
        }
    	$setup_list = $this->SysSetup->getAllSetupName();
        foreach ($setup_list as $key => $value) {
            if($user_setup){
                foreach ($user_setup as $k => $v) {
                    if($value['type']=='file'){
                        $setup_list[$key]['size'] = getFileSize($v);
                    }
                    if($value['name']==$k){
                        $setup_list[$key]['value'] = $v;
                    }
                }
            }
        }
    	$this->assign('setup_list',$setup_list);
    	return $this->fetch();
    }
}