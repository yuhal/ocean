<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 hsttp://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__'    => [
        'id'            => '\d+',
        'p'             => '\d+',
        'i'             => '\d+',
        'name'          => '\w+',
    ],
    /*********登录*********/
        //登录页面
        'login'          =>  'site/login/index', 
        //修改密码页面
        'savepasswordp'  =>  'site/login/savepasswordp', 
        //其他登录方式页面
        'oauthlogin'     =>  'site/login/oauthlogin',
        //QQ登录
        'qqlogin'        =>  'site/login/qqlogin',
        //QQ登录回调
        'connect'        =>  'site/login/qqcallback',
        //微博登录
        'signlogin'      =>  'site/login/signlogin',
        //微博登录回调
        'signconnect'    =>  'site/login/signcallback',
        //显示用户信息
        'showuserinfo/:username'  =>  ['site/login/showuserinfo',['method','post']],
        //帐号登录
        'dologin'        =>  ['site/login/login',['method','post']],
        //手机验证码页面
        'phonevcode'     =>  'site/login/phonevcode',
        //发送验证码
        'sf_vcode/:phone'=>  ['site/login/sf_vcode',['method','post']], 
        //保存密码
        'savepassword'   =>  ['site/login/savepassword',['method','post']], 
    /*********主页*********/
        //首页
        ''	             =>	 'site/index/index',
        'index'          =>  'site/index/index',
    /*********邮箱*********/
        //邮箱页面
        'email'          =>  'site/email/index',
    /*********博客*********/
        //文章列表页面
        'blog_article/index/[:p]'   => 'site/blog_article/index',
        //添加/修改文章页面
        'blog_article/create/[:id]' => 'site/blog_article/create',
        //标签列表页面
        'blog_tag/index'            => 'site/blog_tag/index',
        //添加/修改标签页面
        'blog_tag/create/[:id]'     => 'site/blog_tag/create',
        //分类列表页面
        'blog_category/index'           => 'site/blog_category/index',
        //添加/修改分类页面
        'blog_category/create/[:id]'    => 'site/blog_category/create',
    /*********sdk*********/
        //sdk页面
        'material_sdk/index/:id'        => 'site/material_sdk/index',
        //配置sdk
        'material_sdk/edit'             => 'site/material_sdk/edit',
    /*********素材*********/
        //图片页面
        'material_picture/index/[:p]'   => 'site/material_picture/index',
        //上传图片页面
        'material_picture/create'       => 'site/material_picture/create',
        //修改图片页面
        'material_picture/edit'         => 'site/material_picture/edit',
    /*********pub*********/
        //个人信息页面
        'userdata'       =>  'site/index/userdata',   
        //绑定信息页面
        'binddata'       =>  'site/index/binddata', 
        //更改密码页面
        'changepwd'       =>  'site/index/changepwd',  
        //设置页面
        'setup/:region'          =>  'site/index/setup',   
        //软删除,name,id
        'destory/:name/:id'         => ['site/base/destorybyid', ['method' => 'post']],
        //还原，id
        'restore/:name/:id'         => ['site/base/restorebyid', ['method' => 'post']],
        //副文本编辑器页面
        'editide/[:i]/[:data]' =>  'site/base/editide',            
        //登出页面
        'logout'         =>  'site/login/logout',        
        //空路由
        '__MISS__'       =>  'site/page/pageerror', 
        //二维码页面
        'qrcode'         =>  'site/qrc/view',   
        //error页面
        'error/[:msg]'   =>  'site/page/pageerror', 
];
