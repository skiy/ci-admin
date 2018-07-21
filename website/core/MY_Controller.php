<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   MY_Controller.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2016/9/12
 */

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @param int $code   错误码
     * @param string $msg 信息内容
     * @param null $data 数据补充
     * @param int $level  数据补充是否和错误码平级 默认1同级
     */
    public function show_response($code = 0, $data = NULL, $level = 1, $msg = '', $format='json') {
        Collective::response($code, $data, $level, $msg, $format);
    }
}