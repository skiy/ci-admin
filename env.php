<?php

/**
 * 环境变量
 * File:   env.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2017-12-13
 */

switch($_SERVER["SERVER_ADDR"]) {
    //测试网
    case "127.0.0.1":
        $environment = 'development';
        break;

    default:
        $environment = ($_SERVER['SERVER_PORT'] == 31002) ? 'development' : 'production';
}

define('ENVIRONMENT', $environment);
