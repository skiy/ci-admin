<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   sidebar.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018-01-30
 */

?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="<?php echo site_url(); ?>" class="logo">
            <span class="logo-mini"><b>C</b>A</span>
            <span class="logo-lg"><b>CI</b>Admin</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="user user-menu">
                        <a href="javascript:void(0);">
                            <span class="hidden-xs">
                                <?php echo $_SESSION['ci_user']['name']; ?>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('user/logout'); ?>"><i class="fa fa-sign-out"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/static/images/avatar.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION['ci_user']['name']; ?></p>
                    <span></span>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">管理平台</li>
                <li class="treeview<?php if ($s1 == 'user') echo ' active'; ?>">
                    <a href="#">
                        <i class="fa fa-list"></i>
                        <span>用户管理</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li<?php if ($s1 == 'user' && in_array($s2, ['modify_pwd'])) echo ' class="active"'; ?>>
                            <a href="<?php echo site_url('user/modify_pwd');?>"><i class="fa fa-circle-o"></i>
                                修改密码</a></li>
                        <?php if ($_SESSION['ci_user']['level'] == 1) {?>
                            <li<?php if ($s1 == 'user' && in_array($s2, ['login_log'])) echo ' class="active"'; ?>>
                                <a href="<?php echo site_url('user/login_log');?>"><i class="fa fa-circle-o"></i>
                                    后台登录日志</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
