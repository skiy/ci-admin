<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * hooks 白名单
 * File:   hooks_white_list.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018/07/21
 */

//白名单实例
$config['hooks_white_class'] = [
];

//白名单实例方法
$config['hooks_white_method'] = [
    'user' => [
         'login'
    ]
];