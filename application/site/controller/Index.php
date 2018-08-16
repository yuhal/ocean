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

    public function setup($region)
    {
        $region = trim($region);
        $setname = $region.'setup';
        $UserSetup = json_decode($this->UserInfo[$setname],true);
        $SysSetupRe = $this->SysSetup->getAllSetupName(['region'=>$region]);
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
                $setup = $this->UserInfo[$setname];    
            }else{
                $UpdateData = array();
                if(empty($UserSetup)){
                    $UserSetup = array();
                    foreach ($SysSetupRe as $key => $value) {
                        $UserSetup[$value['name']] = $value['value'];
                    }
                }   
                foreach ($UserSetup as $key => $value) {
                    $UpdateData[$key] = $value;
                    foreach ($setup as $k => $v) {
                        if($key==$k){
                            $UpdateData[$key] = $v;
                        }
                    }
                }     
                $UpdateData = json_encode($UpdateData);
            }
            $setname = $region.'setup';
            $re = $this->User->where('id',$this->UserInfo['id'])->update(array($setname=>$UpdateData));
            if($re || ($re===0))
            {
                //更改session信息
                session('user_info_'.$this->UserInfo['id'].'.'.$setname,$setup);
                $this->success('保存成功');    
            }else{
                $this->error('保存失败');
            }
        }
        if($SysSetupRe){
            $SysSetup = array();
            foreach ($SysSetupRe as $key => $value) {
                $SysSetup[$key] = $value;
                if($value['type']=='file'){
                    $SysSetup[$key]['size'] = getFileSize($value['value']);
                }
                if($UserSetup){
                    foreach ($UserSetup as $k => $v) {
                        if($value['name']==$k){
                            if($value['type']=='file'){
                                $SysSetup[$key]['size'] = getFileSize($v);
                            }
                            $SysSetup[$key]['value'] = $v;
                        }
                    }
                }
            }  
        }
        //判断是否是手机登录
        if(is_mobile_request())
        {
            $this->length = 12;
        }else{
            $this->length = 4;
        }
        $this->assign('length',$this->length); 
        $this->assign('action',$region);
    	$this->assign('SysSetup',$SysSetup);
    	return $this->fetch();
    }
}