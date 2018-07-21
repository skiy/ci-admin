<?php
/**
 * 返回码
 * return_code.php
 * @author  : Skiychan <dev@skiy.net>
 * @link    : https://www.zzzzy.com
 * @created : 5/21/16
 * @modified:
 * @version : 0.0.1
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/* 服务器挂了,别问为什么,挂了就是挂了 */
$lang['error_-1']   = '服务器负载过高,请稍后重试。';

/*  0 ~ 100 请求相关 */
$lang['error_0']    = '操作成功';
$lang['error_1']    = '操作失败';

/** 20000 ~ 20999 错误相关 **/
$lang['error_20000']    = '不合法的参数';
$lang['error_20001']    = '数据获取失败';
$lang['error_20002']    = '缺少参数';

/** 28000 ~ 28999 第三方插件错误相关 */
$lang['error_28000']    = 'Redis 连接失败';

/* 50001 ~ 50100 权限相关 */
$lang['error_50001']    = '缺少 apikey 参数';
$lang['error_50002']    = 'apikey 无效';
$lang['error_50003']    = '签名无效';