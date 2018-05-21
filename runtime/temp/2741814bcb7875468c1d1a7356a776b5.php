<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"/var/www/sea/application/sea/view/page/phonevcode.html";i:1523613731;s:43:"/var/www/sea/application/sea/view/base.html";i:1522331186;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<!--================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 1.0
	Author: GeeksLabs

================================================================================ -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>发送验证码 | HaI management center</title>
    <!-- Favicons-->
    <link rel="icon" href="__STATIC__/images/favicon/delicious_32px_581501_easyicon.net.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="__STATIC__/images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="__STATIC__/images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
       
    <link href="__STATIC__/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="__STATIC__/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="__STATIC__/css/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="__STATIC__/css/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="__STATIC__/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    

</head>

<body class="cyan">

<!-- Start Page Loading -->

<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>

<!-- End Page Loading -->

<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- start Page main -->

<div id="login-page" class="row">
  <div class="col s12 z-depth-4 card-panel">
    <form class="login-form" action="/savepassword" method="post" onsubmit="verify()">
      <div class="row">
        <div class="input-field col s12 center">
          <p class="center login-form-text">发送验证码</p>
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
          <i class="mdi-social-person-outline prefix"></i>
          <input name="username" maxlength="11" type="text" required/>
          <label for="username" class="center-align">输入手机号</label>
        </div>
        <div class="input-field col s6">
          <i class="mdi-communication-message prefix"></i>
          <input name="vcode" maxlength="4" type="text" required/>
          <label for="vcode" class="center-align">输入验证码</label>
        </div>
        <div class="input-field col s6">
          <button class="btn col s12" type="submit">获取验证码</button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <a href="savepasswordp" class="btn waves-effect waves-light col s12">下一步</a>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 m6 l6">
          <p class="margin medium-small"><a href="oauthlogin">其他账号登录</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
          <p class="margin right-align medium-small"><a href="javascript:void(0)">获取不到验证码?</a></p>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- End Page main -->

<!-- ================================================
Scripts
================================================ -->
<!-- jQuery Library -->
<script type="text/javascript" src="__STATIC__/js/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="__STATIC__/js/materialize.js"></script> 
<!-- <script type="text/javascript" src="http://www.materialscss.com/public/js/materialize.min.js"></script> -->
<!--prism-->
<script type="text/javascript" src="__STATIC__/js/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="__STATIC__/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="__STATIC__/js/plugins.js"></script>

<script type="text/javascript">
    function dispatchById(name,method,id){
            $.ajax({
                 type: "POST",
                 url: '../'+method+'/'+name+'/'+id,
                 dataType: "json",
                 success: function(data){
                    if(data.ret==200){
                        Materialize.toast(data.msg,1000,'',function(){
                            history.go(0); 
                        })
                    }
                 }
            });
    }
    function htmlencode(s){  
        var div = document.createElement('div');  
        div.appendChild(document.createTextNode(s));  
        return div.innerHTML;  
    }  
    function htmldecode(s){  
        var div = document.createElement('div');  
        div.innerHTML = s;  
        return div.innerText || div.textContent;  
    } 
    function checks(t){
       szMsg="[#_%&'/\",;:=!^]";
       alertStr="";
       for(i=1;i<szMsg.length+1;i++){
            if(t.indexOf(szMsg.substring(i-1,i))>-1){
             alertStr="请勿包含非法字符如[#_%&'/\",;:=!^]";
             break;
            }
       }
       if(alertStr != ""){
            return true;
       }
       return false;
    }
</script>
</body>

</html>
