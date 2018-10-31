<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:61:"/var/www/sea/application/sea/view/material_picture/index.html";i:1522386017;s:43:"/var/www/sea/application/sea/view/base.html";i:1522331186;s:50:"/var/www/sea/application/sea/view/page/header.html";i:1522331203;s:53:"/var/www/sea/application/sea/view/page/left_side.html";i:1522331203;s:54:"/var/www/sea/application/sea/view/page/right_side.html";i:1522331203;s:50:"/var/www/sea/application/sea/view/page/footer.html";i:1522331203;}*/ ?>
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
    <title>HaI management center</title>
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
<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="__STATIC__/css/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="__STATIC__/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">   
<link href="__STATIC__/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<style type="text/css">
    .shadow-demo{
        width: 168px;
        height: 168px;
    }
    .card .card-content .card-title {
        line-height: 24px; 
    }  
    .activator{
        width:273px;height:178px;overflow: hidden;
    }  
</style>


</head>

<body class="">

<!-- Start Page Loading -->

<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>

<!-- End Page Loading -->

<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- start Page main -->

    <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="cyan">
                <div class="nav-wrapper">
                    <h1 class="logo-wrapper"><a href="index.html" class="brand-logo darken-1"><img src="__STATIC__/images/materialize-logo.png" alt="materialize logo"></a> <span class="logo-text">Materialize</span></h1>
                    <ul class="right hide-on-med-and-down">
                        <li class="search-out">
                            <input type="text" class="search-out-text">
                        </li>
                        <li>    
                            <a href="javascript:void(0);" class="waves-effect waves-block waves-light show-search"><i class="mdi-action-search"></i></a>                              
                        </li>
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                        </li>
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light"><i class="mdi-social-notifications"></i></a>
                        </li>
                        <!-- Dropdown Trigger -->                        
                        <li><a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse"><i class="mdi-communication-chat"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>
    <!-- END HEADER -->
    <!-- //////////////////////////////////////////////////////////////////////////// -->  
    <!-- START MAIN -->
    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">

             <!-- START LEFT SIDEBAR NAV-->
