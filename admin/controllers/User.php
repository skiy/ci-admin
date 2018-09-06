<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * File:   User.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018/07/21
 */

/**
 * Class User
 * @property user_logic user_logic
 * @property CI_Pagination pagination
 */
class User extends MY_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->logic('user_logic');
    }

    /**
     * 登录
     */
    public function login() {
        if ($this->method == 'post') {
            $this->login_ajax();
        }

        $is_login = $this->user_logic->is_login();
        if ($is_login) {
            redirect('');
        }

        $response = [
            'username' => $this->input->cookie('ci_username'),
        ];

        $this->load->view('public/header');
        $this->load->view('user/login', $response);
        $this->load->view('public/footer');
    }

    /**
     * 登录AJAX
     */
    private function login_ajax() {
        $account = (string)$this->stream('account');
        $password = (string)$this->stream('password');

        if ($account === '' || $password === '') {
            $this->show_response(50101);
        }

//        $pwd = password_hash($password, PASSWORD_DEFAULT);
//        var_dump($pwd);

        $info = $this->user_logic->get_user('', $account);
        if (empty($info)) {
            $this->show_response(50102);
        }

        //校验密码不通过
        if (! password_verify($password, $info['password'])) {
            $this->show_response(50103);
        }

        //添加管理员登录日志
        $this->user_logic->add_login_log($info['id'], $this->input->ip_address());

        //禁用
        if ($info['status'] != 0) {
            $this->show_response(-50105);
        }

        //设置session
        $session_user = [
            'uid' => $info['id'],
            'name' => $info['name'],
            'level' => $info['level'],
        ];
        $this->user_logic->set_user_data($session_user);

        //记录用户名
        $cookie = [
            'name'   => 'ci_username',
            'value'  => $info['name'],
            'expire' => '86500',
            'domain' => NULL,
            'path'   => '/',
        ];
        $this->input->set_cookie($cookie);

        $this->show_response(0);
    }

    /**
     * 登出
     */
    public function logout() {
        $this->user_logic->rm_user_data();
        redirect('/user/login');
    }

    /**
     * 修改密码
     */
    public function modify_pwd() {
        if ($this->method == 'post') {
            $this->modify_pwd_ajax();
        }

        $response = array();
        $this->load->view('public/header');
        $this->load->view('public/sidebar', $this->sidebar);
        $this->load->view('user/modify_pwd', $response);
        $this->load->view('public/footer');
    }

    /**
     * 修改密码AJAX
     */
    private function modify_pwd_ajax() {
        $password = (string)$this->stream('password');
        $password2 = (string)$this->stream('password2');

        if ($password === '' || $password2 === '') {
            $this->show_response(50106);
        }

        if ($password != $password2) {
            $this->show_response(50107);
        }

        $uid = $_SESSION['ci_user']['uid'];
        $is_updated = $this->user_logic->modify_pwd($uid, $password);
        if ($is_updated) {
            //清除session
            $this->user_logic->rm_user_data();
            $this->show_response(0);
        }

        $this->show_response(50108);
    }

    /**
     * 登录日志
     */
    public function login_log() {
        $lvl = $_SESSION['ci_user']['level'];
        if ($lvl != 1) {
            redirect('/');
        }

        $offset = $this->uri->segment(3, 0);

        $per_page = 3;  //每页显示条数
        $limit = [
            $per_page,
            $offset
        ];


        $data = array();

        $where_ext = array();
        $where = array();

        $counts = $this->user_logic->login_log_list($where, $where_ext, 'rows');
        $account_res = $this->user_logic->login_log_list($where, $where_ext, $limit);
        if (empty($account_res)) {
//            if ($page > 1) {
//                redirect('/user/login_log');
//            }
        } else {
            $data = $account_res;
        }

        $response = [
            'data' => $data,
            'pagination' => Collective::pagination($per_page, $counts, 'user/login_log'),
        ];

        $this->load->view('public/header');
        $this->load->view('public/sidebar', $this->sidebar);
        $this->load->view('user/login_log', $response);
        $this->load->view('public/footer');
    }
}