<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * File:   login.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018/07/21
 */
?>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0);"><b>CI</b>Admin</a>
    </div>
    <div class="login-box-body">
        <h3 class="text-center">登录帐号</h3>
        <form class="login-form" onsubmit="return false;">
            <div class="form-group has-feedback">
                <input type="text" name="account" id="account" class="form-control" placeholder="帐号" value="<?php echo $username; ?>"/>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" id="password" class="form-control" placeholder="密码" />
            </div>
            <div class="row">
                <div class="col-xs-8"></div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" id="login-form-cli">登录</button>
                </div>
            </div>
        </form>
    </div>
</div>