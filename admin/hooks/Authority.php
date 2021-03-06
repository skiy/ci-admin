<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 权限检查
 * File:   Authority.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2017-12-13
 */

class Authority {
    private $_ci;

    public function __construct() {
        $this->_ci = & get_instance();
    }

    /**
     * 登录检测
     * @return bool|void
     */
    public function check_authority() {
        $class = $this->_ci->router->class;
        $method = $this->_ci->router->method;

        $this->_ci->load->config('hooks_white_list');
        $white_class = $this->_ci->config->item('hooks_white_class');
        $white_method = $this->_ci->config->item('hooks_white_method');

        //白名单实例
        if (in_array($class, $white_class)) {
            return TRUE;
        }

        //白名单方法
        if (array_key_exists($class, $white_method)) {
            $my_methods = $white_method[$class];
            is_string($my_methods) && $my_methods = explode(',', $my_methods);

            if (in_array($method, $my_methods)) {
                return TRUE;
            }
        }

        return $this->_verify();
    }

    /**
     * 检测不通过时，验证登录
     */
    private function _verify() {
        $this->_ci->load->logic('user_logic');
        $is_login = $this->_ci->user_logic->is_login();

        //验证登录通过
        if ($is_login) {
            return TRUE;
        }

        $_is_ajax = $this->_ci->input->is_ajax_request();
        $_is_axios = ($this->_ci->input->method() == 'post') || ($this->_ci->input->raw_input_stream !== '');
        if ($_is_ajax || $_is_axios) {
            Collective::response(50004);
            exit;
        }

//        return FALSE;
        redirect('/user/login');
    }
}