<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="<?php echo \think\Session::get('user_info.avatar'); ?>" alt="" class="circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="#"><i class="mdi-action-face-unlock"></i> 资料</a>
                        </li>
                        <li><a href="#"><i class="mdi-action-settings"></i> 设置</a>
                        </li>
                        <li><a href="#"><i class="mdi-communication-live-help"></i> 帮助</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="mdi-action-lock-outline"></i> 锁</a>
                        </li>
                        <li><a href="/logout"><i class="mdi-hardware-keyboard-tab"></i> 退出</a>
                        </li>
                    </ul>
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo \think\Session::get('user_info.nick_name'); ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                    <p class="user-roal">管理员</p>
                </div>
            </div>
        </li>
        <li class="bold"><a href="/index" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> 我的主页</a>
        </li>
        <li class="bold"><a href="/email" class="waves-effect waves-cyan"><i class="mdi-communication-email"></i> 邮箱 <span class="new badge">4</span></a>
        </li>
        <li class="bold"><a href="app-calendar.html" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> 日程表</a>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-invert-colors"></i> CSS</a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="css-typography.html">Typography</a>
                            </li>                                        
                            <li><a href="css-icons.html">Icons</a>
                            </li>
                            <li><a href="css-shadow.html">Shadow</a>
                            </li>
                            <li><a href="css-media.html">Media</a>
                            </li>
                            <li><a href="css-sass.html">Sass</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-image-palette"></i> UI 元素</a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="ui-buttons.html">Buttons</a>
                            </li>
                            <li><a href="ui-badges.html">Badges</a>
                            </li>
                            <li><a href="ui-cards.html">Cards</a>
                            </li>
                            <li><a href="ui-collections.html">Collections</a>
                            </li>
                            <li><a href="ui-accordions.html">Accordian</a>
                            </li>                                        
                            <li><a href="ui-navbar.html">Navbar</a>
                            </li>
                            <li><a href="ui-pagination.html">Pagination</a>
                            </li>
                            <li><a href="ui-preloader.html">Preloader</a>
                            </li>
                            <li><a href="ui-modals.html">Modals</a>
                            </li>
                            <li><a href="ui-media.html">Media</a>
                            </li>
                            <li><a href="ui-toasts.html">Toasts</a>
                            </li>
                            <li><a href="ui-tooltip.html">Tooltip</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold"><a href="app-widget.html" class="waves-effect waves-cyan"><i class="mdi-device-now-widgets"></i> 小工具 <span class="new badge"></span></a>
                </li>
                <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i> 表</a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="table-basic.html">Basic Tables</a>
                            </li>
                            <li><a href="table-data.html">Data Tables</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-insert-comment"></i> 博客</a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/blog_article/index">文章管理</a>
                            </li>
                            <li>
                                <a href="/blog_tag/index">标签管理</a>
                            </li>    
                            <li>
                                <a href="/blog_category/index">分类管理</a>
                            </li>                       
                        </ul>
                    </div>
                </li>
                <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-action-perm-media"></i> 素材</a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/material_picture/index">图片</a>
                            </li>                    
                        </ul>
                    </div>
                </li>
                <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-social-pages"></i> 网页</a>
                    <div class="collapsible-body">
                        <ul>                                        
                            <li><a href="page-login.html">Login</a>
                            </li>
                            <li><a href="page-register.html">Register</a>
                            </li>
                            <li><a href="page-lock-screen.html">Lock Screen</a>
                            </li>
                            <li><a href="page-invoice.html">Invoice</a>
                            </li>
                            <li><a href="page-404.html">404</a>
                            </li>
                            <li><a href="page-500.html">500</a>
                            </li>
                            <li><a href="page-blank.html">Blank</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-chart"></i> 图表</a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="charts-chartjs.html">Chart JS</a>
                            </li>
                            <li><a href="charts-chartist.html">Chartist</a>
                            </li>
                            <li><a href="charts-morris.html">Morris Charts</a>
                            </li>
                            <li><a href="charts-xcharts.html">xCharts</a>
                            </li>
                            <li><a href="charts-flotcharts.html">Flot Charts</a>
                            </li>
                            <li><a href="charts-sparklines.html">Sparkline Charts</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="li-hover"><div class="divider"></div></li>
        <li class="li-hover"><p class="ultra-small margin more-text">更过</p></li>
        <li><a href="css-grid.html"><i class="mdi-image-grid-on"></i> 格</a>
        </li>
        <li><a href="css-color.html"><i class="mdi-editor-format-color-fill"></i> 颜色</a>
        </li>
        <li><a href="css-helpers.html"><i class="mdi-communication-live-help"></i> 助手</a>
        </li>
        <li><a href="changelogs.html"><i class="mdi-action-swap-vert-circle"></i> 更新日志</a>
        </li>                    
        <li class="li-hover"><div class="divider"></div></li>
        <li class="li-hover"><p class="ultra-small margin more-text">Daily Sales</p></li>
        <li class="li-hover">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="sample-chart-wrapper">                            
                        <div class="ct-chart ct-golden-section" id="ct2-chart"></div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only darken-2"><i class="mdi-navigation-menu" ></i></a>
