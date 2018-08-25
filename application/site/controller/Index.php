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
        $contact = json_decode($this->UserInfo['contact'],true);
        if(request()->isAjax())
        {
            $updateData = input('post.');
            if(@$_FILES['avatar']['name']){
                $updateData['avatar'] = qiniu_upload($_FILES['avatar']);    
            }
            if(@$_FILES['wxqrcode']['name']){
                $updateData['wxqrcode'] = qiniu_upload($_FILES['wxqrcode']);    
            }

            $re = $this->User->where('id',$this->UserInfo['id'])->update($updateData);
            if($re || ($re===0))
            {
                //更改session信息
                foreach ($updateData as $key => $value) {
                    if($key=='contact'){
                        session('user_info_'.$this->UserInfo['id'].'.'.$key,json_encode($value));    
                    }else{
                        session('user_info_'.$this->UserInfo['id'].'.'.$key,$value);
                    }
                }
                $this->success('保存成功');    
            }else{
                $this->error('保存失败');
            }  
        }
        $avatar = myGetImageSize($this->UserInfo['avatar']);
        //var_dump('<pre>',$this->UserInfo);exit;
        $wxqrcode = myGetImageSize($this->UserInfo['wxqrcode']);

        $this->assign('avatar',$avatar);
        $this->assign('wxqrcode',$wxqrcode);
        $this->assign('contact',$contact);
    	return $this->fetch();
    }

    public function binddata()
    {
        if(request()->isAjax())
        {
            $updateData = input('post.');
            if($updateData['phone'] && !preg_match("/^1[34578]\d{9}$/", $updateData['phone'])){
                $this->error('手机格式错误');
            }
            if ($updateData['email'] && !filter_var($updateData['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error('邮箱格式错误');  
            }
            $unique = $this->User->checkUnique($updateData,$this->UserInfo['id']);
            if($unique){
                switch ($unique) {
                    case 'phone':
                        $this->error('该手机已被其他用户绑定');
                        break;
                    case 'email':
                        $this->error('该邮箱已被其他用户绑定');
                        break;
                }
            }
            $re = $this->User->where('id',$this->UserInfo['id'])->update($updateData);
            if($re || ($re===0))
            {
                //更改session信息
                foreach ($updateData as $key => $value) {
                    session('user_info_'.$this->UserInfo['id'].'.'.$key,$value);
                }
                $this->success('保存成功');    
            }else{
                $this->error('保存失败');
            }  
        }
        return $this->fetch();
    }

    public function changepwd(){
        if(request()->isAjax())
        {
            $updateData = input('post.');
            $setPwdData['id'] = $this->UserInfo['id'];
            $setPwdData['phone'] = $this->UserInfo['phone'];
            $setPwdData['pwd'] = $updateData['oldpwd'];
            $updateData['oldpwd'] = $this->User->setPwd($setPwdData);
            if(!$this->User->checkPwd($updateData['oldpwd'],$this->UserInfo['id'])){
                $this->error('旧密码输入有误');    
            }
            if(!$updateData['newpwd']){
                $this->error('请设置新密码');
            }
            if($updateData['newpwd'] && !preg_match("/^[._a-zA-Z0-9]{6,12}$/",$updateData['newpwd'])){
                $this->error('密码需要6位以上的数字和字母组合');
            }
            if(!$updateData['checkpwd']){
                $this->error('请再次确认新密码');
            }
            if($updateData['newpwd'] != $updateData['checkpwd']){
                $this->error('两次输入密码不一致');
            }
            $setPwdData['pwd'] = $updateData['newpwd'];
            $updateData['newpwd'] = $this->User->setPwd($setPwdData);
            $re = $this->User->where('id',$this->UserInfo['id'])->update(array('pwd'=>$updateData['newpwd']));
            if($re || ($re===0))
            {
                //更改session信息
                session('user_info_'.$this->UserInfo['id'].'.pwd',$updateData['newpwd']);
                $this->success('修改成功');    
            }else{
                $this->error('修改失败');
            }  
        }
        return $this->fetch();
    }

    public function setup($region)
    {
        $region = trim($region);
        $setname = $region.'setup';
        $UserSetup = json_decode($this->UserInfo[$setname],true);
        $SysSetupRe = $this->SysSetup->getAllSetupName(['region'=>$region]);
        if(request()->isAjax())
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
                session('user_info_'.$this->UserInfo['id'].'.'.$setname,$UpdateData);
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
                    $imageSize = myGetImageSize($value['value']);
                    $SysSetup[$key]['size'] = $imageSize['size'];
                    $SysSetup[$key]['width'] = $imageSize['width'];
                    $SysSetup[$key]['height'] = $imageSize['height'];
                }
                if($UserSetup){
                    foreach ($UserSetup as $k => $v) {
                        if($value['name']==$k){
                            if($value['type']=='file'){
                                $imageSize = myGetImageSize($value['value']);
                                $SysSetup[$key]['size'] = $imageSize['size'];
                                $SysSetup[$key]['width'] = $imageSize['width'];
                                $SysSetup[$key]['height'] = $imageSize['height'];
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