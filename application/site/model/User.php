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
        return $this->where("phone",$login_info['username'])->where("pwd",$login_info['password'])->find();
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
     * 得到用户头像
     * @param username
     */
    public function getAvatarByusername($username)
    {
        return $this->where("phone",$username)->value('avatar');
    }

    /**
     * 设置用户参数
     * @param id
     */
    public function UserSetUp($id){
        $SysSetupModel = model('site/SysSetup');
        $regions = array_column($SysSetupModel->getAllSetupRegion(), 'region');
        $UpdateData = [];
        $i = 0;
        foreach ($regions as $key => $value) {
            $SysSetupRe = $SysSetupModel->getAllSetupName(['region'=>$value]);
            $setname = $value.'setup';
            foreach ($SysSetupRe as $k => $v) {
                $UpdateData[$setname][$v['name']] = $v['value'];
            }
            if($UpdateData[$setname]){
                $re = $this->where("id",$id)->update(array($setname=>json_encode($UpdateData[$setname])));
                if($re){
                    $i++;
                }
            }
        }
        if($i==count($regions)){
            return json_encode($UpdateData['insetup']);
        }else{
            return false;
        }
    }
}
