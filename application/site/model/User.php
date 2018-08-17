<?php
namespace app\site\model;
use think\Model;

class User extends Model{

    //创建时间开启状态
    protected $createTime = false;

    /**
     * 开启自动写入字段
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 数据类型转换
     */
    protected $type = [
        'update_time'  =>  'datetime:Y/m/d',
    ];

    /**
     * 保存用户信息
     * @param userInfo
     */
    public function saveUserInfo($userInfo)
    {
        $id = $this->where("nick_name",$userInfo['nick_name'])->value('id');
        if($id){    
            $this->where('id', $id)->update($userInfo);
            return $id;
        }    
    }

    /**
     * 检测登录状态
     * @param login_info
     */
    public function checkLogin($login_info)
    {
        $setPwdData['id'] = $login_info['id'];
        $setPwdData['phone'] = $login_info['username'];
        $setPwdData['pwd'] = $login_info['password'];
        $pwd = $this->setPwd($setPwdData);
        if($pwd){
            return $this->where("id",$login_info['id'])->where("pwd",$pwd)->find();    
        }else{
            return false;
        }
    }

    /**
     * 加密密码
     * @param login_info
     */
    public function setPwd($userInfo)
    {
        if(array_key_exists('id', $userInfo) && array_key_exists('phone', $userInfo) && array_key_exists('pwd', $userInfo)){
            return md5(md5(json_encode($userInfo)));    
        }
        return false;
    }

    /**
     * 检测密码是否正确
     * @param login_info
     */
    public function checkPwd($pwd,$id)
    {
        return $this->where("id",$id)->where("pwd",$pwd)->find();
    }

    /**
     * 检测用户信息不重复
     * @param login_info
     */
    public function checkUnique($userInfo,$id)
    {
        foreach ($userInfo as $key => $value) {
            if($this->where($key,$value)->where('id','<>',$id)->find()){
                return $key;
            }
        }
        return false;
    }

    /**
     * 保存密码
     * @param userInfo
     */
    public function savepassword($userInfo)
    {
        return $this->where("phone",$userInfo['phone'])->update(array('pwd'=>$userInfo['password']));
    }

    /**
     * 设置用户参数
     * @param id
     */
    public function UserSetUp($id,$region){
        $SysSetupModel = model('site/SysSetup');
        $SysSetupRe = $SysSetupModel->getAllSetupName(['region'=>$region]);
        foreach ($SysSetupRe as $k => $v) {
            $UpdateData[$v['name']] = $v['value'];
        }
        if($UpdateData){
            $setname = $region.'setup';
            $re = $this->where("id",$id)->update(array($setname=>json_encode($UpdateData)));
        }
        if($re){
            return json_encode($UpdateData);
        }else{
            return false;
        }
    }
}
