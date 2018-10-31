<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-27
 * Time: 17:05
 */
namespace app\site\controller;
use think\Controller;
use think\Session;
use oauth\qq\init\QC;
use oauth\sign\init\SaeTOAuthV2;
use oauth\sign\init\SaeTClientV2;
use Endroid\QrCode\QrCode;
header("Content-type:text/html;charset=utf-8");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods:GET,POST");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//主要为跨域CORS配置的两大基本信息,Origin和headers
ini_set('allow_url_include', 'On');
ini_set('allow_url_fopen', 'On');
class Login extends Controller
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();  
        $this->User = model('site/User');
        $this->Sdk = model('site/Sdk');
        // $this->Qauth_Qc = new Qc();
        // $this->Sign = new SaeTOAuthV2(config('sign.appkey'),config('sign.appsecret'));
    }

    public function uptoken(){
        $data = json_decode($this->Sdk->where(array('sdk_name'=>'qiniu_sdk'))->value('sdk_info'),true);
        $Qiniu = new \qiniu\QiniuSdk($data);
        return $Qiniu->uptoken();
    }

    /**
     * 登录页面
     */
    public function index()
    {
        return view('page/login');
    }

    /**
     * 其他方式登录页面
     */
    public function oauthlogin()
    {
        $redirect_url['qq'] = $this->Qauth_Qc->qq_login();
        $redirect_url['sign'] = $this->Sign->getAuthorizeURL(config('sign.callback'));
        $this->assign('redirect_url',$redirect_url);
        return $this->fetch('page/oauthlogin');
    }

    /**
     * 忘记密码页面
     */
    public function phonevcode()
    {
        return view('page/phonevcode');
    }

    /**
     * 账号登录
     */
    public function login()
    {
        $data_p = input('post.');
        $data_p['id'] = $this->User->where("phone",$data_p['username'])->value('id');
        if(!$data_p['id']){
            $this->error('不存在该账号');
        }
        $re = $this->User->checkLogin($data_p);
        if(!empty($re))
        {
            $userConfig = config('user');
            if(empty($re['avatar'])){
                //设置用户头像
                $avatar = $userConfig['avatar'];
                $re['avatar'] = current($this->User->UserSetUp($re['id'],'avatar',$avatar,false,false));
                if(!$re['avatar']){
                    $this->error('系统异常');        
                }   
            }
            if(empty($re['wxqrcode'])){
                //设置微信二维码
                $wxqrcode = $userConfig['wxqrcode'];
                $re['wxqrcode'] = current($this->User->UserSetUp($re['id'],'wxqrcode',$wxqrcode,false,false));
                if(!$re['wxqrcode']){
                    $this->error('系统异常');        
                }   
            }
            if(empty($re['insetup'])){
                //设置后台参数
                $re['insetup'] = $this->User->UserSetUp($re['id'],'insetup',1);
                if(!$re['insetup']){
                    $this->error('系统异常');        
                }
            }
            if(empty($re['advert'])){
                //设置广告位
                $advert = json_encode($userConfig['advert'],true);
                $re['advert'] = current($this->User->UserSetUp($re['id'],'advert',$advert,false,false));
                if(!$re['advert']){
                    $this->error('系统异常');        
                }
            }
            if(!empty($re['insetup'])){
                //后台参数
                foreach (json_decode($re['insetup'],true) as $key => $value) {
                    $re[$key] = $value;
                }
            }
            if(!empty($re['introduce'])){
                //个人介绍
                $re['introduce'] = json_decode($re['introduce'],true);
            }
            $session_data = $re;
            session('user_info_'.$session_data['id'],$session_data);
            session('user_id',$session_data['id']);
            $this->success('登录成功','');
        }else{
            $this->error('手机号或密码错误');
        }
    }    

    /**
     * QQ登录
     */
    public function qqcallback()
    {       
        $acs =  $this->Qauth_Qc->qq_callback();
        $oid =  $this->Qauth_Qc->get_openid();
        $qc = new QC($acs,$oid);
        $arr = $qc->get_user_info();
        $session_data['avatar'] = $arr['figureurl_2'];
        $session_data['nick_name'] = $arr['nickname'];
        $session_data['id'] = $this->User->saveUserInfo($session_data); 
        if($session_data['id']){
            session('user_info_'.$session_data['id'],$session_data);
            session('user_id',$session_data['id']);
            $this->redirect('/index');    
        }else{
            $this->redirect('/');
        }
          
    }

    /**
     * sign登录
     */
    public function signcallback()
    { 
        $data['code'] = input('get.code');
        $data['redirect_uri'] = config('sign.callback');
        $token = $this->Sign->getAccessToken('code',$data); 
        if(!empty($token['error']))
        {
            return $this->fetch('page/error',['code'=>$token['error_code'],'msg'=>$token['error_description']]);
        }     
        $client = new SaeTClientV2(config('sign.appkey'),config('sign.appsecret'),$token['access_token']);   
        $user_message = $client->show_user_by_id($token['uid']);//根据ID获取用户等基本信息 
        $session_data['avatar'] = $user_message['profile_image_url'];
        $session_data['nick_name'] = $user_message['screen_name'];
        $session_data['id'] = $this->User->saveUserInfo($session_data); 
        if($session_data['id'])
        {
            session('user_info_'.$session_data['id'],$session_data);
            session('user_id',$session_data['id']);
            $this->redirect('/index');    
        }else{
            $this->redirect('/');
        }  
    }

    /**
     * 忘记密码发送验证码
     * @param $phone
     */
    public function sf_vcode($phone)
    {
        if(cache('code_'.$phone,'0507',60)){
            $this->success('发送成功');
        }else{
            $this->error('发送失败');
        }    
    }

    /**
     * 显示登录用户信息
     * @param $username
     */
    public function showuserinfo($username)
    {
        $re = $this->User->where("phone",$username)->field('avatar,nick_name')->find();
        if($re)
        {
            $this->success(['avatar'=>$re['avatar'],'nick_name'=>$re['nick_name']]);
        }else{
            $this->error(10040);
        }
    }

    /**
     * 修改密码
     */
    public function savepassword()
    {
        $data_p = input('post.');
        $true_code = cache('code_'.$data_p['phone']);
        if($data_p['vcode']==$true_code){
            $this->User->savepassword($data_p);
            $this->success('保存成功');
        }
        $this->error('验证码错误或者已过期');
    }

    /**
     * 退出
     */
    public function logout()
    {
        session(null);
        $this->redirect(url('/login'));
    }



}