</aside>
<!-- END LEFT SIDEBAR NAV-->
            <!-- //////////////////////////////////////////////////////////////////////////// -->
      <!-- START CONTENT -->
            <section id="content">
        
            <!--breadcrumbs start-->
            <div id="breadcrumbs-wrapper" class=" grey lighten-3">
              <div class="container">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <h5 class="breadcrumbs-title">图片管理</h5>
                    </div>
                </div>
              </div>
            </div>
            <!--breadcrumbs end-->
            

            <!--start container-->
            <div class="container">
              <p class="caption">
                <form id="postForm" action="http://192.168.1.194/uploadapi.php" method="post" enctype="multipart/form-data" class="col s12">
                  <div class="row">
                    <div class="file-field input-field col s10">
                      <input id="uploadfilename" class="file-path validate" placeholder="   上传一张图片" type="text" value=""/>
                      <div class="btn">
                        <span>选择图片</span>
                        <input name="file[]" type="file" multiple="multiple"/>
                      </div>
                    </div>
                    <div class="input-field col s2">                          
                      <button onclick="checkupload()" class="btn cyan waves-effect waves-light right" type="button">上传<i class="mdi-content-send right"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </p>
              <!--Card Reveal-->
              <div class="divider"></div>
              <div id="card-reveal" class="section">
                <div class="row">
                  <?php if(is_array($pictures) || $pictures instanceof \think\Collection): $i = 0; $__LIST__ = $pictures;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                  <div class="col s12 m8 l3">
                    <div class="card">
                      <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="<?php echo $v['path']; ?>" alt="<?php echo $v['title']; ?>">
                      </div>
                      <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4"><?php echo substr($v['title'],0,11); ?>
                          <i class="mdi-image-edit right"></i>
                        </span>
                        </p>
                      </div>
                      <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">  
                          <i class="mdi-navigation-close right"></i>
                        </span>
                        <p>
                          <form action="">
                            <div class="col s12 m8 l12">
                              <label>编辑图片名称</label>
                              <input type="text" id="title<?php echo $v['id']; ?>" name="title<?php echo $v['id']; ?>" value="<?php echo $v['title']; ?>">
                            </div>
                            <div class="col s12 m8 l12">
                                <label>移动分组</label>
                                <p>
                                  <input name="group_id<?php echo $v['id']; ?>" type="radio" id="group" value="0" <?php if($v['group_id']==0 || $v['group_id']==''): ?> checked <?php endif; ?> >
                                  <label for="group">未分组</label>
                                  <?php if(is_array($groups) || $groups instanceof \think\Collection): $k = 0; $__LIST__ = $groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                                  <input name="group_id<?php echo $v['id']; ?>" type="radio" id="group<?php echo $k; ?>" value="<?php echo $vo['id']; ?>" <?php if($v['group_id']==$k): ?> checked <?php endif; ?> >
                                  <label for="group<?php echo $k; ?>"><?php echo $vo['value']; ?></label>
                                  <?php endforeach; endif; else: echo "" ;endif; ?>
                                </p>
                            </div>
                          </form>
                        </p>
                        <i onclick="checksubmit(<?php echo $v['id']; ?>)" class="mdi-action-done right"></i>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
              </div>
            </div>
            <!--end container-->

          </section>
            <!-- END CONTENT -->
            <!-- //////////////////////////////////////////////////////////////////////////// -->
            <!-- START RIGHT SIDEBAR NAV-->
