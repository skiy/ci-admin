<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * File:   modify_pwd.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018/07/13
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h4>修改密码</h4>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> 用户管理</a></li>
            <li class="active">修改密码</li>
        </ol>
    </section>
    <section id="account-modify-pwd" class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <form class="form-horizontal" onsubmit="return false;">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="password" class="col-sm-2">新密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" placeholder="请输入新密码" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password2" class="col-sm-2">确认新密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password2" placeholder="请再次输入新密码" >
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="account-modify-pwd-cli">提交</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
