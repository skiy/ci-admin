<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * File:   login_log.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018/07/14
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h4>后台登录日志</h4>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> 用户管理</a></li>
            <li class="active">后台登录日志</li>
        </ol>
    </section>
    <section id="agent-list" class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>UID</th>
                                <th>用户名</th>
                                <?php ?>
                                <th>IP</th>
                                <th>地址</th>
                                <th>登录时间</th>
                            </tr>
                            <?php foreach ($data as $agent) {?>
                            <tr>
                                <td><?php echo $agent['uid']; ?></td>
                                <td><?php echo $agent['name']; ?></td>
                                <?php ?>
                                <td><?php echo $agent['ip']; ?></td>
                                <td><?php echo $agent['address']; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $agent['created_at']); ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-left">
                           <?php echo $pagination; ?>
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>