<aside id="right-sidebar-nav">
    <ul id="chat-out" class="side-nav rightside-navigation">
        <li class="li-hover">
        <a href="#" data-activates="chat-out" class="chat-close-collapse right"><i class="mdi-navigation-close"></i></a>
        <div id="right-search" class="row">
            <form class="col s12">
                <div class="input-field">
                    <i class="mdi-action-search prefix"></i>
                    <input id="icon_prefix" type="text" class="validate">
                    <label for="icon_prefix">Search</label>
                </div>
            </form>
        </div>
        </li>
        <li class="li-hover">
            <ul class="chat-collapsible" data-collapsible="expandable">
            <li>
                <div class="collapsible-header teal white-text active"><i class="mdi-social-whatshot"></i>Recent Activity</div>
                <div class="collapsible-body recent-activity">
                    <div class="recent-activity-list chat-out-list row">
                        <div class="col s3 recent-activity-list-icon"><i class="mdi-action-add-shopping-cart"></i>
                        </div>
                        <div class="col s9 recent-activity-list-text">
                            <a href="#">just now</a>
                            <p>Jim Doe Purchased new equipments for zonal office.</p>
                        </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row">
                        <div class="col s3 recent-activity-list-icon"><i class="mdi-device-airplanemode-on"></i>
                        </div>
                        <div class="col s9 recent-activity-list-text">
                            <a href="#">Yesterday</a>
                            <p>Your Next flight for USA will be on 15th August 2015.</p>
                        </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row">
                        <div class="col s3 recent-activity-list-icon"><i class="mdi-action-settings-voice"></i>
                        </div>
                        <div class="col s9 recent-activity-list-text">
                            <a href="#">5 Days Ago</a>
                            <p>Natalya Parker Send you a voice mail for next conference.</p>
                        </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row">
                        <div class="col s3 recent-activity-list-icon"><i class="mdi-action-store"></i>
                        </div>
                        <div class="col s9 recent-activity-list-text">
                            <a href="#">Last Week</a>
                            <p>Jessy Jay open a new store at S.G Road.</p>
                        </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row">
                        <div class="col s3 recent-activity-list-icon"><i class="mdi-action-settings-voice"></i>
                        </div>
                        <div class="col s9 recent-activity-list-text">
                            <a href="#">5 Days Ago</a>
                            <p>Natalya Parker Send you a voice mail for next conference.</p>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="collapsible-header light-blue white-text active"><i class="mdi-editor-attach-money"></i>Sales Repoart</div>
                <div class="collapsible-body sales-repoart">
                    <div class="sales-repoart-list  chat-out-list row">
                        <div class="col s8">Target Salse</div>
                        <div class="col s4"><span id="sales-line-1"></span>
                        </div>
                    </div>
                    <div class="sales-repoart-list chat-out-list row">
                        <div class="col s8">Payment Due</div>
                        <div class="col s4"><span id="sales-bar-1"></span>
                        </div>
                    </div>
                    <div class="sales-repoart-list chat-out-list row">
                        <div class="col s8">Total Delivery</div>
                        <div class="col s4"><span id="sales-line-2"></span>
                        </div>
                    </div>
                    <div class="sales-repoart-list chat-out-list row">
                        <div class="col s8">Total Progress</div>
                        <div class="col s4"><span id="sales-bar-2"></span>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="collapsible-header red white-text"><i class="mdi-action-stars"></i>Favorite Associates</div>
                <div class="collapsible-body favorite-associates">
                    <div class="favorite-associate-list chat-out-list row">
                        <div class="col s4"><img src="__STATIC__/images/default-avatar.png" alt="" class="circle responsive-img online-user valign profile-image">
                        </div>
                        <div class="col s8">
                            <p>Eileen Sideways</p>
                            <p class="place">Los Angeles, CA</p>
                        </div>
                    </div>
                    <div class="favorite-associate-list chat-out-list row">
                        <div class="col s4"><img src="__STATIC__/images/default-avatar.png" alt="" class="circle responsive-img online-user valign profile-image">
                        </div>
                        <div class="col s8">
                            <p>Zaham Sindil</p>
                            <p class="place">San Francisco, CA</p>
                        </div>
                    </div>
                    <div class="favorite-associate-list chat-out-list row">
                        <div class="col s4"><img src="__STATIC__/images/default-avatar.png" alt="" class="circle responsive-img offline-user valign profile-image">
                        </div>
                        <div class="col s8">
                            <p>Renov Leongal</p>
                            <p class="place">Cebu City, Philippines</p>
                        </div>
                    </div>
                    <div class="favorite-associate-list chat-out-list row">
                        <div class="col s4"><img src="__STATIC__/images/default-avatar.png" alt="" class="circle responsive-img online-user valign profile-image">
                        </div>
                        <div class="col s8">
                            <p>Weno Carasbong</p>
                            <p>Tokyo, Japan</p>
                        </div>
                    </div>
                    <div class="favorite-associate-list chat-out-list row">
                        <div class="col s4"><img src="__STATIC__/images/default-avatar.png" alt="" class="circle responsive-img offline-user valign profile-image">
                        </div>
                        <div class="col s8">
                            <p>Nusja Nawancali</p>
                            <p class="place">Bangkok, Thailand</p>
                        </div>
                    </div>
                </div>
            </li>
            </ul>
        </li>
    </ul>
</aside>
<!-- LEFT RIGHT SIDEBAR NAV-->
        </div>
        <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->
    <!-- //////////////////////////////////////////////////////////////////////////// -->
    <!-- START FOOTER -->
    <footer class="page-footer">
    <div class="footer-copyright">
    <div class="container">
        Copyright © 2015   All rights reserved.
        <span class="right"> Design and Developed by  </span>
    </div>
