<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:67:"F:\source\hotpaas\public/../application/admin\view\index\index.html";i:1500025700;s:69:"F:\source\hotpaas\public/../application/admin\view\layout\common.html";i:1500025700;s:69:"F:\source\hotpaas\public/../application/admin\view\layout\header.html";i:1500025700;s:70:"F:\source\hotpaas\public/../application/admin\view\layout\sidebar.html";i:1500025700;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>控制台</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/static/adminlte/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/plugins/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/static/adminlte/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/static/adminlte/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="/static/adminlte/css/master.css">
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

    <!-- Logo -->
    <a href="" class="logo">
        <span class="logo-mini"><b>H</b></span>
        <span class="logo-lg"><b>Hot</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">有 x 条留言</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">查看所有</a></li>
                    </ul>
                </li>
                <!-- /.messages-menu -->

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">有 x 条通知</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">查看所有</a></li>
                    </ul>
                </li>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="<?php echo $admin['avatar']; ?>" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo $admin['username']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="<?php echo $admin['avatar']; ?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $admin['username']; ?>
                                <small><?php echo date('Y-m-d H:i:s', $admin['lastlogin_at']); ?></small>
                            </p>
                        </li>
                        <!-- Menu Body
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">个人资料</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo url('login/logout'); ?>" class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $admin['avatar']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $admin['username']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo url('system/index'); ?>">
                    <i class="fa fa-cog"></i> <span>系统设置</span>
                </a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
</aside>

    <div class="content-wrapper">
        <section class="content-header">
            <a href="<?php echo url('Index/index'); ?>" class="dashboard"><i class="fa fa-dashboard"></i>控制台</a>

            <ol class="breadcrumb">
                <?php if(isset($breadcrumb['ptitle'])): ?><li><a href="#">$breadcrumb['ptitle']</a></li><?php endif; ?>
                <li class="active"><?php echo $breadcrumb['title']; ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            
<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <div class="panel-lead">
            <em>控制台</em>
        </div>
        <ul class="nav nav-tabs">
            <li class="active"><a href="" data-toggle="tab">控制台</a></li>
            <li><a href="" data-toggle="tab">微信统计</a></li>
        </ul>
    </div>
    <div class="panel-body">
        Panel content
    </div>
</div>



        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    

</div>
<!-- ./wrapper -->


<script src="/static/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/static/adminlte/js/bootstrap.min.js"></script>
<script src="/static/adminlte/js/app.min.js"></script>
<script src="/static/adminlte/js/master.js"></script>

</body>
</html>
