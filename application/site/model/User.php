<?php
namespace app\site\model;
use think\Model;

class User extends Model{

    protected $createTime = false;

    protected $autoWriteTimestamp = 'datetime';

    protected $type = [
        'update_time'  =>  'datetime:Y/m/d',
    ];

    /**
     * 保存用户信息
     * @param $userInfo
     */
    public function saveUserInfo($userInfo){
        $id = $this->where("nick_name",$userInfo['nick_name'])->value('id');
        if($id){    
            $this->where('id', $id)->update($userInfo);
            return $id;
        }    
    }

    /**
     * 检测登录状态
     * @param $login_info
     */
    public function checkLogin($login_info){
        return $this->where("phone",$login_info['username'])->where("pwd",$login_info['password'])->find();
    }

    /**
     * 保存密码
     * @param $userInfo
     */
    public function savepassword($userInfo){
        return $this->where("phone",$userInfo['phone'])->update(array('pwd'=>$userInfo['password']));
    }

    /**
     * 得到用户头像
     * @param $username
     */
    public function getAvatarByusername($username){
        return $this->where("phone",$username)->value('avatar');
    }
}
