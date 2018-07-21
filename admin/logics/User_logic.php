<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   User_logic.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2017-12-13
 */

class User_logic extends Logic {
    public function __construct() {
        parent::__construct();
    }

    /**
     * 判断登录
     * @return bool
     */
    public function is_login() {
        if (isset($_SESSION["ci_user"])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * 设置用户登录信息
     * @param $data
     */
    public function user_login($data) {
        $session = [];

        $_SESSION['ci_user'] = $session;
    }
}