</div>
    </footer>
    <!-- END FOOTER --> 

<!-- End Page main -->

<!-- ================================================
Scripts
================================================ -->
<!-- jQuery Library -->
<script type="text/javascript" src="__STATIC__/js/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="__STATIC__/js/materialize2.js"></script> 
<!-- <script type="text/javascript" src="http://www.materialscss.com/public/js/materialize.min.js"></script> -->
<!--prism-->
<script type="text/javascript" src="__STATIC__/js/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="__STATIC__/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="__STATIC__/js/plugins.js"></script>
<script type="text/javascript">
  function checkupload(){  
      var formData = new FormData($( "#postForm" )[0]);
      var uploadfilename = document.getElementById('uploadfilename').value;
      if(uploadfilename){
        $.ajax({  
            url: '/material_picture/create' ,  
            type: 'POST',  
            data: formData,  
            async: false,  
            cache: false,  
            contentType: false,  
            processData: false,  
            success: function (data) {  
                if(data.ret==200){
                  Materialize.toast(data.msg,2000,'',function(){
                    history.go(0); 
                  })
                }else{
                  Materialize.toast(data.msg,2000,'',function(){
                    history.go(0); 
                  })
                }
            },   
        });  
      }else{
        Materialize.toast('请选择需要上传的图片',2000,'',function(){
            history.go(0); 
        })
      }
      
     
     // var formData = new FormData($( "#postForm" )[0]);
     // var uploadfilename = document.getElementById('uploadfilename').value;
     //  $.ajax({
     //     type: "POST",
     //     url: "/material_picture/create",
     //     data: {"title":uploadfilename},
     //     dataType: "json",
     //     success: function(data){
     //        if(data.ret==200){
     //          $.ajax({  
     //              url: 'http://192.168.1.194/uploadapi.php' ,  
     //              type: 'POST',  
     //              data: formData,  
     //              async: false,  
     //              cache: false,  
     //              contentType: false,  
     //              processData: false,  
     //              success: function (res) {  
     //              },   
     //          });
     //          // Materialize.toast(data.msg,2000,'',function(){
     //          //     history.go(0); 
     //          // })
     //        }else{
     //          // Materialize.toast(data.msg,2000,'',function(){
     //          //     history.go(0); 
     //          // })
     //        }
     //     }
     //  });  
        
  }
  function checksubmit(id){
      var title = $("#title"+id).val();
      var group_id = document.getElementsByName('group_id'+id);
      for (var i=0;i<group_id.length;i++){ //遍历Radio 
        if(group_id[i].checked){ 
        group_id=group_id[i].value; 
        } 
      } 
      if(title==""){
        Materialize.toast('图片名称不能为空', 1000);
        return false;
      }
      $.ajax({
         type: "POST",
         url: "/material_picture/edit",
         data: {"id":id,"title":title,"group_id":group_id},
         dataType: "json",
         success: function(data){
            if(data.ret==200){
              Materialize.toast(data.msg,2000,'',function(){
                  history.go(0); 
              })
            }
         }
      });       
  }
  var options = [
    {selector: '#staggered-test', offset: 50, callback: function(el) {
      Materialize.toast("This is our ScrollFire Demo!", 1500);
      $("#call-1").velocity({ backgroundColor: "#333", color: "#ef5350" }, {duration: 500});
    } },
    {selector: '#staggered-test', offset: 205, callback: function(el) {
      Materialize.toast("Please continue scrolling!", 1500);
      $("#call-2").velocity({ backgroundColor: "#333", color: "#ef5350" }, {duration: 500});
    } },
    {selector: '#staggered-test', offset: 500, callback: function(el) {
      Materialize.showStaggeredList($(el));
      $("#call-3").velocity({ backgroundColor: "#333", color: "#ef5350" }, {duration: 500});
    } },
    {selector: '#image-test', offset: 500, callback: function(el) {
      Materialize.fadeInImage($(el));
      $("#call-4").velocity({ backgroundColor: "#333", color: "#ef5350" }, {duration: 500});
    } }
  ];
  Materialize.scrollFire(options);
</script>

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
