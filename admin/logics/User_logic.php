<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   User_logic.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2017-12-13
 */

/**
 * Class User_logic
 * @property MY_Loader load
 * @property user_model user_model
 */
class User_logic extends Logic {
    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
    }

    /**
     * 判断登录
     * @return bool
     */
    public function is_login() {
        if (isset($_SESSION['ci_user'])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * 查询账号
     * @param string $uid
     * @param string $name
     * @return mixed
     */
    public function get_user($uid='', $name='') {
        $resp = $this->user_model->get_user($uid, $name);
        return $resp;
    }

    /**
     * 添加管理员登录日志
     * @param $data
     * @return mixed
     */
    public function add_login_log($uid, $login_ip) {
        $location_arr = Collective::get_ip_location($login_ip);
        $location = implode('', $location_arr);
        $data = [
            'uid' => $uid,
            'ip' => $login_ip,
            'address' => $location,
            'created_at' => time(),
        ];
        $resp = $this->user_model->add_login_log($data);
        return $resp;
    }

    /**
     * 设置用户信息
     * @param $user_data
     * @return bool
     */
    public function set_user_data($user_data) {
        if (empty($user_data)) {
            return FALSE;
        }

        $_SESSION['ci_user'] = $user_data;
        return TRUE;
    }

    /**
     * 登出
     * @return bool
     */
    public function rm_user_data() {
        unset($_SESSION['ci_user']);
        session_unset();
        session_destroy();
        return TRUE;
    }

    /**
     * 修改用户信息
     * @param $uid
     * @param $data
     * @param array $where
     * @return mixed
     */
    public function modify_user($uid, $data, $where=array()) {
        $resp = $this->user_model->modify_user($uid, $data, $where);

        if ($resp > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 修改用户密码
     * @param $uid
     * @param $password
     * @return bool
     */
    public function modify_pwd($uid, $password) {
        $data = [
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $resp = $this->user_model->modify_user($uid, $data, []);

        if ($resp > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 登录日志
     * @param $where
     * @param array $where_ext
     * @param array $limit
     * @return mixed
     */
    public function login_log_list($where, $where_ext=array(), $limit=array()) {
        $resp = $this->user_model->login_log_list($where, $where_ext, $limit);
        return $resp;
    }
}